@extends('layouts.auth')

@section('title', 'Register - Laravel App')

@section('content')
<div class="card">
    <div class="card-header">
        <i class="fas fa-user-plus auth-icon"></i>
        <h3 class="mb-0">Daftar</h3>
        <p class="text-muted">Buat akun baru</p>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('register') }}" id="registerForm">
            @csrf
            
            <div class="mb-3">
                <label for="name" class="form-label">
                    <i class="fas fa-user"></i> Nama Lengkap
                </label>
                <input type="text" 
                       class="form-control @error('name') is-invalid @enderror" 
                       id="name" 
                       name="name" 
                       value="{{ old('name') }}" 
                       required 
                       autocomplete="name" 
                       placeholder="Masukkan nama lengkap Anda">
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">
                    <i class="fas fa-envelope"></i> Email
                </label>
                <input type="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       required 
                       autocomplete="email" 
                       placeholder="Masukkan email Anda">
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">
                    <i class="fas fa-lock"></i> Password
                </label>
                <div class="input-group">
                    <input type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           id="password" 
                           name="password" 
                           required 
                           autocomplete="new-password" 
                           placeholder="Masukkan password (min. 8 karakter)">
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                <div class="form-text">
                    <small>Password harus minimal 8 karakter</small>
                </div>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">
                    <i class="fas fa-lock"></i> Konfirmasi Password
                </label>
                <div class="input-group">
                    <input type="password" 
                           class="form-control" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           required 
                           autocomplete="new-password" 
                           placeholder="Ulangi password Anda">
                    <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirm">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <div id="passwordMatchError" class="invalid-feedback"></div>
            </div>

            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i> Daftar
                </button>
            </div>

            <div class="text-center">
                <p class="mb-0">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="auth-link">Masuk disini</a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
    const passwordConfirmInput = document.getElementById('password_confirmation');
    
    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        const icon = this.querySelector('i');
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    });

    togglePasswordConfirm.addEventListener('click', function() {
        const type = passwordConfirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordConfirmInput.setAttribute('type', type);
        
        const icon = this.querySelector('i');
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    });

    // Real-time password confirmation check
    passwordConfirmInput.addEventListener('input', function() {
        const password = passwordInput.value;
        const passwordConfirm = this.value;
        const errorDiv = document.getElementById('passwordMatchError');
        
        if (passwordConfirm && password !== passwordConfirm) {
            this.classList.add('is-invalid');
            errorDiv.textContent = 'Password tidak cocok';
            errorDiv.style.display = 'block';
        } else {
            this.classList.remove('is-invalid');
            errorDiv.style.display = 'none';
        }
    });

    // Client-side validation
    const registerForm = document.getElementById('registerForm');
    registerForm.addEventListener('submit', function(e) {
        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const passwordConfirm = document.getElementById('password_confirmation').value;
        
        // Basic validation
        if (!name) {
            e.preventDefault();
            showError('Nama lengkap harus diisi');
            return;
        }
        
        if (name.length < 2) {
            e.preventDefault();
            showError('Nama lengkap minimal 2 karakter');
            return;
        }
        
        if (!email) {
            e.preventDefault();
            showError('Email harus diisi');
            return;
        }
        
        if (!isValidEmail(email)) {
            e.preventDefault();
            showError('Format email tidak valid');
            return;
        }
        
        if (!password) {
            e.preventDefault();
            showError('Password harus diisi');
            return;
        }
        
        if (password.length < 6) {
            e.preventDefault();
            showError('Password minimal 6 karakter');
            return;
        }
        
        if (!passwordConfirm) {
            e.preventDefault();
            showError('Konfirmasi password harus diisi');
            return;
        }
        
        if (password !== passwordConfirm) {
            e.preventDefault();
            showError('Password dan konfirmasi password tidak cocok');
            return;
        }
    });

    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    function showError(message) {
        // Create or update error alert
        let existingAlert = document.querySelector('.alert-danger');
        if (existingAlert) {
            existingAlert.remove();
        }

        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-danger alert-dismissible fade show';
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        const cardBody = document.querySelector('.card-body');
        cardBody.insertBefore(alertDiv, cardBody.firstChild);
    }
});
</script>
@endpush
