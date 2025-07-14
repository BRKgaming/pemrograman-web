<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the dashboard
     */
    public function index()
    {
        $user = Auth::user();
        
        // Redirect admin to admin dashboard
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        
        // User dashboard data
        $stats = [
            'total_orders' => Order::where('user_id', $user->id)->count(),
            'pending_orders' => Order::where('user_id', $user->id)->where('status', 'pending')->count(),
            'completed_orders' => Order::where('user_id', $user->id)->where('status', 'delivered')->count(),
            'total_spent' => Order::where('user_id', $user->id)->where('status', 'delivered')->sum('total_amount'),
            'welcome_message' => 'Selamat datang, ' . $user->name . '!',
            'last_login' => now()->format('d F Y, H:i'),
            // Add missing statistics needed by the view
            'total_users' => User::count(),
            'total_products' => Product::count(),
            'total_categories' => Category::count(),
            'featured_products' => Product::where('is_featured', true)->count(),
            // Information about user's address status
            'has_address' => !empty($user->address),
        ];

        // Recent orders
        $recentOrders = Order::where('user_id', $user->id)
            ->with('orderItems.product')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        // Ambil semua produk yang pernah dibeli oleh pengguna
        $purchasedProductIds = Order::where('user_id', $user->id)
            ->with('orderItems.product')
            ->get()
            ->pluck('orderItems')
            ->flatten()
            ->pluck('product_id')
            ->unique();
            
        // Produk yang pernah dibeli pengguna
        $purchasedProducts = Product::whereIn('id', $purchasedProductIds)
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->get();

        // Featured products yang pernah dibeli pengguna
        $featuredProducts = Product::whereIn('id', $purchasedProductIds)
            ->where('is_featured', true)
            ->where('stock', '>', 0)
            ->with('category')
            ->limit(8)
            ->get();
            
        // Recent products for the dashboard - hanya yang pernah dibeli oleh pengguna
        $recentProducts = $purchasedProducts->take(5);

        return view('dashboard.index', compact('stats', 'recentOrders', 'featuredProducts', 'recentProducts', 'purchasedProducts'));
    }
}
