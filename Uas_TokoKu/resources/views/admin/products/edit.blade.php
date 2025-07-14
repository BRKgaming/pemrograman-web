@extends('layouts.app')

@section('head')
<link rel="stylesheet" href="{{ asset('css/cursor-fix.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/cropperjs@1.5.12/dist/cropper.min.css">
@endsection

@section('title', 'Edit Produk - Admin TokoKU')

@push('styles')
<style>
    .form-label.fw-bold {
        font-size: 0.9rem;
    }
    .form-text {
        font-size: 0.8rem;
    }
    .image-preview-container {
        transition: all 0.3s ease;
        border: 2px dashed #dee2e6 !important;
    }
    .image-preview-container:hover {
        border-color: #6c757d !important;
    }
    .card {
        transition: all 0.3s ease;
    }
    .card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
    .btn-hover-effect {
        transition: all 0.3s ease;
    }
    .btn-hover-effect:hover {
        transform: translateY(-2px);
    }
    .product-info-item {
        padding: 0.75rem 0;
        border-bottom: 1px solid #f8f9fa;
    }
    .product-info-item:last-child {
        border-bottom: none;
    }
    .required-field::after {
        content: ' *';
        color: #dc3545;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <!-- Breadcrumb -->
  
    
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center bg-white p-3 rounded shadow-sm mb-3">
                <div>
                    <h2 class="fw-bold mb-1">Edit Produk</h2>
                    <p class="text-muted mb-0">Perbarui informasi produk #{{ $product->id }} - {{ $product->name }}</p>
                </div>
                <div>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-hover-effect">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Produk
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Success Alert -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                    <i class="fas fa-check-circle fa-lg me-3"></i>
                    <div>
                        <h5 class="alert-heading mb-1">Berhasil!</h5>
                        <p class="mb-0">{{ session('success') }}</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-edit me-2 text-primary"></i>
                        <h5 class="card-title mb-0 fw-bold">Informasi Produk</h5>
                    </div>
                </div>
                <div class="card-body p-4">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            <h5 class="alert-heading fw-bold">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Terdapat kesalahan pada formulir
                            </h5>
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.products.update', $product->slug) }}" method="POST" enctype="multipart/form-data" id="productForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <div class="card border-0 bg-light mb-3">
                                    <div class="card-body">
                                        <h6 class="card-subtitle mb-3 text-muted border-bottom pb-2">
                                            <i class="fas fa-info-circle me-2"></i>Informasi Dasar
                                        </h6>
                                        
                                        <div class="mb-3">
                                            <label for="name" class="form-label fw-bold required-field">Nama Produk</label>
                                            <input type="text" class="form-control form-control-lg" id="name" name="name" 
                                                value="{{ old('name', $product->name) }}" required
                                                placeholder="Masukkan nama produk...">
                                            <div class="form-text">
                                                <i class="fas fa-lightbulb text-warning me-1"></i>
                                                Gunakan nama yang jelas dan deskriptif untuk meningkatkan SEO
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="category_id" class="form-label fw-bold required-field">Kategori</label>
                                            <select class="form-select select2-multiple" id="category_id" name="category_id" required>
                                                <option value="">-- Pilih Kategori Utama --</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="form-text">
                                                <i class="fas fa-info-circle text-info me-1"></i>
                                                Kategori utama produk (akan ditampilkan di halaman produk)
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="additional_categories" class="form-label fw-bold">Kategori Tambahan</label>
                                            <select class="form-select select2-multiple" id="additional_categories" name="additional_categories[]" multiple>
                                                @php
                                                    $additionalCategoryIds = $product->categories()
                                                        ->wherePivot('is_primary', false)
                                                        ->pluck('categories.id')
                                                        ->toArray();
                                                @endphp
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" 
                                                        {{ (is_array(old('additional_categories')) && in_array($category->id, old('additional_categories'))) || 
                                                           in_array($category->id, $additionalCategoryIds) ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="form-text">
                                                <i class="fas fa-info-circle text-info me-1"></i>
                                                Pilih beberapa kategori tambahan (opsional). Gunakan Ctrl+klik atau Cmd+klik untuk memilih banyak
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="card border-0 bg-light mb-3">
                                    <div class="card-body">
                                        <h6 class="card-subtitle mb-3 text-muted border-bottom pb-2">
                                            <i class="fas fa-tag me-2"></i>Informasi Harga
                                        </h6>
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="price" class="form-label fw-bold required-field">Harga Jual (Rp)</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">Rp</span>
                                                    <input type="number" class="form-control" id="price" name="price" 
                                                        value="{{ old('price', $product->price) }}" min="0" step="1000" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="original_price" class="form-label fw-bold">Harga Asli/Coret (Rp)</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">Rp</span>
                                                    <input type="number" class="form-control" id="original_price" name="original_price" 
                                                        value="{{ old('original_price', $product->original_price) }}" min="0" step="1000"
                                                        placeholder="Opsional">
                                                </div>
                                                <div class="form-text">
                                                    <i class="fas fa-info-circle text-info me-1"></i>
                                                    Untuk menampilkan diskon pada produk
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="card border-0 bg-light mb-3">
                                    <div class="card-body">
                                        <h6 class="card-subtitle mb-3 text-muted border-bottom pb-2">
                                            <i class="fas fa-box me-2"></i>Inventaris
                                        </h6>
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="stock" class="form-label fw-bold required-field">Stok</label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" id="stock" name="stock" 
                                                        value="{{ old('stock', $product->stock) }}" min="0" required>
                                                    <span class="input-group-text">Unit</span>
                                                </div>
                                                <div class="form-text">
                                                    <i class="fas fa-info-circle text-info me-1"></i>
                                                    Stok saat ini: {{ $product->stock }} Unit
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="badge" class="form-label fw-bold">Badge Produk</label>
                                                <input type="text" class="form-control" id="badge" name="badge" 
                                                    value="{{ old('badge', $product->badge) }}"
                                                    placeholder="Contoh: Baru, Terlaris, Promo">
                                                <div class="form-text">Opsional, akan ditampilkan di kartu produk</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="card border-0 bg-light mb-3">
                                    <div class="card-body">
                                        <h6 class="card-subtitle mb-3 text-muted border-bottom pb-2">
                                            <i class="fas fa-image me-2"></i>Foto Produk
                                        </h6>
                                        
                                        <div class="mb-3">
                                            <div class="image-preview-container border rounded p-2 text-center mb-3" id="imagePreviewContainer">
                                                <div class="position-relative">
                                                    <img id="imagePreview" src="{{ asset($product->image) }}" alt="{{ $product->name }}" 
                                                        class="img-fluid rounded shadow-sm" style="max-height: 200px;">
                                                    <div class="position-absolute top-0 end-0 p-2">
                                                        <button type="button" class="btn btn-sm btn-light rounded-circle" id="changeImageBtn">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div id="uploadPlaceholder" class="d-flex flex-column align-items-center justify-content-center p-4" style="display: none;">
                                                    <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-2"></i>
                                                    <p class="text-muted mb-0">Klik untuk mengupload gambar baru</p>
                                                </div>
                                            </div>
                                            <input type="file" class="form-control d-none" id="image" name="image" accept="image/*">
                                            <label for="image" class="btn btn-outline-primary w-100 mb-2">
                                                <i class="fas fa-upload me-2"></i>Ubah Gambar
                                            </label>
                                            <div class="form-text text-center">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Format: JPG, PNG, atau GIF. Maksimal 2MB.
                                            </div>
                                        </div>
                                        
                                        <div class="form-check form-switch mt-3">
                                            <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" 
                                                value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                                            <label class="form-check-label fw-bold" for="is_featured">
                                                Tampilkan di Featured
                                            </label>
                                            <div class="form-text">
                                                <i class="fas fa-star text-warning me-1"></i>
                                                Produk akan ditampilkan di bagian unggulan halaman utama
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="card border-0 bg-light mb-3">
                                    <div class="card-body">
                                        <h6 class="card-subtitle mb-3 text-muted border-bottom pb-2">
                                            <i class="fas fa-eye me-2"></i>Status Publikasi
                                        </h6>
                                        
                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-primary btn-lg" id="submitButton">
                                                <i class="fas fa-save me-2"></i>Simpan Perubahan
                                            </button>
                                            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                                                <i class="fas fa-times me-2"></i>Batal
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card border-0 bg-light mb-4">
                            <div class="card-header bg-white">
                                <ul class="nav nav-tabs card-header-tabs" id="productDetailTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="description-tab" data-bs-toggle="tab" 
                                            data-bs-target="#description-tab-pane" type="button" role="tab"
                                            aria-selected="true">
                                            <i class="fas fa-align-left me-2"></i>Deskripsi
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="specifications-tab" data-bs-toggle="tab" 
                                            data-bs-target="#specifications-tab-pane" type="button" role="tab"
                                            aria-selected="false">
                                            <i class="fas fa-list-ul me-2"></i>Spesifikasi
                                        </button>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="productDetailTabsContent">
                                    <div class="tab-pane fade show active" id="description-tab-pane" role="tabpanel" 
                                        aria-labelledby="description-tab" tabindex="0">
                                        
                                        <label for="description" class="form-label fw-bold required-field mb-2">
                                            Deskripsi Produk
                                        </label>
                                        <div class="form-text mb-2">
                                            <i class="fas fa-info-circle text-info me-1"></i>
                                            Deskripsikan produk Anda secara detail dan menarik untuk meningkatkan minat pembeli.
                                        </div>
                                        <textarea class="form-control" id="description" name="description" 
                                            rows="8" required>{{ old('description', $product->description) }}</textarea>
                                    </div>
                                    <div class="tab-pane fade" id="specifications-tab-pane" role="tabpanel" 
                                        aria-labelledby="specifications-tab" tabindex="0">
                                        
                                        <label for="specifications" class="form-label fw-bold mb-2">
                                            Spesifikasi Produk
                                        </label>
                                        <div class="form-text mb-2">
                                            <i class="fas fa-info-circle text-info me-1"></i>
                                            Masukkan detail teknis produk. Format dengan baris baru untuk setiap spesifikasi.
                                        </div>
                                        <textarea class="form-control" id="specifications" name="specifications" 
                                            rows="8" placeholder="Contoh:&#10;Dimensi: 10 x 15 x 5 cm&#10;Berat: 500 gram&#10;Material: Stainless steel&#10;Warna: Hitam, Silver">{{ old('specifications', $product->specifications) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <!-- Card: Product Preview -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-eye me-2 text-primary"></i>Preview Produk
                        </h5>
                        <a href="{{ route('products.show', $product->slug) }}" class="btn btn-sm btn-primary" target="_blank">
                            <i class="fas fa-external-link-alt me-1"></i> Lihat di Toko
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="product-preview-card p-3">
                        <div class="text-center mb-3">
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" 
                                class="img-fluid rounded shadow-sm" style="max-height: 150px;">
                        </div>
                        <h5 class="product-title fw-bold">{{ $product->name }}</h5>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="product-category">
                                <span class="badge bg-info">{{ $product->category->name }}</span>
                                @if($product->is_featured)
                                    <span class="badge bg-warning ms-1">Featured</span>
                                @endif
                            </span>
                            <span class="product-stock">
                                @if($product->stock > 10)
                                    <span class="badge bg-success">{{ $product->stock }} Unit</span>
                                @elseif($product->stock > 0)
                                    <span class="badge bg-warning">{{ $product->stock }} Unit</span>
                                @else
                                    <span class="badge bg-danger">Habis</span>
                                @endif
                            </span>
                        </div>
                        <div class="product-price mb-2">
                            @if($product->original_price)
                                <del class="text-muted me-2">{{ $product->getFormattedOriginalPrice() }}</del>
                            @endif
                            <span class="fw-bold text-primary">{{ $product->getFormattedPrice() }}</span>
                        </div>
                        <p class="product-description text-muted small">
                            {{ Str::limit($product->description, 100) }}
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Card: Product Details -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-info-circle me-2 text-primary"></i>Detail Produk
                    </h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td class="text-muted" width="40%">ID Produk</td>
                                <td><span class="badge bg-secondary">#{{ $product->id }}</span></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Slug URL</td>
                                <td>
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control form-control-sm" value="{{ $product->slug }}" readonly>
                                        <button class="btn btn-outline-secondary" type="button" id="copySlugButton">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">Dibuat pada</td>
                                <td>{{ $product->created_at->format('d M Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Diperbarui</td>
                                <td>{{ $product->updated_at->format('d M Y H:i') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Card: Help & Tips -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body bg-light">
                    <div class="d-flex mb-3">
                        <div class="flex-shrink-0 me-3">
                            <i class="fas fa-lightbulb fa-2x text-warning"></i>
                        </div>
                        <div>
                            <h5 class="card-title fw-bold mb-1">Tips Optimasi Produk</h5>
                            <p class="card-text text-muted small">Beberapa tips untuk meningkatkan performa produk Anda:</p>
                        </div>
                    </div>
                    
                    <ul class="list-group list-group-flush bg-transparent mb-3">
                        <li class="list-group-item bg-transparent px-0 py-2 border-bottom">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span class="small">Gunakan foto produk berkualitas tinggi</span>
                        </li>
                        <li class="list-group-item bg-transparent px-0 py-2 border-bottom">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span class="small">Buat deskripsi produk yang detail dan informatif</span>
                        </li>
                        <li class="list-group-item bg-transparent px-0 py-2 border-bottom">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span class="small">Gunakan kata kunci yang relevan dalam judul dan deskripsi</span>
                        </li>
                    </ul>
                    
                    <div class="d-grid">
                        <a href="{{ route('admin.inventory.index') }}" class="btn btn-outline-primary btn-sm btn-hover-effect">
                            <i class="fas fa-warehouse me-2"></i>Kelola Inventaris Produk
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/cropperjs@1.5.12/dist/cropper.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Category selection handling
        const categorySelect = document.getElementById('category_id');
        const additionalCategoriesSelect = document.getElementById('additional_categories');
        
        if (categorySelect && additionalCategoriesSelect) {
            // When primary category changes, remove it from additional categories if selected
            categorySelect.addEventListener('change', function() {
                const primaryCategoryId = this.value;
                
                // Loop through options in additional categories
                for (let i = 0; i < additionalCategoriesSelect.options.length; i++) {
                    const option = additionalCategoriesSelect.options[i];
                    
                    // If this is the primary category and it's selected in additional, deselect it
                    if (option.value === primaryCategoryId && option.selected) {
                        option.selected = false;
                        createNotification('Kategori utama tidak bisa dipilih sebagai kategori tambahan', 'warning');
                    }
                }
            });
            
            // When additional categories change, prevent selecting the primary category
            additionalCategoriesSelect.addEventListener('change', function() {
                const primaryCategoryId = categorySelect.value;
                
                for (let i = 0; i < this.options.length; i++) {
                    const option = this.options[i];
                    
                    if (option.value === primaryCategoryId && option.selected) {
                        option.selected = false;
                        createNotification('Kategori utama tidak dapat dipilih sebagai kategori tambahan', 'warning');
                    }
                }
            });
        }
        
        // Image preview functionality
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('imagePreview');
        const uploadPlaceholder = document.getElementById('uploadPlaceholder');
        const changeImageBtn = document.getElementById('changeImageBtn');
        
        // Toggle image preview on file selection
        imageInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                    uploadPlaceholder.style.display = 'none';
                    
                    // Show notification
                    createNotification('Gambar baru dipilih! Klik Simpan Perubahan untuk menyimpan.', 'info');
                }
                
                reader.readAsDataURL(this.files[0]);
            }
        });
        
        // Change image button
        if (changeImageBtn) {
            changeImageBtn.addEventListener('click', function() {
                imageInput.click();
            });
        }
        
        // Form submission loading state
        document.getElementById('productForm').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitButton');
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Menyimpan...';
            submitBtn.disabled = true;
            
            // Save notification
            createNotification('Sedang menyimpan perubahan...', 'info');
        });
        
        // Copy slug button
        const copySlugButton = document.getElementById('copySlugButton');
        if (copySlugButton) {
            copySlugButton.addEventListener('click', function() {
                const slugInput = this.previousElementSibling;
                slugInput.select();
                document.execCommand('copy');
                
                // Change button text temporarily
                const originalHTML = this.innerHTML;
                this.innerHTML = '<i class="fas fa-check"></i>';
                this.classList.remove('btn-outline-secondary');
                this.classList.add('btn-success');
                
                // Create notification
                createNotification('Slug berhasil disalin ke clipboard!', 'success');
                
                // Restore button after 2 seconds
                setTimeout(() => {
                    this.innerHTML = originalHTML;
                    this.classList.remove('btn-success');
                    this.classList.add('btn-outline-secondary');
                }, 2000);
            });
        }
        
        // Custom notification function
        function createNotification(message, type = 'info') {
            // Create notification container if it doesn't exist
            let container = document.getElementById('notification-container');
            if (!container) {
                container = document.createElement('div');
                container.id = 'notification-container';
                container.style.position = 'fixed';
                container.style.top = '20px';
                container.style.right = '20px';
                container.style.zIndex = '9999';
                document.body.appendChild(container);
            }
            
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `alert alert-${type} alert-dismissible fade show`;
            notification.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
            
            // Add notification to container
            container.appendChild(notification);
            
            // Auto dismiss after 5 seconds
            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => {
                    container.removeChild(notification);
                }, 300);
            }, 5000);
        }
        
        // Textarea auto resize
        const textareas = document.querySelectorAll('textarea');
        textareas.forEach(textarea => {
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });
            
            // Trigger on load
            textarea.style.height = 'auto';
            textarea.style.height = (textarea.scrollHeight) + 'px';
        });
        
        // Show tab based on URL hash
        const urlHash = window.location.hash;
        if (urlHash) {
            const tab = document.querySelector(`a[href="${urlHash}"]`);
            if (tab) {
                tab.click();
            }
        }
        
        // Add confirmation before leaving page with unsaved changes
        let formChanged = false;
        const formInputs = document.querySelectorAll('#productForm input, #productForm textarea, #productForm select');
        formInputs.forEach(input => {
            input.addEventListener('change', function() {
                formChanged = true;
            });
        });
        
        window.addEventListener('beforeunload', function(e) {
            if (formChanged) {
                e.preventDefault();
                e.returnValue = 'Anda memiliki perubahan yang belum disimpan. Yakin ingin meninggalkan halaman?';
            }
        });
    });
</script>
@endpush
