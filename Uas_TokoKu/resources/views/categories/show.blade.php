@extends('layouts.app')

@section('title', $category->name . ' - TokoKU')

@section('content')
  
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold text-primary">{{ $category->name }}</h1>
            <p class="lead">{{ $category->description }}</p>
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
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text text-muted">{{ Str::limit($product->specifications, 50) }}</p>
                            <p class="card-text">
                                @if($product->original_price)
                                    <span class="text-decoration-line-through text-muted">{{ $product->getFormattedOriginalPrice() }}</span>
                                @endif
                                <span class="fs-5 fw-bold text-primary">{{ $product->getFormattedPrice() }}</span>
                            </p>
                            <div class="d-flex gap-2">
                                <button class="btn btn-primary flex-fill tambah-keranjang"
                                    data-id="{{ $product->id }}" 
                                    data-nama="{{ $product->name }}"
                                    data-harga="{{ $product->price }}" 
                                    data-gambar="{{ $product->image }}"
                                    data-variasi="{{ $product->specifications }}">
                                    <i class="fas fa-cart-plus me-1"></i> Keranjang
                                </button>
                                <a href="{{ route('products.show', $product->slug) }}" class="btn btn-outline-primary flex-fill">
                                    <i class="fas fa-eye me-1"></i> Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-box-open fa-5x text-muted mb-3"></i>
                <h3>Belum Ada Produk</h3>
                <p class="text-muted">Produk untuk kategori ini sedang dalam proses penambahan.</p>
                <a href="{{ route('categories.index') }}" class="btn btn-primary">Lihat Kategori Lain</a>
            </div>
        @endif
    </div>
@endsection
