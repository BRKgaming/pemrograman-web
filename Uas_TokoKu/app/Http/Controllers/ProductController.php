<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with('category');
        
        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }
        
        // Filter by search term
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%")
                  ->orWhere('specifications', 'like', "%{$request->search}%");
        }
        
        // Filter by status
        if ($request->has('filter')) {
            if ($request->filter == 'featured') {
                $query->where('is_featured', true);
            } elseif ($request->filter == 'low_stock') {
                $query->whereBetween('stock', [1, 10]);
            } elseif ($request->filter == 'out_of_stock') {
                $query->where('stock', 0);
            }
        }
        
        // Sort products
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'newest':
                    $query->latest();
                    break;
                case 'oldest':
                    $query->oldest();
                    break;
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                case 'stock_low':
                    $query->orderBy('stock', 'asc');
                    break;
                case 'stock_high':
                    $query->orderBy('stock', 'desc');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }
        
        $products = $query->paginate(12)->withQueryString();
        $categories = Category::all();
        
        // For admin view only
        if (Auth::check() && Auth::user()->isAdmin() && $request->is('admin/products*')) {
            $featuredCount = Product::where('is_featured', true)->count();
            $lowStockCount = Product::whereBetween('stock', [1, 10])->count();
            $outOfStockCount = Product::where('stock', 0)->count();
            
            return view('admin.products.index', compact('products', 'categories', 'featuredCount', 'lowStockCount', 'outOfStockCount'));
        }
        
        // Regular user view
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        
        // Jika diakses dari admin panel
        if (request()->is('admin*')) {
            return view('admin.products.create', compact('categories'));
        }
        
        // Jika diakses dari frontend
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'additional_categories' => 'nullable|array',
            'additional_categories.*' => 'exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'stock' => 'required|integer|min:0',
            'is_featured' => 'boolean',
            'specifications' => 'nullable|string',
            'badge' => 'nullable|string|max:50',
            'original_price' => 'nullable|numeric|min:0',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
            
            // Make sure the directory exists
            $directory = public_path('img/products');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            
            $image->move($directory, $imageName);
            $data['image'] = 'img/products/' . $imageName;
        }

        $product = Product::create($data);

        // Add primary category
        $product->categories()->attach($request->category_id, ['is_primary' => true]);

        // Add additional categories if any
        if ($request->has('additional_categories') && is_array($request->additional_categories)) {
            foreach ($request->additional_categories as $categoryId) {
                if ($categoryId != $request->category_id) { // Avoid duplicating the primary category
                    $product->categories()->attach($categoryId, ['is_primary' => false]);
                }
            }
        }

        // Create initial inventory transaction for stock
        if ($request->stock > 0) {
            $product->inventoryTransactions()->create([
                'quantity' => $request->stock,
                'type' => 'in',
                'notes' => 'Stok awal produk',
                'user_id' => auth()->id(),
            ]);
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->with('category')->firstOrFail();
        $relatedProducts = Product::where('category_id', $product->category_id)
                                 ->where('id', '!=', $product->id)
                                 ->take(4)
                                 ->get();
        
        return view('products.show', compact('product', 'relatedProducts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $categories = Category::all();
        
        // If accessed from admin panel
        if (request()->is('admin*')) {
            return view('admin.products.edit', compact('product', 'categories'));
        }
        
        // If accessed from frontend
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'additional_categories' => 'nullable|array',
            'additional_categories.*' => 'exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'stock' => 'required|integer|min:0',
            'is_featured' => 'boolean',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image && file_exists(public_path('img/products/' . $product->image))) {
                unlink(public_path('img/products/' . $product->image));
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img/products'), $imageName);
            $data['image'] = $imageName;
        }

        $product->update($data);
        
        // Update categories
        // First, detach all existing categories
        $product->categories()->detach();
        
        // Add primary category
        $product->categories()->attach($request->category_id, ['is_primary' => true]);
        
        // Add additional categories if any
        if ($request->has('additional_categories') && is_array($request->additional_categories)) {
            foreach ($request->additional_categories as $categoryId) {
                if ($categoryId != $request->category_id) { // Avoid duplicating the primary category
                    $product->categories()->attach($categoryId, ['is_primary' => false]);
                }
            }
        }
        
        // Check if request is from admin
        if (request()->is('admin*')) {
            return redirect()->route('admin.products.index')
                ->with('success', 'Produk berhasil diperbarui.');
        }
        
        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $productName = $product->name;

        // Delete image if exists
        if ($product->image && file_exists(public_path('img/products/' . $product->image))) {
            try {
                unlink(public_path('img/products/' . $product->image));
            } catch (\Exception $e) {
                // Log error but continue with deletion
                \Log::error("Gagal menghapus gambar produk: " . $e->getMessage());
            }
        }

        // Delete the product
        $product->delete();

        // Check if request is from admin
        if (request()->is('admin*')) {
            return redirect()->route('admin.products.index')
                ->with('success', "Produk \"$productName\" berhasil dihapus.");
        }
        
        return redirect()->route('products.index')
            ->with('success', "Produk \"$productName\" berhasil dihapus.");
    }
}
