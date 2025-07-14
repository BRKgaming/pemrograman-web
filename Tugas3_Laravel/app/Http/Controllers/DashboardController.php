<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
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
        ];

        // Recent orders
        $recentOrders = Order::where('user_id', $user->id)
            ->with('orderItems.product')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Featured products
        $featuredProducts = Product::where('is_featured', true)
            ->where('stock', '>', 0)
            ->with('category')
            ->limit(8)
            ->get();

        return view('dashboard.index', compact('stats', 'recentOrders', 'featuredProducts'));
    }
}
