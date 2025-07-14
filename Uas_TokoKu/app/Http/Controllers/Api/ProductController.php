<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Get product details by ID
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        
        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'image' => $product->image,
            'description' => $product->description,
            'specifications' => $product->specifications,
            'stock' => $product->stock
        ]);
    }
}
