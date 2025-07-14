<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Dashboard Routes (Protected)
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// Admin Routes (Protected - Admin Only)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [\App\Http\Controllers\Admin\AdminController::class, 'users'])->name('users');
    Route::get('/orders', [\App\Http\Controllers\Admin\AdminController::class, 'orders'])->name('orders');
    Route::patch('/orders/{order}/status', [\App\Http\Controllers\Admin\AdminController::class, 'updateOrderStatus'])->name('orders.status');
    
    // Inventory Management
    Route::get('/inventory', [\App\Http\Controllers\Admin\InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/inventory/stock-in', [\App\Http\Controllers\Admin\InventoryController::class, 'stockIn'])->name('inventory.stock-in');
    Route::post('/inventory/stock-in', [\App\Http\Controllers\Admin\InventoryController::class, 'processStockIn'])->name('inventory.process-stock-in');
    Route::get('/inventory/stock-out', [\App\Http\Controllers\Admin\InventoryController::class, 'stockOut'])->name('inventory.stock-out');
    Route::post('/inventory/stock-out', [\App\Http\Controllers\Admin\InventoryController::class, 'processStockOut'])->name('inventory.process-stock-out');
    Route::get('/inventory/report', [\App\Http\Controllers\Admin\InventoryController::class, 'report'])->name('inventory.report');
});

// Order Routes (Protected - User)
Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang', [HomeController::class, 'about'])->name('about');

Route::get('/kategori', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/kategori/{slug}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('/produk', [ProductController::class, 'index'])->name('products.index');
Route::get('/produk/{slug}', [ProductController::class, 'show'])->name('products.show');

// CRUD Routes (Protected)
Route::middleware('auth')->group(function () {
    Route::get('/produk/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/produk', [ProductController::class, 'store'])->name('products.store');
    Route::get('/produk/{slug}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/produk/{slug}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/produk/{slug}', [ProductController::class, 'destroy'])->name('products.destroy');
});

// Route untuk halaman yang sudah ada sebelumnya (compatibility)
Route::get('/gadget', function() {
    return redirect()->route('categories.show', 'gadget');
});

Route::get('/gaming', function() {
    return redirect()->route('categories.show', 'gaming');
});

Route::get('/elektronik', function() {
    return redirect()->route('categories.show', 'elektronik');
});

Route::get('/keranjang', function() {
    return view('cart');
})->name('cart');
