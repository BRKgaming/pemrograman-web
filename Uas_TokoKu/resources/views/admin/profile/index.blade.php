@extends('layouts.app')

@section('title', 'Profil Admin - TokoKU')

@section('content')
<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body text-center">
                    <div class="mb-3">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset(Auth::user()->avatar) }}" class="rounded-circle img-fluid" style="width: 120px; height: 120px; object-fit: cover;">
                        @else
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 120px; height: 120px; font-size: 48px;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <h5 class="fw-bold mb-1">{{ Auth::user()->name }}</h5>
                    <p class="text-muted mb-3">Administrator</p>
                    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#avatarModal">
                        <i class="fas fa-camera me-1"></i> Ubah Foto
                    </button>
                </div>
            </div>
            
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Menu Admin</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-tachometer-alt me-2 text-primary"></i> Dashboard
                        </a>
                        <a href="{{ route('admin.users') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-users me-2 text-primary"></i> Kelola Pengguna
                        </a>
                        <a href="{{ route('admin.orders') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-shopping-cart me-2 text-primary"></i> Kelola Pesanan
                        </a>
                        <a href="{{ route('products.index') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-box me-2 text-primary"></i> Kelola Produk
                        </a>
                        <a href="{{ route('admin.inventory.index') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-warehouse me-2 text-primary"></i> Inventaris
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Profil Admin</h5>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        <i class="fas fa-edit me-1"></i> Edit Profil
                    </button>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Nama Lengkap</div>
                        <div class="col-md-8">{{ Auth::user()->name }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Email</div>
                        <div class="col-md-8">{{ Auth::user()->email }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Nomor Telepon</div>
                        <div class="col-md-8">{{ Auth::user()->phone ?? '-' }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Alamat</div>
                        <div class="col-md-8">{{ Auth::user()->address ?? '-' }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Kota</div>
                        <div class="col-md-8">{{ Auth::user()->city ?? '-' }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Kode Pos</div>
                        <div class="col-md-8">{{ Auth::user()->postal_code ?? '-' }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Role</div>
                        <div class="col-md-8">
                            <span class="badge bg-primary">Administrator</span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 fw-bold">Bergabung Sejak</div>
                        <div class="col-md-8">{{ Auth::user()->created_at->format('d F Y') }}</div>
                    </div>
                </div>
            </div>
            
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Keamanan</h5>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                        <i class="fas fa-key me-1"></i> Ubah Password
                    </button>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <div class="d-flex">
                            <div class="me-3">
                                <i class="fas fa-shield-alt fa-2x text-info"></i>
                            </div>
                            <div>
                                <h5 class="alert-heading">Tips Keamanan</h5>
                                <p class="mb-0">Pastikan password Anda kuat dan unik. Gunakan kombinasi huruf, angka, dan simbol. Jangan menggunakan password yang sama untuk beberapa akun.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Password</div>
                        <div class="col-md-8">
                            <span class="text-muted">••••••••••</span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 fw-bold">Login Terakhir</div>
                        <div class="col-md-8">{{ now()->format('d F Y, H:i') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Profil -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="phone" class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ Auth::user()->phone }}">
                    </div>
                    
                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat</label>
                        <textarea class="form-control" id="address" name="address" rows="3">{{ Auth::user()->address }}</textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="city" class="form-label">Kota</label>
                            <input type="text" class="form-control" id="city" name="city" value="{{ Auth::user()->city }}">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="postal_code" class="form-label">Kode Pos</label>
                            <input type="text" class="form-control" id="postal_code" name="postal_code" value="{{ Auth::user()->postal_code }}">
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Ubah Password -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.profile.update-password') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">Ubah Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Password Saat Ini</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Ubah Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Ubah Avatar -->
<div class="modal fade" id="avatarModal" tabindex="-1" aria-labelledby="avatarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.profile.update-avatar') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="modal-header">
                    <h5 class="modal-title" id="avatarModalLabel">Ubah Foto Profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="avatar" class="form-label">Pilih Foto Baru</label>
                        <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*" required>
                        <div class="form-text">Disarankan menggunakan gambar dengan rasio 1:1 (persegi) dan ukuran maksimal 2MB.</div>
                    </div>
                    
                    <div class="text-center mt-4 preview-container d-none">
                        <h6>Pratinjau:</h6>
                        <img id="avatar-preview" src="#" alt="Pratinjau Foto" class="img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Foto</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Preview avatar image before upload
        const avatarInput = document.getElementById('avatar');
        const avatarPreview = document.getElementById('avatar-preview');
        const previewContainer = document.querySelector('.preview-container');
        
        avatarInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    avatarPreview.src = e.target.result;
                    previewContainer.classList.remove('d-none');
                }
                reader.readAsDataURL(file);
            } else {
                avatarPreview.src = '#';
                previewContainer.classList.add('d-none');
            }
        });
    });
</script>
@endpush
