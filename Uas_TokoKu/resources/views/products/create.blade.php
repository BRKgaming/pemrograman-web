@extends('layouts.app')

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

                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="name" class="form-label fw-bold">Nama Produk <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                                    <div class="form-text">Masukkan nama produk yang jelas dan deskriptif.</div>
                                </div>

                                <div class="mb-3">
                                    <label for="category_id" class="form-label fw-bold">Kategori <span class="text-danger">*</span></label>
                                    <select class="form-select" id="category_id" name="category_id" required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
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
                            <button type="reset" class="btn btn-light me-2">Reset</button>
                            <button type="submit" class="btn btn-primary">
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
    .image-preview-container {
        cursor: pointer;
        transition: all 0.2s;
    }
    .image-preview-container:hover {
        background-color: #e9ecef !important;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Image preview functionality
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('imagePreview');
        const uploadPlaceholder = document.getElementById('uploadPlaceholder');
        const imagePreviewContainer = document.getElementById('imagePreviewContainer');
        
        // Click on preview container to trigger file input
        imagePreviewContainer.addEventListener('click', function() {
            imageInput.click();
        });
        
        imageInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    imagePreview.setAttribute('src', e.target.result);
                    imagePreview.style.display = 'block';
                    uploadPlaceholder.style.display = 'none';
                }
                
                reader.readAsDataURL(this.files[0]);
            }
        });
        
        // Reset preview on form reset
        document.querySelector('button[type="reset"]').addEventListener('click', function() {
            imagePreview.style.display = 'none';
            uploadPlaceholder.style.display = 'flex';
            imagePreview.setAttribute('src', '');
        });
    });
</script>
@endpush
