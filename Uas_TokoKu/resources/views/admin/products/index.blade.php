@extends('layouts.app')

@section('title', 'Kelola Produk - Admin TokoKU')

@push('styles')
<!-- CSS Fixes -->
<link rel="stylesheet" href="{{ asset('css/cursor-fix.css') }}">
<link rel="stylesheet" href="{{ asset('css/fullscreen-modal.css') }}">

<!-- Preload Images untuk Mencegah Flicker -->
@foreach($products as $product)
<link rel="preload" href="{{ asset($product->image) }}" as="image">
@endforeach
@endpush

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="fw-bold">Kelola Produk</h2>
                <div>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-1"></i> Dasbor
                    </a>
                    <a href="{{ route('admin.inventory.index') }}" class="btn btn-info text-white me-2">
                        <i class="fas fa-warehouse me-1"></i> Kelola Inventaris
                    </a>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Tambah Produk
                    </a>
                </div>
            </div>
            <p class="text-muted">Kelola semua produk di toko Anda dari sini.</p>
            <hr>
        </div>
    </div>

    <!-- Filter and Search -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('products.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <select name="category" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="sort" class="form-select">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga Terendah</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama A-Z</option>
                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nama Z-A</option>
                        <option value="stock_low" {{ request('sort') == 'stock_low' ? 'selected' : '' }}>Stok Terendah</option>
                        <option value="stock_high" {{ request('sort') == 'stock_high' ? 'selected' : '' }}>Stok Tertinggi</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari nama produk..." value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-2">
                    <select name="filter" class="form-select">
                        <option value="" {{ request('filter') == '' ? 'selected' : '' }}>Semua Status</option>
                        <option value="featured" {{ request('filter') == 'featured' ? 'selected' : '' }}>Featured</option>
                        <option value="low_stock" {{ request('filter') == 'low_stock' ? 'selected' : '' }}>Stok Rendah</option>
                        <option value="out_of_stock" {{ request('filter') == 'out_of_stock' ? 'selected' : '' }}>Stok Habis</option>
                    </select>
                </div>
                <div class="col-12 mt-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary ms-2">
                        <i class="fas fa-sync-alt me-1"></i> Reset Filter
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Products Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center hw-accelerated" role="alert">
                    <div class="me-3">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                    <div>
                        <h5 class="alert-heading mb-1">Berhasil!</h5>
                        <p class="mb-0">{{ session('success') }}</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    
                    <!-- Progress bar untuk auto-dismiss -->
                    <div class="progress position-absolute bottom-0 start-0" style="height: 3px; width: 100%;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%; animation: progress-shrink 5s linear forwards;"></div>
                    </div>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table align-middle table-hover">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" width="60">ID</th>
                            <th scope="col">Produk</th>
                            <th scope="col">Kategori</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Stok</th>
                            <th scope="col">Status</th>
                            <th scope="col" width="220">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="{{ asset($product->image) }}" target="_blank" class="product-img-container me-3 position-relative" data-bs-toggle="tooltip" title="Klik untuk melihat gambar">
                                            <div class="position-absolute top-0 start-0 bg-primary text-white px-1 rounded-bottom" style="font-size: 10px; border-top-left-radius: 8px;">ID: {{ $product->id }}</div>
                                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="product-img rounded shadow-sm">
                                            <div class="img-overlay d-flex align-items-center justify-content-center">
                                                <i class="fas fa-search-plus text-white"></i>
                                            </div>
                                        </a>
                                        <div>
                                            <h6 class="mb-0 fw-semibold">{{ $product->name }}</h6>
                                            <small class="text-muted">{{ Str::limit($product->specifications, 50) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $product->category->name }}</span>
                                </td>
                                <td>
                                    @if($product->original_price)
                                        <span class="text-decoration-line-through text-muted">{{ $product->getFormattedOriginalPrice() }}</span><br>
                                    @endif
                                    <span class="fw-bold text-primary">{{ $product->getFormattedPrice() }}</span>
                                </td>
                                <td>
                                    @if($product->stock > 10)
                                        <span class="badge bg-success">{{ $product->stock }} Unit</span>
                                    @elseif($product->stock > 0)
                                        <span class="badge bg-warning">{{ $product->stock }} Unit</span>
                                    @else
                                        <span class="badge bg-danger">Habis</span>
                                    @endif
                                </td>
                                <td>
                                    @if($product->is_featured)
                                        <span class="badge bg-primary">Featured</span>
                                    @else
                                        <span class="badge bg-secondary">Regular</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group w-100">
                                        <a href="{{ route('products.show', $product->slug) }}" class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.products.edit', $product->slug) }}" class="btn btn-sm btn-outline-secondary" title="Edit Produk">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger no-flicker" 
                                                title="Hapus Produk" 
                                                data-action="delete"
                                                data-toggle="delete-modal"
                                                data-id="{{ $product->id }}"
                                                data-name="{{ $product->name }}"
                                                data-image="{{ asset($product->image) }}"
                                                data-url="{{ route('admin.products.destroy', $product->slug) }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                        <h5>Tidak Ada Produk</h5>
                                        <p class="text-muted">Belum ada produk yang tersedia.</p>
                                        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-1"></i> Tambah Produk Baru
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
    
    <!-- Quick Stats -->
    <div class="row mt-4">
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                            <i class="fas fa-box fa-2x text-primary"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Total Produk</h6>
                            <h4 class="mb-0">{{ $products->total() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3">
                            <i class="fas fa-tag fa-2x text-success"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Featured</h6>
                            <h4 class="mb-0">{{ $featuredCount }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-warning bg-opacity-10 p-3 me-3">
                            <i class="fas fa-exclamation-triangle fa-2x text-warning"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Stok Menipis</h6>
                            <h4 class="mb-0">{{ $lowStockCount }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-danger bg-opacity-10 p-3 me-3">
                            <i class="fas fa-times fa-2x text-danger"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Stok Habis</h6>
                            <h4 class="mb-0">{{ $outOfStockCount }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Single Fullscreen Delete Modal -->
    <div class="modal fullscreen-modal center-modal" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i> Konfirmasi Penghapusan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4 hw-accelerated">
                        <div class="position-relative d-inline-block">
                            <img src="" alt="Product Image" id="delete-product-image" class="img-fluid rounded shadow preloaded-img" style="max-height: 180px;">
                            <div class="position-absolute top-0 start-0 bg-danger text-white px-2 py-1 rounded-bottom" style="border-top-left-radius: 4px;">
                                ID: <span id="delete-product-id"></span>
                            </div>
                        </div>
                        <h5 class="mt-3 mb-0 fw-bold" id="delete-product-name"></h5>
                    </div>
                    
                    <div class="alert alert-warning">
                        <div class="d-flex">
                            <div class="me-3">
                                <i class="fas fa-exclamation-circle fa-2x text-warning"></i>
                            </div>
                            <div>
                                <h6 class="alert-heading">Peringatan!</h6>
                                <p class="mb-0">Apakah Anda yakin ingin menghapus produk ini? Tindakan ini tidak dapat dibatalkan dan akan menghapus:</p>
                                <ul class="mb-0 mt-2">
                                    <li>Data produk dan semua informasinya</li>
                                    <li>Gambar produk dari server</li>
                                    <li>Riwayat inventaris terkait</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Batal
                    </button>
                    <form action="" method="POST" id="delete-product-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger delete-confirm-btn">
                            <i class="fas fa-trash me-1"></i> Hapus Permanen
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table th, .table td {
        vertical-align: middle;
    }
    
    .product-img-container {
        width: 70px;
        height: 70px;
        overflow: hidden;
        border-radius: 8px;
    }
    
    .product-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    tr:hover .product-img {
        transform: scale(1.1);
    }
    
    .btn-group .btn {
        border-radius: 0;
    }
    
    .btn-group .btn:first-child {
        border-top-left-radius: 0.25rem;
        border-bottom-left-radius: 0.25rem;
    }
    
    .btn-group .btn:last-child {
        border-top-right-radius: 0.25rem;
        border-bottom-right-radius: 0.25rem;
    }
    
    /* Fix padding to make page more consistent */
    .container {
        padding-top: 80px;
    }
    
    /* Solusi Anti-Flicker untuk Modal Konfirmasi Hapus */
    
    /* Modal khusus tanpa flicker - full screen overlay */
    .no-flicker-modal {
        will-change: opacity;
        transform: translateZ(0);
        -webkit-transform: translateZ(0);
        backface-visibility: hidden;
        -webkit-backface-visibility: hidden;
        transition: none !important;
        opacity: 1 !important;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1050;
        overflow-x: hidden;
        overflow-y: auto;
        display: none;
    }
    
    /* Menghapus animasi transform pada modal dialog dan posisikan di tengah */
    .no-flicker-modal .modal-dialog {
        transform: none !important;
        -webkit-transform: none !important;
        transition: none !important;
        margin: 1.75rem auto !important; /* Posisi tetap */
        max-width: 500px;
        width: auto;
        position: relative;
    }
    
    /* Menghapus transformasi untuk mencegah flicker */
    .no-transform {
        transform: none !important;
        -webkit-transform: none !important;
        transition: opacity 0.15s linear !important;
    }
    
    /* Memastikan konten tidak bergerak */
    .no-flicker {
        transform: translateZ(0);
        -webkit-transform: translateZ(0);
        backface-visibility: hidden;
        -webkit-backface-visibility: hidden;
        will-change: opacity;
        transition: none !important;
    }
    
    /* Tombol hapus tanpa flicker */
    .no-flicker {
        position: relative;
        transform: translateZ(0);
        -webkit-transform: translateZ(0);
        -webkit-font-smoothing: subpixel-antialiased;
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
    }
    
    /* Preload gambar */
    .preloaded-img {
        -webkit-user-drag: none;
        user-select: none;
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
    }
    
    /* Meningkatkan kinerja gambar */
    img {
        image-rendering: -webkit-optimize-contrast;
    }
    
    /* Bootstrap Modal Fix */
    .modal-backdrop.show {
        opacity: 0.5 !important;
    }
    
    /* Fix untuk backdrop flicker */
    .modal-backdrop {
        background-color: rgba(0,0,0,0.5);
        backdrop-filter: blur(1px);
    }
    
    /* Mencegah body bergeser */
    body.modal-open {
        padding-right: 0 !important;
        overflow: hidden;
    }
    
    /* Menghilangkan transisi yang menyebabkan flicker */
    .fade:not(.show) {
        transition: none;
    }
    
    /* Styles for delete animation */
    .delete-confirm-btn {
        position: relative;
        overflow: hidden;
    }
    
    .delete-confirm-btn::before {
        content: "";
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.2);
        transition: left 0.5s;
    }
    
    .delete-confirm-btn.animate::before {
        left: 100%;
    }
    
    /* Hardware acceleration */
    .hw-accelerated {
        backface-visibility: hidden;
        transform: translateZ(0);
        -webkit-transform: translateZ(0);
        perspective: 1000;
    }
    
    /* Animasi alert success */
    .alert-success {
        animation: fadeInOut 5s;
    }
    
    .alert-success.fade-out {
        opacity: 0;
        transform: translateY(-20px);
        transition: opacity 0.5s, transform 0.5s;
    }
    
    @keyframes fadeInOut {
        0% { opacity: 0; transform: translateY(-20px); }
        10% { opacity: 1; transform: translateY(0); }
        90% { opacity: 1; }
        100% { opacity: 0; }
    }
    
    /* Animasi progress bar untuk notifikasi */
    @keyframes progress-shrink {
        0% { width: 100%; }
        100% { width: 0%; }
    }

    /* Tambahan CSS untuk modal fullscreen */
    .modal-dialog {
        pointer-events: auto;
        max-width: 500px;
        margin: 1.75rem auto;
    }

    /* Memastikan konten modal tetap terlihat dan tidak flicker */
    .modal-content {
        position: relative;
        display: flex;
        flex-direction: column;
        width: 100%;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid rgba(0,0,0,.2);
        border-radius: .3rem;
        outline: 0;
        box-shadow: 0 5px 15px rgba(0,0,0,.5);
        transform: translateZ(0);
        will-change: transform, opacity;
        -webkit-font-smoothing: antialiased;
    }
    
    /* Animasi fade untuk mencegah flicker */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    /* Menambahkan transisi saat modal keluar untuk mencegah flicker */
    .no-flicker-modal {
        transition: opacity 0.15s linear !important;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-hide notifikasi sukses setelah 5 detik
        const successAlert = document.querySelector('.alert-success');
        if (successAlert) {
            setTimeout(() => {
                successAlert.classList.add('fade-out');
                setTimeout(() => {
                    successAlert.style.display = 'none';
                }, 500);
            }, 4500);
        }
        
        // Initialize tooltips
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    });
</script>
@endpush
