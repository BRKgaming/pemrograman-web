@extends('layouts.app')

@section('title', 'Akun Saya - TokoKU')

@section('content')
<div class="container py-4">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h2 mb-0">
                    <i class="fas fa-user-circle text-primary me-2"></i> Akun Saya
                </h1>
                <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Beranda
                </a>
            </div>
            <p class="text-muted">Kelola informasi profil dan password Anda</p>
        </div>
    </div>

    <div class="row g-4">
        <!-- User Summary Card -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm overflow-hidden mb-4">
                <div class="card-body p-0">
                    <div class="bg-primary text-white p-4 text-center position-relative">
                        <div class="avatar-container mb-3">
                            <div class="avatar mx-auto rounded-circle bg-white text-primary d-flex align-items-center justify-content-center" 
                                 style="width: 100px; height: 100px; font-size: 3rem; overflow: hidden;">
                                @if($user->avatar)
                                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="img-fluid w-100 h-100 object-fit-cover">
                                @else
                                    <i class="fas fa-user"></i>
                                @endif
                            </div>
                        </div>
                        <h4 class="mb-1">{{ $user->name }}</h4>
                        <p class="mb-1"><i class="fas fa-envelope me-1"></i> {{ $user->email }}</p>
                        <p class="mb-0"><i class="fas fa-phone me-1"></i> {{ $user->phone ?: 'Belum diatur' }}</p>
                    </div>
                    <div class="p-4">
                        <div class="d-grid gap-3">
                            <a href="{{ route('orders.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-shopping-bag me-2"></i> Pesanan Saya
                            </a>
                            <a href="{{ route('wishlist.index') }}" class="btn btn-outline-danger">
                                <i class="fas fa-heart me-2"></i> Wishlist Saya
                            </a>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-success">
                                <i class="fas fa-shopping-cart me-2"></i> Belanja Lagi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white p-4 border-0">
                    <ul class="nav nav-tabs card-header-tabs" id="profileTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" 
                                    data-bs-target="#profile-tab-pane" type="button" role="tab" 
                                    aria-controls="profile-tab-pane" aria-selected="true">
                                <i class="fas fa-user-edit me-2"></i> Profil Saya
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="password-tab" data-bs-toggle="tab" 
                                    data-bs-target="#password-tab-pane" type="button" role="tab" 
                                    aria-controls="password-tab-pane" aria-selected="false">
                                <i class="fas fa-key me-2"></i> Ubah Password
                            </button>
                        </li>
                    </ul>
                </div>
                
                <div class="card-body p-4">
                    <div class="tab-content" id="profileTabsContent">
                        <!-- Profile Tab -->
                        <div class="tab-pane fade show active" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                
                                <!-- Foto Profil -->
                                <h5 class="card-title mb-3 pb-2 border-bottom">Foto Profil</h5>
                                <div class="mb-4">
                                    <label for="avatar" class="form-label">Unggah Foto Profil</label>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar-preview rounded-circle bg-light border" style="width: 100px; height: 100px; overflow: hidden;">
                                            @if($user->avatar)
                                                <img id="avatar-preview-img" src="{{ asset('storage/' . $user->avatar) }}" alt="Foto Profil" class="w-100 h-100 object-fit-cover">
                                            @else
                                                <img id="avatar-preview-img" src="{{ asset('img/default-avatar.png') }}" alt="Foto Profil" class="w-100 h-100 object-fit-cover d-none">
                                                <div id="avatar-preview-placeholder" class="w-100 h-100 d-flex align-items-center justify-content-center text-muted">
                                                    <i class="fas fa-user fa-3x"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="input-group">
                                                <input type="file" class="form-control @error('avatar') is-invalid @enderror" id="avatar" name="avatar" accept="image/*">
                                                <label class="input-group-text" for="avatar"><i class="fas fa-upload"></i></label>
                                            </div>
                                            @error('avatar')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Format yang diterima: JPG, JPEG, PNG, GIF. Maksimal 2MB.</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Informasi Dasar -->
                                <h5 class="card-title mb-3 pb-2 border-bottom">Informasi Dasar</h5>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Lengkap</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <!-- Informasi Kontak -->
                                <h5 class="card-title mb-3 pb-2 border-bottom mt-4">Informasi Kontak & Alamat</h5>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Nomor Telepon</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="address" class="form-label">Alamat Lengkap</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                        <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3">{{ old('address', $user->address) }}</textarea>
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="city" class="form-label">Kota</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-city"></i></span>
                                            <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" value="{{ old('city', $user->city) }}">
                                            @error('city')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="postal_code" class="form-label">Kode Pos</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-map-pin"></i></span>
                                            <input type="text" class="form-control @error('postal_code') is-invalid @enderror" id="postal_code" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}">
                                            @error('postal_code')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <input type="hidden" name="update_type" value="profile">
                                
                                <div class="d-grid gap-2 mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i> Simpan Perubahan Profil
                                    </button>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Password Tab -->
                        <div class="tab-pane fade" id="password-tab-pane" role="tabpanel" aria-labelledby="password-tab" tabindex="0">
                            <form action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <h5 class="card-title mb-3 pb-2 border-bottom">Ubah Password</h5>
                                <div class="mb-4">
                                    <label for="current_password" class="form-label">Password Saat Ini</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password">
                                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="current_password">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        @error('current_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="password" class="form-label">Password Baru</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-text">Password minimal 8 karakter</div>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-check-circle"></i></span>
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password_confirmation">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <input type="hidden" name="update_type" value="password">
                                
                                <div class="d-grid gap-2 mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-key me-2"></i> Perbarui Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Script untuk toggle password visibility
    document.addEventListener('DOMContentLoaded', function() {
        const toggleButtons = document.querySelectorAll('.toggle-password');
        
        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const passwordInput = document.getElementById(targetId);
                
                // Toggle password visibility
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    this.innerHTML = '<i class="fas fa-eye-slash"></i>';
                } else {
                    passwordInput.type = 'password';
                    this.innerHTML = '<i class="fas fa-eye"></i>';
                }
                
                // Add animation
                button.classList.add('btn-pulse');
                setTimeout(() => {
                    button.classList.remove('btn-pulse');
                }, 300);
            });
        });
        
        // Maintain active tab after form submission with errors
        const hash = window.location.hash;
        if (hash === '#password') {
            const passwordTab = document.getElementById('password-tab');
            if (passwordTab) {
                passwordTab.click();
            }
        }
        
        // Avatar preview functionality
        const avatarInput = document.getElementById('avatar');
        const avatarPreviewImg = document.getElementById('avatar-preview-img');
        const avatarPreviewPlaceholder = document.getElementById('avatar-preview-placeholder');
        
        if (avatarInput && avatarPreviewImg) {
            avatarInput.addEventListener('change', function(e) {
                if (e.target.files && e.target.files[0]) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        avatarPreviewImg.src = e.target.result;
                        avatarPreviewImg.classList.remove('d-none');
                        if (avatarPreviewPlaceholder) {
                            avatarPreviewPlaceholder.classList.add('d-none');
                        }
                    }
                    
                    reader.readAsDataURL(e.target.files[0]);
                }
            });
        }
    });
</script>
<style>
    /* Animations and custom styles */
    .avatar-container {
        position: relative;
    }
    
    .avatar {
        transition: transform 0.3s ease;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    
    .avatar:hover {
        transform: scale(1.05);
    }
    
    .btn-pulse {
        animation: pulse 0.3s;
    }
    
    @keyframes pulse {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.1);
        }
        100% {
            transform: scale(1);
        }
    }
    
    .nav-tabs .nav-link {
        border-radius: 0;
        font-weight: 500;
        transition: all 0.2s ease;
    }
    
    .nav-tabs .nav-link.active {
        border-bottom: 2px solid #0d6efd;
    }
    
    .tab-pane {
        animation: fadeIn 0.4s;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .form-control:focus {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
    }
    
    .avatar-preview {
        transition: all 0.3s ease;
        position: relative;
    }
    
    .avatar-preview:hover::after {
        content: "\f030";
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        cursor: pointer;
    }
    
    .object-fit-cover {
        object-fit: cover;
    }
</style>
@endpush
@endsection
