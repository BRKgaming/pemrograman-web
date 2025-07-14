<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Menampilkan daftar produk yang disimpan di wishlist pengguna
     */
    public function index()
    {
        $userId = Auth::id();
        $wishlist = Wishlist::where('user_id', $userId)
            ->with('product.category')
            ->latest()
            ->get();
            
        return view('wishlist.index', compact('wishlist'));
    }
    
    /**
     * Menambahkan produk ke wishlist
     */
    public function store(Request $request)
    {
        $userId = Auth::id();
        $productId = $request->product_id;
        
        $existingWishlist = Wishlist::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();
            
        if ($existingWishlist) {
            return redirect()->back()->with('info', 'Produk sudah ada di wishlist Anda.');
        }
        
        Wishlist::create([
            'user_id' => $userId,
            'product_id' => $productId
        ]);
        
        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke wishlist.');
    }
    
    /**
     * Menghapus produk dari wishlist
     */
    public function destroy($id)
    {
        $wishlist = Wishlist::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
            
        $wishlist->delete();
        
        return redirect()->back()->with('success', 'Produk berhasil dihapus dari wishlist.');
    }
    
    /**
     * Toggle wishlist (AJAX)
     */
    public function toggle(Request $request)
    {
        $userId = Auth::id();
        $productId = $request->input('product_id');
        
        if (!$productId) {
            return response()->json([
                'status' => 'error',
                'message' => 'ID produk tidak valid'
            ], 400);
        }
        
        $existingWishlist = Wishlist::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();
            
        if ($existingWishlist) {
            $existingWishlist->delete();
            return response()->json([
                'status' => 'removed',
                'message' => 'Produk dihapus dari wishlist'
            ]);
        } else {
            Wishlist::create([
                'user_id' => $userId,
                'product_id' => $productId
            ]);
            return response()->json([
                'status' => 'added',
                'message' => 'Produk ditambahkan ke wishlist'
            ]);
        }
    }
}
