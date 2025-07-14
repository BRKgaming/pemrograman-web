@extends('layouts.app')

@section('head')
<link rel="stylesheet" href="{{ asset('css/cursor-fix.css') }}">
@endsection

@section('title', 'Tambah Produk Baru - Admin TokoKU')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="fw-bold">Tambah Produk Baru</h2>
                <div>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Produk
                    </a>
                </div>
            </div>
            <p class="text-muted">Isi formulir berikut untuk menambahkan produk baru ke katalog toko.</p>
            <hr>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
                        @csrf
                        
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="name" class="form-label fw-bold">Nama Produk <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                                    <div class="form-text">Masukkan nama produk yang jelas dan deskriptif.</div>
                                </div>

                                <div class="mb-3">
                                    <label for="category_id" class="form-label fw-bold">Kategori Utama <span class="text-danger">*</span></label>
                                    <select class="form-select select2-multiple" id="category_id" name="category_id" required>
                                        <option value="">-- Pilih Kategori Utama --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" 
                                                {{ (is_array(old('additional_categories')) && in_array($category->id, old('additional_categories'))) ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="form-text">
                                        <i class="fas fa-info-circle text-info me-1"></i>
                                        Pilih beberapa kategori tambahan (opsional). Gunakan Ctrl+klik atau Cmd+klik untuk memilih banyak
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="price" class="form-label fw-bold">Harga (Rp) <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="price" name="price" value="{{ old('price') }}" min="0" step="1000" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="original_price" class="form-label fw-bold">Harga Asli/Coret (Rp)</label>
                                        <input type="number" class="form-control" id="original_price" name="original_price" value="{{ old('original_price') }}" min="0" step="1000">
                                        <div class="form-text">Opsional, untuk menampilkan diskon.</div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="stock" class="form-label fw-bold">Stok Awal <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock', 0) }}" min="0" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="badge" class="form-label fw-bold">Badge Produk</label>
                                        <input type="text" class="form-control" id="badge" name="badge" value="{{ old('badge') }}">
                                        <div class="form-text">Contoh: "Baru", "Terlaris", dll (opsional).</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="image" class="form-label fw-bold">Foto Produk <span class="text-danger">*</span></label>
                                    <div class="mb-2">
                                        <div class="image-preview-container border rounded p-2 text-center mb-2" id="imagePreviewContainer" style="height: 250px; background-color: #f8f9fa;">
                                            <img id="imagePreview" src="" alt="Preview" style="max-width: 100%; max-height: 240px; display: none;">
                                            <div id="uploadPlaceholder" class="d-flex flex-column align-items-center justify-content-center h-100">
                                                <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-2"></i>
                                                <p class="text-muted mb-0">Klik untuk mengupload gambar</p>
                                            </div>
                                        </div>
                                        <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                                    </div>
                                    <div class="form-text">Format: JPG, PNG, atau GIF. Maksimal 2MB.</div>
                                </div>
                                
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_featured">Tampilkan di Featured</label>
                                    <div class="form-text">Produk unggulan akan ditampilkan di halaman utama.</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold">Deskripsi Produk <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
                            <div class="form-text">Deskripsikan produk Anda secara detail dan menarik.</div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="specifications" class="form-label fw-bold">Spesifikasi Produk</label>
                            <textarea class="form-control" id="specifications" name="specifications" rows="5">{{ old('specifications') }}</textarea>
                            <div class="form-text">Detail teknis produk. Format dengan baris baru untuk setiap spesifikasi.</div>
                        </div>
                        
                        <div class="text-end">
                            <button type="reset" class="btn btn-light me-2" id="resetButton">
                                <i class="fas fa-undo me-1"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-primary" id="submitButton">
                                <i class="fas fa-save me-1"></i> Simpan Produk
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="card-title mb-3"><i class="fas fa-info-circle me-2"></i> Panduan Tambah Produk</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0">
                            <div class="d-flex">
                                <div class="me-2 text-primary"><i class="fas fa-check-circle"></i></div>
                                <div>
                                    <strong>Nama Produk</strong>
                                    <p class="text-muted small mb-0">Buat nama produk yang jelas dan mudah dicari.</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex">
                                <div class="me-2 text-primary"><i class="fas fa-check-circle"></i></div>
                                <div>
                                    <strong>Foto Produk</strong>
                                    <p class="text-muted small mb-0">Upload foto produk dengan latar belakang putih dan pencahayaan yang baik.</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex">
                                <div class="me-2 text-primary"><i class="fas fa-check-circle"></i></div>
                                <div>
                                    <strong>Harga</strong>
                                    <p class="text-muted small mb-0">Harga harus sesuai dengan kualitas produk.</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex">
                                <div class="me-2 text-primary"><i class="fas fa-check-circle"></i></div>
                                <div>
                                    <strong>Deskripsi</strong>
                                    <p class="text-muted small mb-0">Berikan deskripsi produk yang lengkap dan informatif.</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="card border-0 shadow-sm mb-4 bg-primary bg-opacity-10 border-primary">
                <div class="card-body p-4">
                    <h5 class="card-title mb-3"><i class="fas fa-lightbulb me-2 text-primary"></i> Tips</h5>
                    <p class="card-text">Untuk manajemen stok produk, silakan gunakan fitur <strong>Kelola Inventaris</strong> setelah produk dibuat.</p>
                    <a href="{{ route('admin.inventory.index') }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-warehouse me-1"></i> Ke Halaman Inventaris
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Dasar-dasar styling */
    html, body {
        scroll-behavior: smooth;
    }
    
    /* Memperbaiki masalah kedipan kursor */
    * {
        cursor: default;
    }
    
    a, button, input[type="button"], input[type="submit"], input[type="reset"], 
    .btn, .clickable, [role="button"] {
        cursor: pointer !important;
    }
    
    input[type="text"], input[type="number"], input[type="email"], 
    input[type="password"], input[type="search"], textarea, select, 
    .form-control {
        cursor: text !important;
    }
    
    select, select.form-control, select.form-select {
        cursor: pointer !important;
    }
    
    /* Perbaikan elemen khusus */
    .image-preview-container {
        cursor: pointer !important;
        transition: all 0.3s ease;
        position: relative;
        user-select: none; /* Prevents text selection */
        -webkit-tap-highlight-color: transparent; /* Removes tap highlight on mobile */
        -webkit-user-drag: none; /* Prevents dragging on WebKit browsers */
    }
    
    .image-preview-container:hover {
        background-color: #e9ecef !important;
    }
    
    .image-preview-container:active {
        transform: scale(0.98);
    }
    
    /* Smooth transitions for image preview */
    #imagePreview {
        transition: opacity 0.3s ease;
        opacity: 1;
        -webkit-user-drag: none; /* Prevents dragging which can cause flickering */
        user-select: none; /* Prevents selection which can cause flickering */
        pointer-events: none; /* Prevents mouse events which can cause flickering */
    }
    
    #uploadPlaceholder {
        transition: opacity 0.3s ease;
        opacity: 1;
        pointer-events: none; /* Prevents mouse events which can cause flickering */
    }
    
    /* Fix button flickering */
    button, .btn {
        transform: translateZ(0); /* Hardware acceleration */
        backface-visibility: hidden;
        -webkit-font-smoothing: subpixel-antialiased;
        touch-action: manipulation; /* Prevents double tap-to-zoom on mobile */
    }
    
    button:focus, .btn:focus {
        outline: none;
    }
    
    /* Smooth form transitions */
    input, select, textarea {
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
        -webkit-font-smoothing: antialiased;
    }
    
    .form-control:focus {
        transition: all 0.2s ease;
    }
    
    /* Stabilize page layout */
    .container {
        transform: translateZ(0); /* Enables hardware acceleration */
        will-change: transform; /* Hints the browser about properties that will change */
    }
    
    /* Mencegah flash of unstyled content */
    .container {
        opacity: 1;
        animation: fadeIn 0.2s ease-in-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
</style>
@endpush

@push('scripts')
<script src="{{ asset('js/cursor-fix.js') }}"></script>
<script>
    // Fungsi untuk mendeteksi perangkat mobile
    function isMobileDevice() {
        return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    }
    
    // Fungsi untuk memperhalus kedipan
    function stabilizeCursor() {
        // Mencegah seleksi teks yang bisa menyebabkan kedipan kursor
        document.body.style.webkitUserSelect = 'none';
        document.body.style.userSelect = 'none';
        
        // Mengembalikan seleksi teks untuk input dan textarea
        const textInputs = document.querySelectorAll('input[type="text"], input[type="email"], input[type="password"], textarea');
        textInputs.forEach(input => {
            input.style.webkitUserSelect = 'text';
            input.style.userSelect = 'text';
        });
        
        // Nonaktifkan outline saat klik
        document.addEventListener('mousedown', function(e) {
            if (e.target.tagName !== 'INPUT' && e.target.tagName !== 'TEXTAREA' && e.target.tagName !== 'SELECT') {
                e.preventDefault();
            }
        }, {passive: false});
    }
    
    // Fungsi utama saat DOM siap
    document.addEventListener('DOMContentLoaded', function() {
        // Stabilisasi cursor jika bukan perangkat mobile
        if (!isMobileDevice()) {
            stabilizeCursor();
        }
        
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
                        alert('Kategori utama tidak bisa dipilih sebagai kategori tambahan');
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
                        alert('Kategori utama tidak dapat dipilih sebagai kategori tambahan');
                    }
                }
            });
        }
        
        // Image preview functionality dengan antisipasi kedipan
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('imagePreview');
        const uploadPlaceholder = document.getElementById('uploadPlaceholder');
        const imagePreviewContainer = document.getElementById('imagePreviewContainer');
        let isProcessing = false;
        
        // File input diatur sebagai diam (tidak terlihat)
        imageInput.style.position = 'absolute';
        imageInput.style.opacity = '0';
        imageInput.style.pointerEvents = 'none';
        
        // Click pada container dengan antisipasi kedipan
        imagePreviewContainer.onclick = function(e) {
            e.stopPropagation(); // Hentikan propagasi event
            
            // Cegah klik berturut-turut
            if (isProcessing) return;
            isProcessing = true;
            
            // Simulasi klik pada input file tanpa kedipan
            const event = new MouseEvent('click', {
                bubbles: false,
                cancelable: true,
                view: window
            });
            
            // Gunakan setTimeout untuk memastikan UI tidak kedip
            setTimeout(() => {
                imageInput.dispatchEvent(event);
                
                // Reset flag proses setelah beberapa waktu
                setTimeout(() => {
                    isProcessing = false;
                }, 300);
            }, 10);
        };
        
        // Change handler dengan antisipasi kedipan
        imageInput.onchange = function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                // Konfigurasi pembaca file
                reader.onloadstart = function() {
                    // Tidak melakukan perubahan UI di sini untuk mencegah kedipan
                };
                
                reader.onload = function(e) {
                    // Siapkan gambar di memori terlebih dahulu
                    const img = new Image();
                    img.src = e.target.result;
                    
                    img.onload = function() {
                        // Gambar sudah di-cache, sekarang kita bisa tampilkan tanpa kedipan
                        imagePreview.src = e.target.result;
                        imagePreview.style.opacity = '0';
                        imagePreview.style.display = 'block';
                        
                        // Beri sedikit waktu untuk render
                        requestAnimationFrame(() => {
                            uploadPlaceholder.style.opacity = '0';
                            
                            // Animasi fade
                            requestAnimationFrame(() => {
                                imagePreview.style.opacity = '1';
                                
                                // Sembunyikan placeholder setelah fade selesai
                                setTimeout(() => {
                                    uploadPlaceholder.style.display = 'none';
                                }, 300);
                            });
                        });
                    };
                };
                
                // Baca file sebagai URL data
                reader.readAsDataURL(this.files[0]);
            }
        };
        
        // Reset preview tanpa kedipan
        const resetButton = document.getElementById('resetButton');
        resetButton.onclick = function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            // Animasi fade out gambar
            imagePreview.style.opacity = '0';
            
            setTimeout(() => {
                // Tampilkan placeholder tapi dengan opacity 0
                uploadPlaceholder.style.display = 'flex';
                uploadPlaceholder.style.opacity = '0';
                
                // Reset input file dan sembunyikan preview
                imagePreview.style.display = 'none';
                imagePreview.src = '';
                imageInput.value = '';
                
                // Animasi fade in placeholder
                requestAnimationFrame(() => {
                    uploadPlaceholder.style.opacity = '1';
                });
                
                // Reset form setelah animasi selesai
                setTimeout(() => {
                    document.getElementById('productForm').reset();
                }, 300);
            }, 300);
        };
        
        // Pencegahan pengiriman ulang form
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
        
        // Pencegahan pengiriman ganda
        const form = document.getElementById('productForm');
        const submitButton = document.getElementById('submitButton');
        
        form.onsubmit = function(e) {
            e.preventDefault();
            
            // Tunjukkan status loading
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...';
            submitButton.classList.add('disabled');
            
            // Submit setelah UI diperbarui
            requestAnimationFrame(() => {
                setTimeout(() => {
                    this.submit();
                }, 10);
            });
        };
        
        // Pastikan semua input menggunakan cursor text yang konsisten
        document.querySelectorAll('input, textarea, select').forEach(el => {
            el.addEventListener('mouseover', function() {
                if (this.tagName === 'SELECT') {
                    document.body.style.cursor = 'pointer';
                } else {
                    document.body.style.cursor = 'text';
                }
            });
            
            el.addEventListener('mouseout', function() {
                document.body.style.cursor = 'default';
            });
        });
    });
</script>
@endpush
