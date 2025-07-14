<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\InventoryTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class InventoryController extends Controller
{
    /**
     * Display inventory transactions
     */
    public function index(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        // Get categories and products for filter dropdowns
        $categories = Category::orderBy('name')->get();
        $productsList = Product::orderBy('name')->get();

        // Build the query with filters
        $query = InventoryTransaction::with(['product.category', 'user']);

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by exact date
        if ($request->filled('date')) {
            $date = Carbon::parse($request->date);
            $query->whereDate('created_at', $date);
        }

        // Filter by date range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $endDate = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('created_at', [$startDate, $endDate]);
        } elseif ($request->filled('start_date')) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $query->whereDate('created_at', '>=', $startDate);
        } elseif ($request->filled('end_date')) {
            $endDate = Carbon::parse($request->end_date)->endOfDay();
            $query->whereDate('created_at', '<=', $endDate);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->whereHas('product', function($q) use ($request) {
                $q->where('category_id', $request->category);
            });
        }

        // Filter by product
        if ($request->filled('product')) {
            $query->where('product_id', $request->product);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('product', function($subQ) use ($search) {
                    $subQ->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('user', function($subQ) use ($search) {
                    $subQ->where('name', 'like', "%{$search}%");
                })
                ->orWhere('notes', 'like', "%{$search}%");
            });
        }

        // Order by latest first
        $query->orderBy('created_at', 'desc');

        // Paginate results
        $transactions = $query->paginate(15)->withQueryString();

        return view('admin.inventory.index', compact('transactions', 'categories', 'productsList'));
    }

    /**
     * Show form for adding stock (barang masuk)
     */
    public function stockIn(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        $products = Product::orderBy('name')->get();
        $selectedProduct = null;
        
        // Pre-select product if provided
        if ($request->filled('product')) {
            $selectedProduct = Product::find($request->product);
        }
        
        return view('admin.inventory.stock-in', compact('products', 'selectedProduct'));
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
        $transaction = InventoryTransaction::create([
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
        
        // Get product details for success message
        $productName = $product->name;

        return redirect()->route('admin.inventory.index')
            ->with('success', "Berhasil menambahkan {$request->quantity} stok untuk produk \"{$productName}\".");
    }

    /**
     * Show form for removing stock (barang keluar)
     */
    public function stockOut(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        $products = Product::where('stock', '>', 0)->orderBy('name')->get();
        $selectedProduct = null;
        
        // Pre-select product if provided
        if ($request->filled('product')) {
            $selectedProduct = Product::find($request->product);
        }
        
        return view('admin.inventory.stock-out', compact('products', 'selectedProduct'));
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
        $productName = $product->name;

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
            ->with('success', "Berhasil mengurangi {$request->quantity} stok dari produk \"{$productName}\".");
    }

    /**
     * Show inventory report
     */
    public function report(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        // Get categories for filtering
        $categories = Category::orderBy('name')->get();
        
        // Build the query with filters
        $query = Product::with(['category', 'inventoryTransactions']);
        
        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        
        // Filter by stock status
        if ($request->filled('filter')) {
            if ($request->filter === 'available') {
                $query->where('stock', '>', 0);
            } elseif ($request->filter === 'low_stock') {
                $query->whereBetween('stock', [1, 10]);
            } elseif ($request->filter === 'out_of_stock') {
                $query->where('stock', 0);
            }
        }
        
        // Search by name
        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }
        
        // Get products and calculate inventory stats
        $products = $query->get()->map(function ($product) {
            $stockIn = $product->inventoryTransactions->where('type', 'in')->sum('quantity');
            $stockOut = $product->inventoryTransactions->where('type', 'out')->sum('quantity');
            $product->stock_in = $stockIn;
            $product->stock_out = $stockOut;
            $product->current_stock = $product->stock; // Use the actual stock from database
            return $product;
        });

        return view('admin.inventory.report', compact('products', 'categories'));
    }
}
