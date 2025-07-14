@extends('layouts.app')

@section('title', 'Produk - TokoKU')

@section('content')
    <div class="container py-5">
        <div class="text-center mb-5">
            @if(request('search'))
                <h1 class="display-4 fw-bold text-primary">Hasil Pencarian</h1>
                <p class="lead">Menampilkan hasil pencarian untuk: <strong>"{{ request('search') }}"</strong></p>
                <div class="mb-3">
                    <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Semua Produk
                    </a>
                </div>
            @else
                <h1 class="display-4 fw-bold text-primary">Semua Produk</h1>
                <p class="lead">Temukan produk terbaik untuk kebutuhan Anda</p>
                
                <!-- Search form for products page -->
                <div class="mt-4 mb-4">
                    <form action="{{ route('products.index') }}" method="GET" class="d-flex justify-content-center">
                        <div class="input-group" style="max-width: 500px;">
                            <input type="text" class="form-control" name="search" placeholder="Cari nama produk, deskripsi, atau spesifikasi..." value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search me-1"></i> Cari
                            </button>
                        </div>
                    </form>
                </div>
            @endif
        </div>

        @if($products->count() > 0)
            <div class="row">
                @foreach($products as $product)
                <div class="col-md-3 mb-4">
                    <div class="card h-100 shadow-sm">
                        @if($product->badge)
                            <div class="badge bg-{{ $product->badge == 'Baru' ? 'success' : 'danger' }} position-absolute top-0 end-0 m-2">
                                {{ $product->badge }}
                            </div>
                        @endif
                        <img src="{{ asset($product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <span class="badge bg-secondary mb-2">{{ $product->category->name }}</span>
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text text-muted">{{ Str::limit($product->specifications, 50) }}</p>
                            <p class="card-text">
                                @if($product->original_price)
                                    <span class="text-decoration-line-through text-muted">{{ $product->getFormattedOriginalPrice() }}</span>
                                @endif
                                <span class="fs-5 fw-bold text-primary">{{ $product->getFormattedPrice() }}</span>
                            </p>
                            @if($product->stock > 0)
                                <div class="d-flex gap-2 mb-2">
                                    <button class="btn btn-primary flex-fill tambah-keranjang"
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
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $products->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-box-open fa-5x text-muted mb-3"></i>
                @if(request('search'))
                    <h3>Tidak Ada Produk yang Ditemukan</h3>
                    <p class="text-muted">Tidak ada produk yang cocok dengan kata kunci "{{ request('search') }}".</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">Lihat Semua Produk</a>
                @else
                    <h3>Belum Ada Produk</h3>
                    <p class="text-muted">Produk sedang dalam proses penambahan.</p>
                    <a href="{{ route('home') }}" class="btn btn-primary">Kembali ke Home</a>
                @endif
            </div>
        @endif
    </div>
@endsection
