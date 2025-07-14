<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\InventoryTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function dashboard()
    {
        // Middleware admin sudah memastikan hanya admin yang bisa mengakses halaman ini
        
        // Get statistics
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'processing_orders' => Order::where('status', 'processing')->count(),
            'completed_orders' => Order::where('status', 'delivered')->count(),
            'total_revenue' => Order::where('status', 'delivered')->sum('total_amount'),
            'low_stock_products' => Product::whereRaw('stock <= 10 AND stock > 0')->count(),
            'out_of_stock_products' => Product::where('stock', 0)->count(),
            'available_products' => Product::where('stock', '>', 10)->count(),
            
            // Today's activities
            'today_orders' => Order::whereDate('created_at', Carbon::today())->count(),
            'today_stock_in' => InventoryTransaction::where('type', 'in')
                ->whereDate('created_at', Carbon::today())->count(),
            'today_stock_out' => InventoryTransaction::where('type', 'out')
                ->whereDate('created_at', Carbon::today())->count(),
        ];

        // Recent orders
        $recentOrders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Recent inventory transactions
        $recentInventory = InventoryTransaction::with(['product', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Low stock products
        $lowStockProducts = Product::with('category')
            ->where('stock', '<=', 10)
            ->where('stock', '>', 0)
            ->orderBy('stock', 'asc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'recentInventory', 'lowStockProducts'));
    }

    /**
     * Show all users
     */
    public function users(Request $request)
    {
        // Middleware admin sudah memastikan hanya admin yang bisa mengakses halaman ini
        
        $usersQuery = User::where('role', 'user')->withCount('orders');
        
        // Filter berdasarkan pencarian jika ada
        if ($request->filled('search')) {
            $search = $request->search;
            $usersQuery->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        $users = $usersQuery->orderBy('created_at', 'desc')
                          ->paginate(10)
                          ->withQueryString();

        return view('admin.users.index', compact('users'));
    }
    
    /**
     * Show form to create a new user
     */
    public function createUser()
    {
        return view('admin.users.create');
    }

    /**
     * Store a new user
     */
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'avatar' => 'nullable|image|max:2048',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
        ];

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $userData['avatar'] = $avatarPath;
        }

        $user = User::create($userData);

        return redirect()->route('admin.users')->with('success', 'Pengguna baru berhasil dibuat.');
    }

    /**
     * Show user details
     */
    public function showUser(User $user)
    {
        // Verify user is not admin
        if ($user->role === 'admin') {
            return redirect()->route('admin.users')->with('error', 'Tidak dapat menampilkan detail admin.');
        }
        
        // Get user's recent orders
        $userOrders = $user->orders()->with('orderItems')->latest()->limit(5)->get();
        
        return view('admin.users.show', compact('user', 'userOrders'));
    }

    /**
     * Show the form for editing a user
     */
    public function editUser(User $user)
    {
        // Verify user is not admin
        if ($user->role === 'admin') {
            return redirect()->route('admin.users')->with('error', 'Tidak dapat mengedit admin.');
        }

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update user information
     */
    public function updateUser(Request $request, User $user)
    {
        // Verify user is not admin
        if ($user->role === 'admin') {
            return redirect()->route('admin.users')->with('error', 'Tidak dapat mengedit admin.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required', 
                'string', 
                'email', 
                'max:255', 
                Rule::unique('users')->ignore($user->id)
            ],
            'avatar' => 'nullable|image|max:2048',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
        ]);

        // If changing password
        if ($request->change_password) {
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);
        }

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
        ];

        // Update password if requested
        if ($request->change_password) {
            $userData['password'] = Hash::make($request->password);
        }

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $userData['avatar'] = $avatarPath;
        }

        $user->update($userData);

        return redirect()->route('admin.users.show', $user->id)->with('success', 'Informasi pengguna berhasil diperbarui.');
    }

    /**
     * Delete a user
     */
    public function destroyUser(User $user)
    {
        // Verify user is not admin
        if ($user->role === 'admin') {
            return redirect()->route('admin.users')->with('error', 'Tidak dapat menghapus admin.');
        }

        // Delete avatar if exists
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Delete user
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Pengguna berhasil dihapus.');
    }

    /**
     * Show all orders
     */
    public function orders(Request $request)
    {
        // Middleware admin sudah memastikan hanya admin yang bisa mengakses halaman ini

        // Siapkan query dasar
        $ordersQuery = Order::with(['user', 'orderItems']);

        // Filter berdasarkan status jika ada
        if ($request->filled('status')) {
            $ordersQuery->where('status', $request->status);
        }
        
        // Filter berdasarkan pencarian jika ada
        if ($request->filled('search')) {
            $search = $request->search;
            
            $ordersQuery->where(function($q) use ($search) {
                // Cari berdasarkan ID pesanan
                $q->where('id', 'like', "%{$search}%")
                  // Atau berdasarkan data user
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Urutkan berdasarkan tanggal terbaru
        $orders = $ordersQuery->orderBy('created_at', 'desc')
                             ->paginate(10)
                             ->withQueryString(); // Pertahankan parameter query saat paginasi

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Update order status
     */
    public function updateOrderStatus(Request $request, Order $order)
    {
        // Middleware admin sudah memastikan hanya admin yang bisa mengakses halaman ini

        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->route('admin.orders')->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
