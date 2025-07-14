@extends('layouts.app')

@section('title', 'TokoKU - Toko Online Terpercaya')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section position-relative overflow-hidden">
        <div class="hero-overlay"></div>
        <div class="container position-relative h-100 d-flex align-items-center" style="z-index: 3;">
            <div class="row w-100 align-items-center">
                <div class="col-lg-6 text-white mb-5 mb-lg-0">
                    <div class="fade-in-left">
                        <h1 class="display-3 fw-bold mb-4">Selamat Datang di <span class="text-warning">TokoKU</span></h1>
                        <p class="lead fs-4 mb-4 text-white-75" style="text-shadow: 0 2px 4px rgba(0,0,0,0.1);">Temukan produk teknologi terbaik dengan kualitas premium dan harga terjangkau. Belanja mudah, cepat, dan aman!</p>
                        <div class="d-flex flex-column flex-sm-row gap-3">
                            <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg px-4 py-3">
                                <i class="fas fa-shopping-bag me-2"></i>Mulai Belanja
                            </a>
                            <a href="{{ route('about') }}" class="btn btn-outline-light btn-lg px-4 py-3">
                                <i class="fas fa-info-circle me-2"></i>Pelajari Lebih Lanjut
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <div class="fade-in-right">
                        <div class="hero-image-container">
                            <img src="{{ asset('img/Logo TokoKU.jpg') }}" class="img-fluid rounded-circle shadow-lg" alt="TokoKU Logo" style="width: 300px; height: 300px; object-fit: cover;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Floating Elements -->
        <div class="floating-elements">
            <div class="floating-element floating-element-1"></div>
            <div class="floating-element floating-element-2"></div>
            <div class="floating-element floating-element-3"></div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3 mb-4">
                    <div class="stat-item fade-in-up">
                        <div class="stat-icon bg-primary text-white rounded-circle mx-auto mb-3">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                        <h3 class="fw-bold text-primary">{{ number_format($totalCustomers) }}+</h3>
                        <p class="text-muted">Pelanggan Puas</p>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="stat-item fade-in-up" style="animation-delay: 0.1s;">
                        <div class="stat-icon bg-success text-white rounded-circle mx-auto mb-3">
                            <i class="fas fa-box fa-2x"></i>
                        </div>
                        <h3 class="fw-bold text-success">{{ number_format($totalProducts) }}+</h3>
                        <p class="text-muted">Produk Tersedia</p>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="stat-item fade-in-up" style="animation-delay: 0.2s;">
                        <div class="stat-icon bg-warning text-white rounded-circle mx-auto mb-3">
                            <i class="fas fa-shipping-fast fa-2x"></i>
                        </div>
                        <h3 class="fw-bold text-warning">24 Jam</h3>
                        <p class="text-muted">Pengiriman Cepat</p>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="stat-item fade-in-up" style="animation-delay: 0.3s;">
                        <div class="stat-icon bg-danger text-white rounded-circle mx-auto mb-3">
                            <i class="fas fa-star fa-2x"></i>
                        </div>
                        <h3 class="fw-bold text-danger">{{ $averageRating }}/5</h3>
                        <p class="text-muted">Rating Pelanggan</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold mb-3">Kategori Populer</h2>
                <p class="text-muted fs-5">Jelajahi berbagai kategori produk terbaik kami</p>
            </div>
            
            <div class="row g-4">
                @foreach($categories as $category)
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('categories.show', $category->slug) }}" class="text-decoration-none">
                        <div class="card category-card h-100 text-center border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="category-icon mb-3">
                                    @if($category->slug == 'gadget')
                                        <i class="fas fa-mobile-alt fa-4x text-primary"></i>
                                    @elseif($category->slug == 'gaming')
                                        <i class="fas fa-gamepad fa-4x text-success"></i>
                                    @elseif($category->slug == 'elektronik')
                                        <i class="fas fa-tv fa-4x text-warning"></i>
                                    @else
                                        <i class="fas fa-laptop fa-4x text-info"></i>
                                    @endif
                                </div>
                                <h4 class="card-title mb-2">{{ $category->name }}</h4>
                                <p class="card-text text-muted">{{ $category->description ?? 'Berbagai produk berkualitas dalam kategori ini' }}</p>
                                <div class="mt-3">
                                    <span class="btn btn-outline-primary">Lihat Produk</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold mb-3">Produk Unggulan</h2>
                <p class="text-muted fs-5">Produk pilihan dengan kualitas terbaik dan harga terjangkau</p>
            </div>
            
            <div class="row g-4">
                @foreach($featuredProducts as $product)
                <div class="col-lg-3 col-md-6">
                    <div class="card product-card h-100 border-0 shadow-sm">
                        @if($product->badge)
                            <div class="badge badge-gradient position-absolute top-0 end-0 m-2 z-index-1">
                                {{ $product->badge }}
                            </div>
                        @endif
                        <div class="card-img-container">
                            <img src="{{ asset($product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                        </div>
                        <div class="card-body p-4">
                            <h5 class="card-title mb-2">{{ $product->name }}</h5>
                            <p class="card-text text-muted small mb-3">{{ $product->specifications }}</p>
                            <div class="price-section mb-3">
                                @if($product->original_price)
                                    <span class="text-decoration-line-through text-muted me-2">{{ $product->getFormattedOriginalPrice() }}</span>
                                @endif
                                <span class="fs-5 fw-bold text-primary">{{ $product->getFormattedPrice() }}</span>
                            </div>
                            <div class="d-grid gap-2">
                                @if($product->stock > 0)
                                    <div class="d-flex gap-2 mb-2">
                                        <button class="btn btn-primary flex-grow-1 tambah-keranjang"
                                            data-id="{{ $product->id }}" 
                                            data-nama="{{ $product->name }}"
                                            data-harga="{{ $product->price }}" 
                                            data-gambar="{{ $product->image }}"
                                            data-variasi="{{ $product->specifications }}">
                                            <i class="fas fa-cart-plus me-1"></i> Keranjang
                                        </button>
                                        <a href="{{ route('orders.checkout', ['product_id' => $product->id, 'quantity' => 1]) }}" 
                                           class="btn btn-success">
                                            <i class="fas fa-bolt me-1"></i> Beli
                                        </a>
                                    </div>
                                    <div class="d-flex gap-2 mt-2">
                                        <a href="{{ route('products.show', $product->slug) }}" class="btn btn-outline-primary flex-fill">
                                            <i class="fas fa-eye me-1"></i> Detail
                                        </a>
                                        @auth
                                        <button class="btn btn-outline-danger toggle-wishlist" title="{{ $product->isInWishlist(Auth::id()) ? 'Hapus dari wishlist' : 'Tambah ke wishlist' }}" data-id="{{ $product->id }}">
                                            <i class="fa{{ $product->isInWishlist(Auth::id()) ? 's' : 'r' }} fa-heart"></i>
                                        </button>
                                        @endauth
                                    </div>
                                @else
                                    <button class="btn btn-secondary mb-2 w-100" disabled>
                                        <i class="fas fa-times me-1"></i> Stok Habis
                                    </button>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('products.show', $product->slug) }}" class="btn btn-outline-primary flex-fill">
                                            <i class="fas fa-eye me-1"></i> Detail
                                        </a>
                                        @auth
                                        <button class="btn btn-outline-danger toggle-wishlist" title="{{ $product->isInWishlist(Auth::id()) ? 'Hapus dari wishlist' : 'Tambah ke wishlist' }}" data-id="{{ $product->id }}">
                                            <i class="fa{{ $product->isInWishlist(Auth::id()) ? 's' : 'r' }} fa-heart"></i>
                                        </button>
                                        @endauth
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="text-center mt-5">
                <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-arrow-right me-2"></i>Lihat Semua Produk
                </a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2 class="display-6 fw-bold mb-3">Bergabunglah dengan {{ number_format($totalCustomers) }}+ Pelanggan Puas!</h2>
                    <p class="lead mb-0">Dapatkan penawaran terbaik dan update produk terbaru langsung ke email Anda</p>
                </div>
                <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                    <div class="d-grid gap-2 d-lg-block">
                        <a href="{{ route('products.index') }}" class="btn btn-light btn-lg">
                            <i class="fas fa-shopping-bag me-2"></i>Mulai Belanja
                        </a>
                        <a href="{{ route('about') }}" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-info-circle me-2"></i>Tentang Kami
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
<style>
    /* Hero Section */
    .hero-section {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
    }
    
    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.3);
        z-index: 1;
    }
    
    .hero-image-container {
        position: relative;
        animation: float 6s ease-in-out infinite;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }
    
    /* Floating Elements */
    .floating-elements {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        z-index: 1;
    }
    
    .floating-element {
        position: absolute;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: floatElements 20s infinite linear;
    }
    
    .floating-element-1 {
        width: 80px;
        height: 80px;
        top: 20%;
        left: 10%;
        animation-delay: 0s;
    }
    
    .floating-element-2 {
        width: 60px;
        height: 60px;
        top: 60%;
        right: 10%;
        animation-delay: -5s;
    }
    
    .floating-element-3 {
        width: 100px;
        height: 100px;
        top: 80%;
        left: 20%;
        animation-delay: -10s;
    }
    
    @keyframes floatElements {
        0% { transform: translateY(0px) rotate(0deg); opacity: 1; }
        100% { transform: translateY(-100vh) rotate(360deg); opacity: 0; }
    }
    
    /* Stats Section */
    .stat-item {
        transition: all 0.3s ease;
    }
    
    .stat-item:hover {
        transform: translateY(-10px);
    }
    
    .stat-icon {
        width: 80px;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }
    
    .stat-item:hover .stat-icon {
        transform: scale(1.1);
    }
    
    /* Category Cards */
    .category-card {
        transition: all 0.3s ease;
        border-radius: 15px;
        overflow: hidden;
        background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
    }
    
    .category-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }
    
    .category-icon {
        transition: all 0.3s ease;
    }
    
    .category-card:hover .category-icon i {
        transform: scale(1.2);
    }
    
    /* Product Cards */
    .product-card {
        transition: all 0.3s ease;
        border-radius: 15px;
        overflow: hidden;
    }
    
    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }
    
    .card-img-container {
        overflow: hidden;
        height: 250px;
        position: relative;
    }
    
    .card-img-top {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: all 0.3s ease;
    }
    
    .product-card:hover .card-img-top {
        transform: scale(1.1);
    }
    
    .price-section {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
    }
    
    /* Responsive Design */
    @media (max-width: 992px) {
        .hero-section {
            min-height: 80vh;
            text-align: center;
        }
        
        .display-3 {
            font-size: 2.5rem;
        }
        
        .hero-image-container img {
            width: 200px !important;
            height: 200px !important;
        }
    }
    
    @media (max-width: 768px) {
        .hero-section {
            min-height: 70vh;
        }
        
        .display-3 {
            font-size: 2rem;
        }
        
        .display-5 {
            font-size: 1.8rem;
        }
        
        .card-img-container {
            height: 200px;
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
        }
        
        .floating-element {
            display: none;
        }
    }
    
    @media (max-width: 576px) {
        .hero-section {
            min-height: 60vh;
        }
        
        .display-3 {
            font-size: 1.8rem;
        }
        
        .hero-image-container img {
            width: 150px !important;
            height: 150px !important;
        }
        
        .card-img-container {
            height: 180px;
        }
    }
    
    /* Button Animations */
    .btn {
        position: relative;
        overflow: hidden;
    }
    
    .btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }
    
    .btn:hover::before {
        left: 100%;
    }
    
    /* Loading State */
    .tambah-keranjang.loading {
        pointer-events: none;
    }
    
    .tambah-keranjang.loading::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 20px;
        height: 20px;
        margin: -10px 0 0 -10px;
        border: 2px solid transparent;
        border-top: 2px solid #fff;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi tooltip Bootstrap
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush
