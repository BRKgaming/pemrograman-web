<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $featuredProducts = Product::where('is_featured', true)->with('category')->take(4)->get();
        
        // Mengambil data untuk Stats Section secara dinamis
        $totalCustomers = \App\Models\User::where('role', 'customer')->count();
        $totalProducts = \App\Models\Product::count();
        
        // Menggunakan try-catch untuk menghindari error jika kolom belum ada atau tabel masih kosong
        try {
            // Periksa dulu apakah kolom rating ada di tabel orders
            if (Schema::hasColumn('orders', 'rating')) {
                $averageRating = \DB::table('orders')
                    ->whereNotNull('rating')
                    ->avg('rating') ?? 0;
            } else {
                $averageRating = 0;
            }
        } catch (\Exception $e) {
            // Jika terjadi error, set nilai default
            $averageRating = 0;
        }
        
        $averageRating = number_format($averageRating, 1);
        
        return view('home', compact('categories', 'featuredProducts', 
            'totalCustomers', 'totalProducts', 'averageRating'));
    }

    public function about()
    {
        return view('about');
    }
}
