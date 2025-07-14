@extends('layouts.auth')

@section('title', 'Login - Laravel App')

@section('content')
<div class="card">
    <div class="card-header">
        <i class="fas fa-sign-in-alt auth-icon"></i>
        <h3 class="mb-0">Login</h3>
        <p class="text-muted">Masuk ke akun Anda</p>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf
            
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
                           autocomplete="current-password" 
                           placeholder="Masukkan password Anda">
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

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">
                    Ingat saya
                </label>
            </div>

            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt"></i> Masuk
                </button>
            </div>

            <div class="text-center">
                <p class="mb-0">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="auth-link">Daftar disini</a>
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
    
    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        // Toggle icon
        const icon = this.querySelector('i');
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    });

    // Client-side validation
    const loginForm = document.getElementById('loginForm');
    loginForm.addEventListener('submit', function(e) {
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        
        // Basic validation
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
