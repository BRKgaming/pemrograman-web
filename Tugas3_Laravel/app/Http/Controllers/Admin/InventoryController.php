<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\InventoryTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    /**
     * Display inventory transactions
     */
    public function index()
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        $transactions = InventoryTransaction::with(['product', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.inventory.index', compact('transactions'));
    }

    /**
     * Show form for adding stock (barang masuk)
     */
    public function stockIn()
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        $products = Product::orderBy('name')->get();
        return view('admin.inventory.stock-in', compact('products'));
    }

    /**
     * Process stock in (barang masuk)
     */
    public function processStockIn(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:500',
        ]);

        // Create inventory transaction
        InventoryTransaction::create([
            'product_id' => $request->product_id,
            'user_id' => Auth::id(),
            'type' => 'in',
            'quantity' => $request->quantity,
            'price' => $request->price,
            'notes' => $request->notes,
        ]);

        // Update product stock
        $product = Product::find($request->product_id);
        $product->increment('stock', $request->quantity);

        return redirect()->route('admin.inventory.index')
            ->with('success', 'Barang masuk berhasil dicatat.');
    }

    /**
     * Show form for removing stock (barang keluar)
     */
    public function stockOut()
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        $products = Product::where('stock', '>', 0)->orderBy('name')->get();
        return view('admin.inventory.stock-out', compact('products'));
    }

    /**
     * Process stock out (barang keluar)
     */
    public function processStockOut(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:500',
        ]);

        $product = Product::find($request->product_id);

        // Check if enough stock
        if ($product->stock < $request->quantity) {
            return back()->withErrors(['quantity' => 'Stok tidak mencukupi. Stok tersedia: ' . $product->stock]);
        }

        // Create inventory transaction
        InventoryTransaction::create([
            'product_id' => $request->product_id,
            'user_id' => Auth::id(),
            'type' => 'out',
            'quantity' => $request->quantity,
            'price' => $product->price,
            'notes' => $request->notes,
        ]);

        // Update product stock
        $product->decrement('stock', $request->quantity);

        return redirect()->route('admin.inventory.index')
            ->with('success', 'Barang keluar berhasil dicatat.');
    }

    /**
     * Show inventory report
     */
    public function report()
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        $products = Product::with(['category', 'inventoryTransactions'])
            ->get()
            ->map(function ($product) {
                $stockIn = $product->inventoryTransactions->where('type', 'in')->sum('quantity');
                $stockOut = $product->inventoryTransactions->where('type', 'out')->sum('quantity');
                $product->stock_in = $stockIn;
                $product->stock_out = $stockOut;
                $product->current_stock = $stockIn - $stockOut;
                return $product;
            });

        return view('admin.inventory.report', compact('products'));
    }
}
