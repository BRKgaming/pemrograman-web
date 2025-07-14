@extends('layouts.app')

@section('title', 'Wishlist Saya - TokoKU')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h2">
                <i class="fas fa-heart text-danger"></i> Wishlist Saya
            </h1>
            <p class="text-muted">Daftar produk yang Anda simpan untuk dilihat nanti.</p>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('info'))
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        {{ session('info') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        @if($wishlist->count() > 0)
            @foreach($wishlist as $item)
                <div class="col-lg-3 col-md-4 col-6 mb-4">
                    <div class="card h-100 border-0 shadow-sm product-card">
                        <div class="position-relative">
                            @if($item->product->badge)
                            <span class="badge bg-danger position-absolute top-0 start-0 mt-2 ms-2">{{ $item->product->badge }}</span>
                            @endif
                            
                            <form action="{{ route('wishlist.destroy', $item->id) }}" method="POST" class="position-absolute top-0 end-0 mt-2 me-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger rounded-circle" title="Hapus dari wishlist">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            
                            <a href="{{ route('products.show', $item->product->slug) }}">
                                @if($item->product->image)
                                <img src="{{ asset($item->product->image) }}" class="card-img-top" alt="{{ $item->product->name }}">
                                @else
                                <div class="card-img-top bg-light text-center py-4">
                                    <i class="fas fa-image text-muted fa-3x"></i>
                                </div>
                                @endif
                            </a>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="{{ route('products.show', $item->product->slug) }}" class="text-dark text-decoration-none">{{ $item->product->name }}</a>
                            </h5>
                            <p class="text-muted small">{{ $item->product->category->name }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="text-primary fw-bold">{{ $item->product->getFormattedPrice() }}</span>
                                    @if($item->product->original_price)
                                    <span class="text-muted text-decoration-line-through ms-2 small">{{ $item->product->getFormattedOriginalPrice() }}</span>
                                    @endif
                                </div>
                                <span class="badge bg-{{ $item->product->stock > 0 ? 'success' : 'danger' }}">
                                    {{ $item->product->stock > 0 ? 'Tersedia' : 'Habis' }}
                                </span>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0 pt-0">
                            <div class="d-grid gap-2">
                                <a href="{{ route('products.show', $item->product->slug) }}" class="btn btn-primary">
                                    <i class="fas fa-eye me-1"></i> Detail
                                </a>
                                @if($item->product->stock > 0)
                                <a href="{{ route('orders.checkout', ['product_id' => $item->product->id, 'quantity' => 1]) }}" class="btn btn-success">
                                    <i class="fas fa-bolt me-1"></i> Beli
                                </a>
                                @else
                                <button class="btn btn-secondary" disabled>
                                    <i class="fas fa-times me-1"></i> Stok Habis
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12 text-center py-5">
                <div class="py-5">
                    <i class="fas fa-heart text-muted fa-4x mb-4"></i>
                    <h3>Wishlist Anda kosong</h3>
                    <p class="text-muted">Belum ada produk yang Anda simpan ke wishlist.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-shopping-bag"></i> Jelajahi Produk
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    .product-card {
        transition: transform 0.3s;
    }
    .product-card:hover {
        transform: translateY(-5px);
    }
</style>
@endpush
