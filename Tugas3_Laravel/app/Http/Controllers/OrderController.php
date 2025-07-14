<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display user's orders
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('orderItems.product')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Show checkout form
     */
    public function checkout()
    {
        // You can implement cart logic here
        // For now, let's assume we have a simple checkout
        return view('orders.checkout');
    }

    /**
     * Process order
     */
    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'shipping_address' => 'required|string|max:1000',
            'notes' => 'nullable|string|max:500',
        ]);

        DB::transaction(function () use ($request) {
            // Calculate total
            $totalAmount = 0;
            $orderItems = [];

            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);
                
                // Check stock
                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Stok produk {$product->name} tidak mencukupi");
                }

                $subtotal = $product->price * $item['quantity'];
                $totalAmount += $subtotal;

                $orderItems[] = [
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                ];

                // Update stock
                $product->decrement('stock', $item['quantity']);
            }

            // Create order
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => Auth::id(),
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'shipping_address' => $request->shipping_address,
                'notes' => $request->notes,
            ]);

            // Create order items
            foreach ($orderItems as $item) {
                $order->orderItems()->create($item);
            }
        });

        return redirect()->route('orders.index')
            ->with('success', 'Pesanan berhasil dibuat!');
    }

    /**
     * Show order details
     */
    public function show(Order $order)
    {
        // Make sure user can only see their own orders
        if ($order->user_id !== Auth::id()) {
            return redirect()->route('orders.index')
                ->with('error', 'Order tidak ditemukan.');
        }

        $order->load('orderItems.product');

        return view('orders.show', compact('order'));
    }

    /**
     * Cancel order
     */
    public function cancel(Order $order)
    {
        // Make sure user can only cancel their own orders
        if ($order->user_id !== Auth::id()) {
            return redirect()->route('orders.index')
                ->with('error', 'Order tidak ditemukan.');
        }

        // Only pending orders can be cancelled
        if ($order->status !== 'pending') {
            return redirect()->route('orders.index')
                ->with('error', 'Order tidak dapat dibatalkan.');
        }

        DB::transaction(function () use ($order) {
            // Restore stock
            foreach ($order->orderItems as $item) {
                $item->product->increment('stock', $item->quantity);
            }

            // Update order status
            $order->update(['status' => 'cancelled']);
        });

        return redirect()->route('orders.index')
            ->with('success', 'Order berhasil dibatalkan.');
    }
}
