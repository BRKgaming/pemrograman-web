@extends('layouts.app')

@section('title', 'Kategori - TokoKU')

@section('content')
    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold text-primary">Kategori Produk</h1>
            <p class="lead">Temukan produk sesuai dengan kebutuhan Anda</p>
        </div>

        <div class="row">
            @foreach($categories as $category)
            <div class="col-md-4 mb-4">
                <a href="{{ route('categories.show', $category->slug) }}" class="text-decoration-none">
                    <div class="card h-100 shadow-sm category-card">
                        <div class="card-body text-center">
                            <i class="fas fa-laptop fa-4x text-primary mb-3"></i>
                            <h4 class="card-title">{{ $category->name }}</h4>
                            <p class="card-text text-muted">{{ $category->description }}</p>
                            <span class="badge bg-primary">{{ $category->products_count }} Produk</span>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
@endsection

@push('styles')
<style>
    .category-card {
        transition: all 0.3s ease;
        border: none;
    }
    
    .category-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 30px rgba(0,123,255,0.2) !important;
    }
</style>
@endpush
