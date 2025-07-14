@extends('layouts.app')

@section('title', $product->name . ' - TokoKU')

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle quantity buttons
        const quantityInput = document.getElementById('quantity');
        const decreaseBtn = document.getElementById('decreaseQuantity');
        const increaseBtn = document.getElementById('increaseQuantity');
        
        if (quantityInput && decreaseBtn && increaseBtn) {
            decreaseBtn.addEventListener('click', function() {
                const currentValue = parseInt(quantityInput.value) || 1;
                if (currentValue > 1) {
                    quantityInput.value = currentValue - 1;
                }
            });
            
            increaseBtn.addEventListener('click', function() {
                const currentValue = parseInt(quantityInput.value) || 1;
                const maxValue = parseInt(quantityInput.getAttribute('max')) || 100;
                if (currentValue < maxValue) {
                    quantityInput.value = currentValue + 1;
                }
            });
        }
    });
</script>
@endpush

@section('content')
    <div class="container py-5">
        <div class="mb-3">
            <a href="javascript:history.back()" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
        
        <div class="row">
            <!-- Product Image -->
            <div class="col-md-6 mb-4 pt-2">
                <div class="position-relative">
                    @if($product->badge)
                        <div class="badge bg-{{ $product->badge == 'Baru' ? 'success' : 'danger' }} position-absolute top-0 end-0 m-3" style="z-index: 10;">
                            {{ $product->badge }}
                        </div>
                    @endif
                    <img src="{{ asset($product->image) }}" class="img-fluid rounded shadow" alt="{{ $product->name }}">
                </div>
            </div>

            <!-- Product Details -->
            <div class="col-md-6">
                <span class="badge bg-primary mb-2">{{ $product->category->name }}</span>
                <h1 class="display-5 fw-bold">{{ $product->name }}</h1>
                <p class="lead text-muted mb-4">{{ $product->specifications }}</p>

                <div class="mb-4">
                    <div class="d-flex align-items-center mb-2">
                        @if($product->original_price)
                            <span class="text-decoration-line-through text-muted me-3 h5">{{ $product->getFormattedOriginalPrice() }}</span>
                            <span class="badge bg-danger">Hemat {{ $product->getDiscountPercentage() }}%</span>
                        @endif
                    </div>
                    <span class="display-6 fw-bold text-primary">{{ $product->getFormattedPrice() }}</span>
                </div>

                <div class="mb-4">
                    <h5>Deskripsi Produk</h5>
                    <p>{{ $product->description }}</p>
                </div>

                <div class="mb-4">
                    <h5>Spesifikasi</h5>
                    <p class="text-muted">{{ $product->specifications }}</p>
                </div>

                <div class="mb-4">
                    <div class="row">
                        <div class="col-sm-6">
                            <strong>Kategori:</strong> {{ $product->category->name }}
                        </div>
                        <div class="col-sm-6">
                            <strong>Stok:</strong> 
                            @if($product->stock > 0)
                                <span class="text-success">{{ $product->stock }} tersedia</span>
                            @else
                                <span class="text-danger">Habis</span>
                            @endif
                        </div>
                    </div>
                </div>

                @if($product->stock > 0)
                <div class="mb-4">
                    <form id="buyNowForm" action="{{ route('orders.checkout') }}" method="GET">
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <label for="quantity" class="form-label mb-0"><strong>Jumlah:</strong></label>
                            </div>
                            <div class="col-auto">
                                <div class="input-group" style="width: 130px;">
                                    <button type="button" class="btn btn-outline-secondary" id="decreaseQuantity">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" class="form-control text-center" id="quantity" name="quantity" 
                                        value="1" min="1" max="{{ $product->stock }}">
                                    <button type="button" class="btn btn-outline-secondary" id="increaseQuantity">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                @endif

                <div class="d-grid gap-2 d-md-flex">
                    @if($product->stock > 0)
                        <button class="btn btn-outline-primary btn-lg me-md-2 tambah-keranjang"
                            data-id="{{ $product->id }}" 
                            data-nama="{{ $product->name }}"
                            data-harga="{{ $product->price }}" 
                            data-gambar="{{ $product->image }}"
                            data-variasi="{{ $product->specifications }}">
                            <i class="fas fa-cart-plus me-1"></i> Tambah ke Keranjang
                        </button>
                        <button type="button" onclick="document.getElementById('buyNowForm').submit();" class="btn btn-success btn-lg">
                            <i class="fas fa-bolt me-1"></i> Beli Sekarang
                        </button>
                    @else
                        <button class="btn btn-secondary btn-lg" disabled>
                            <i class="fas fa-times me-1"></i> Stok Habis
                        </button>
                    @endif
                    
                    @auth
                        <button class="btn btn-outline-danger btn-lg toggle-wishlist" data-id="{{ $product->id }}">
                            <i class="fas fa-heart {{ $product->isInWishlist(Auth::id()) ? 'text-danger' : '' }} me-2"></i>
                            <span class="wishlist-text">{{ $product->isInWishlist(Auth::id()) ? 'Hapus dari Wishlist' : 'Tambahkan ke Wishlist' }}</span>
                        </button>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-danger btn-lg">
                            <i class="far fa-heart me-2"></i>Login untuk Wishlist
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
            <div class="mt-5">
                <h3 class="mb-4">Produk Serupa</h3>
                <div class="row">
                    @foreach($relatedProducts as $relatedProduct)
                    <div class="col-md-3 mb-4">
                        <div class="card h-100 shadow-sm">
                            @if($relatedProduct->badge)
                                <div class="badge bg-{{ $relatedProduct->badge == 'Baru' ? 'success' : 'danger' }} position-absolute top-0 end-0 m-2">
                                    {{ $relatedProduct->badge }}
                                </div>
                            @endif
                            <img src="{{ asset($relatedProduct->image) }}" class="card-img-top" alt="{{ $relatedProduct->name }}" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h6 class="card-title">{{ $relatedProduct->name }}</h6>
                                <p class="card-text">
                                    <span class="fw-bold text-primary">{{ $relatedProduct->getFormattedPrice() }}</span>
                                </p>
                                <a href="{{ route('products.show', $relatedProduct->slug) }}" class="btn btn-outline-primary btn-sm">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
