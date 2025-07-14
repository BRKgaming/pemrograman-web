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
     * Menampilkan daftar pesanan pengguna
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
     * Menampilkan formulir checkout
     */
    public function checkout(Request $request)
    {
        // Variabel untuk menonaktifkan fitur checkout jika diperlukan
        // Set ke true untuk menampilkan pesan bahwa fitur belum tersedia
        $checkoutDisabled = false;
        
        // Jika fitur checkout dinonaktifkan
        if ($checkoutDisabled) {
            return view('orders.checkout', ['checkoutDisabled' => true]);
        }
        
        // Jika ada product_id di request, ini adalah checkout langsung dari produk
        // Jika tidak, ini adalah checkout dari keranjang
        if ($request->has('product_id') && $request->has('quantity')) {
            $product = Product::findOrFail($request->product_id);
            $quantity = (int) $request->quantity;
            
            // Validasi stok
            if ($product->stock < $quantity) {
                return redirect()->back()->with('error', 'Stok produk tidak mencukupi.');
            }
            
            // Meneruskan product_id dan quantity ke view melalui query string
            return view('orders.checkout', [
                'directProduct' => $product,
                'directQuantity' => $quantity
            ]);
        }
        
        return view('orders.checkout');
    }

    /**
     * Memproses pesanan
     */
    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'shipping_name' => 'required|string|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:1000',
            'shipping_city' => 'required|string|max:100',
            'shipping_postal_code' => 'required|string|max:10',
            'shipping_method' => 'required|in:regular,express',
            'payment_method' => 'required|in:transfer,wallet,cod',
            'notes' => 'nullable|string|max:500',
        ]);

        $orderNumber = '';
        
        DB::transaction(function () use ($request, &$orderNumber) {
            // Menghitung total
            $totalAmount = 0;
            $orderItems = [];

            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);
                
                // Memeriksa ketersediaan stok
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

                // Memperbarui stok
                $product->decrement('stock', $item['quantity']);
            }

            // Membuat pesanan baru
            $shippingAddress = [
                $request->shipping_name,
                $request->shipping_phone,
                $request->shipping_address,
                $request->shipping_city,
                $request->shipping_postal_code
            ];
            
            // Calculate shipping cost based on selected method
            $shippingCost = $request->shipping_method === 'express' ? 20000 : 10000;
            
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => Auth::id(),
                'total_amount' => $totalAmount + $shippingCost,
                'shipping_cost' => $shippingCost,
                'shipping_method' => $request->shipping_method,
                'status' => 'pending',
                'shipping_address' => implode(' | ', $shippingAddress),
                'payment_method' => $request->payment_method,
                'notes' => $request->notes,
            ]);
            
            // Simpan nomor pesanan untuk digunakan di luar transaction
            $orderNumber = $order->order_number;

            // Membuat item pesanan
            foreach ($orderItems as $item) {
                $order->orderItems()->create($item);
            }
        });

        return redirect()->route('orders.index')
            ->with('success', 'Pesanan #' . $orderNumber . ' berhasil dibuat! Terima kasih telah berbelanja di toko kami. Silakan lakukan pembayaran sesuai dengan metode pembayaran yang Anda pilih.');
    }

    /**
     * Menampilkan detail pesanan
     */
    public function show(Order $order)
    {
        // Memastikan pengguna hanya dapat melihat pesanan mereka sendiri
        if ($order->user_id !== Auth::id()) {
            return redirect()->route('orders.index')
                ->with('error', 'Pesanan tidak ditemukan.');
        }

        $order->load('orderItems.product');

        return view('orders.show', compact('order'));
    }

    /**
     * Membatalkan pesanan
     */
    public function cancel(Order $order)
    {
        // Memastikan pengguna hanya dapat membatalkan pesanan mereka sendiri
        if ($order->user_id !== Auth::id()) {
            return redirect()->route('orders.index')
                ->with('error', 'Pesanan tidak ditemukan.');
        }

        // Hanya pesanan dengan status pending yang dapat dibatalkan
        if ($order->status !== 'pending') {
            return redirect()->route('orders.index')
                ->with('error', 'Pesanan tidak dapat dibatalkan.');
        }

        DB::transaction(function () use ($order) {
            // Mengembalikan stok
            foreach ($order->orderItems as $item) {
                $item->product->increment('stock', $item->quantity);
            }

            // Memperbarui status pesanan
            $order->update(['status' => 'cancelled']);
        });

        return redirect()->route('orders.index')
            ->with('success', 'Pesanan berhasil dibatalkan.');
    }
}
