<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('img/Logo TokoKU.jpg') }}" type="image/x-icon">
    <title>@yield('title', 'TokoKU - Toko Online Terpercaya')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Anti-flicker CSS -->
    <link rel="stylesheet" href="{{ asset('css/cursor-fix.css') }}">
    <!-- Fullscreen Modal CSS -->
    <link rel="stylesheet" href="{{ asset('css/fullscreen-modal.css') }}">
    <!-- Center Modal CSS -->
    <link rel="stylesheet" href="{{ asset('css/center-modal.css') }}">
    <!-- Improved Fullscreen Modal CSS -->
    <link rel="stylesheet" href="{{ asset('css/improved-fullscreen-modal.css') }}">
    @stack('styles')
    
    <!-- Custom Styles -->
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            --secondary-gradient: linear-gradient(135deg, #17a2b8 0%, #007bff 100%);
            --success-gradient: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
        }
        
        /* Navbar Styles */
        .navbar {
            transition: all 0.3s ease;
        }
        
        .navbar-nav .nav-link {
            position: relative;
            transition: all 0.3s ease;
            border-radius: 25px;
            margin: 0 5px;
        }
        
        .navbar-nav .nav-link:hover {
            background: rgba(255,255,255,0.1);
            transform: translateY(-2px);
        }
        
        .navbar-nav .nav-link.active {
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
        }
        
        .btn-social {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .btn-social:hover {
            transform: translateY(-3px);
            background: var(--primary-gradient) !important;
            border-color: transparent !important;
        }
        
        .hover-link {
            transition: all 0.3s ease;
        }
        
        .hover-link:hover {
            color: #fff !important;
            transform: translateX(5px);
        }
        
        /* Card Styles */
        .card {
            border: none;
            border-radius: 15px;
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        
        .card-img-top {
            transition: all 0.3s ease;
        }
        
        .card:hover .card-img-top {
            transform: scale(1.05);
        }
        
        /* Button Styles */
        .btn {
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: var(--primary-gradient);
            border: none;
        }
        
        .btn-primary:hover {
            background: var(--secondary-gradient);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
        
        .btn-outline-primary {
            border: 2px solid;
            border-image: var(--primary-gradient) 1;
            color: #007bff;
        }
        
        .btn-outline-primary:hover {
            background: var(--primary-gradient);
            border-color: transparent;
            color: white;
            transform: translateY(-2px);
        }
        
        /* Hero Section */
        .hero-section {
            background: var(--primary-gradient);
            min-height: 70vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('https://picsum.photos/1600/900?random=1') center/cover;
            opacity: 0.3;
            z-index: 1;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
        }
        
        /* Animation Classes */
        .fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .fade-in-left {
            animation: fadeInLeft 0.8s ease-out;
        }
        
        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        .fade-in-right {
            animation: fadeInRight 0.8s ease-out;
        }
        
        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-section {
                min-height: 60vh;
                text-align: center;
            }
            
            .card {
                margin-bottom: 20px;
            }
            
            .btn-social {
                width: 35px;
                height: 35px;
            }
            
            .display-4 {
                font-size: 2rem;
            }
        }
        
        @media (max-width: 576px) {
            .hero-section {
                min-height: 50vh;
            }
            
            .container {
                padding-left: 15px;
                padding-right: 15px;
            }
        }
        
        /* Loading Animation */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Product Grid */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }
        
        /* Badge Styles */
        .badge {
            font-size: 0.75rem;
            padding: 5px 10px;
        }
        
        .badge-gradient {
            background: var(--secondary-gradient);
        }
        
        /* Search Bar */
        .search-container {
            position: relative;
        }
        
        .search-container input:focus {
            background: rgba(255,255,255,0.2) !important;
            border-color: rgba(255,255,255,0.5) !important;
            box-shadow: 0 0 0 0.2rem rgba(255,255,255,0.25) !important;
        }
        
        .search-container input::placeholder {
            color: rgba(255,255,255,0.7);
        }
    </style>
</head>
<body>
    <!-- Navigasi -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); backdrop-filter: blur(10px); box-shadow: 0 8px 32px rgba(0,0,0,0.1);">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <img src="{{ asset('img/Logo TokoKU.jpg') }}" class="rounded-circle brand-logo me-2" alt="Logo TokoKU" style="width: 40px; height: 40px; object-fit: cover;">
                <span class="fw-bold fs-4">TokoKU</span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link px-3 {{ Route::currentRouteName() == 'home' ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="fas fa-home me-1"></i>Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 {{ Route::currentRouteName() == 'about' ? 'active' : '' }}" href="{{ route('about') }}">
                            <i class="fas fa-info-circle me-1"></i>Tentang
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 {{ Route::currentRouteName() == 'categories.index' ? 'active' : '' }}" href="{{ route('categories.index') }}">
                            <i class="fas fa-th-large me-1"></i>Kategori
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 {{ Route::currentRouteName() == 'products.index' ? 'active' : '' }}" href="{{ route('products.index') }}">
                            <i class="fas fa-shopping-bag me-1"></i>Produk
                        </a>
                    </li>
                </ul>
                
                <!-- Search Form -->
                <form class="d-flex me-3 d-none d-md-flex" action="{{ route('products.index') }}" method="GET" style="min-width: 250px;">
                    <div class="input-group">
                        <input class="form-control border-0 rounded-start-pill" type="search" name="search" placeholder="Cari produk..." aria-label="Search" style="background: rgba(255,255,255,0.1); color: white; backdrop-filter: blur(5px);" value="{{ request('search') }}">
                        <button class="btn btn-light rounded-end-pill" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
                
                <!-- Cart and Profile -->
                <div class="d-flex align-items-center">
                    <!-- Cart -->
                    <a href="{{ route('cart') }}" class="btn btn-outline-light me-2 position-relative">
                        <i class="fas fa-shopping-cart"></i>
                        <span id="jumlah-keranjang" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            0
                            <span class="visually-hidden">items in cart</span>
                        </span>
                    </a>
                    
                    <!-- Authentication -->
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-outline-light me-2">
                            <i class="fas fa-sign-in-alt"></i> Masuk
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-light">
                            <i class="fas fa-user-plus"></i> Daftar
                        </a>
                    @else
                        <div class="dropdown">
                            <a href="#" class="btn btn-outline-light dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @if(Auth::user()->isAdmin())
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i>Dasbor Admin</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.profile') }}"><i class="fas fa-user-shield me-2"></i>Profil Admin</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.products.index') }}"><i class="fas fa-box me-2"></i>Kelola Produk</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.orders') }}"><i class="fas fa-shopping-cart me-2"></i>Kelola Pesanan</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.users') }}"><i class="fas fa-users me-2"></i>Kelola Pengguna</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.inventory.index') }}"><i class="fas fa-warehouse me-2"></i>Kelola Inventaris</a></li>
                                @else
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user me-2"></i>Akun Saya</a></li>
                                <li><a class="dropdown-item" href="{{ route('orders.index') }}"><i class="fas fa-shopping-bag me-2"></i>Pesanan Saya</a></li>
                                <li><a class="dropdown-item" href="{{ route('wishlist.index') }}"><i class="fas fa-heart me-2"></i>Wishlist Saya</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}" 
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i>Keluar
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endguest
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Konten -->
    <main style="padding-top: 80px;">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('info'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="fas fa-info-circle me-2"></i>{{ session('info') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>{{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white mt-5">
        <div class="container py-5">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ asset('img/Logo TokoKU.jpg') }}" class="rounded-circle me-3" alt="Logo TokoKU" style="width: 50px; height: 50px; object-fit: cover;">
                        <h4 class="mb-0 fw-bold">TokoKU</h4>
                    </div>
                    <p class="text-white-50 mb-4">Toko online barang second terpercaya dengan berbagai produk teknologi berkualitas tinggi dengen harga terjangkau.</p>
                    
                    <h6 class="fw-bold mb-3">Kategori Produk</h6>
                    <div class="row">
                        <div class="col-6">
                            <a href="{{ route('categories.show', 'gadget') }}" class="text-decoration-none text-white-50 d-block mb-2 hover-link">
                                <i class="fas fa-mobile-alt me-2"></i>Gadget
                            </a>
                            <a href="{{ route('categories.show', 'gaming') }}" class="text-decoration-none text-white-50 d-block mb-2 hover-link">
                                <i class="fas fa-gamepad me-2"></i>Gaming
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('categories.show', 'elektronik') }}" class="text-decoration-none text-white-50 d-block mb-2 hover-link">
                                <i class="fas fa-tv me-2"></i>Elektronik
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Pembayaran dan Pengiriman -->
                <div class="col-lg-4 col-md-6">
                    <h6 class="fw-bold mb-3"><i class="fas fa-credit-card me-2"></i>Metode Pembayaran</h6>
                    <div class="row g-2 mb-4">
                        <div class="col-4"><img src="{{ asset('img/logo Bri.jpg') }}" class="img-fluid rounded" alt="BRI"></div>
                        <div class="col-4"><img src="{{ asset('img/logo dana.webp') }}" class="img-fluid rounded" alt="Dana"></div>
                        <div class="col-4"><img src="{{ asset('img/logo gopay.webp') }}" class="img-fluid rounded" alt="Gopay"></div>
                        <div class="col-4"><img src="{{ asset('img/logo ovo.webp') }}" class="img-fluid rounded" alt="OVO"></div>
                        <div class="col-4"><img src="{{ asset('img/Logo bca.webp') }}" class="img-fluid rounded" alt="BCA"></div>
                        <div class="col-4"><img src="{{ asset('img/logo mandiri.webp') }}" class="img-fluid rounded" alt="Mandiri"></div>
                    </div>
                    
                    <h6 class="fw-bold mb-3"><i class="fas fa-shipping-fast me-2"></i>Pengiriman</h6>
                    <div class="d-flex flex-wrap gap-2">
                        <img src="{{ asset('img/jnt-logo.webp') }}" class="img-fluid rounded" style="height: 40px;" alt="JNT">
                        <span class="badge bg-primary align-self-center">Ekspedisi Terpercaya</span>
                    </div>
                </div>

                <!-- Kontak & Sosial Media -->
                <div class="col-lg-4 col-md-12">
                    <h6 class="fw-bold mb-3"><i class="fas fa-heart me-2"></i>Ikuti Kami</h6>
                    <div class="d-flex gap-3 mb-4">
                        <a href="#" class="btn btn-outline-light btn-social rounded-circle">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="btn btn-outline-light btn-social rounded-circle">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="btn btn-outline-light btn-social rounded-circle">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="btn btn-outline-light btn-social rounded-circle">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                    
                    <h6 class="fw-bold mb-3"><i class="fas fa-mobile me-2"></i>Download Aplikasi</h6>
                    <p class="text-white-50 mb-3">Belanja lebih mudah dengan aplikasi mobile kami</p>
                    <div class="d-flex flex-column gap-2">
                        <button class="btn btn-outline-light btn-sm">
                            <i class="fab fa-apple me-2"></i>App Store
                        </button>
                        <button class="btn btn-outline-light btn-sm">
                            <i class="fab fa-google-play me-2"></i>Google Play
                        </button>
                    </div>
                    
                    <h6 class="fw-bold mt-4 mb-3"><i class="fas fa-phone me-2"></i>Kontak</h6>
                    <div class="contact-info">
                        <p class="mb-2 text-white-50">
                            <i class="fas fa-envelope me-2"></i>TokoKu@gmail.com
                        </p>
                        <p class="mb-2 text-white-50">
                            <i class="fas fa-phone me-2"></i>+62 812-2782-5205
                        </p>
                        <p class="mb-0 text-white-50">
                            <i class="fas fa-clock me-2"></i>24/7 Customer Support
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Lokasi Section -->
            <div class="row mt-5 pt-4 border-top border-secondary">
                <div class="col-lg-8">
                    <h6 class="fw-bold mb-3"><i class="fas fa-map-marker-alt me-2"></i>Lokasi Toko</h6>
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <img src="{{ asset('img/Screenshot 2025-05-10 204209.png') }}" alt="Lokasi" class="img-fluid rounded shadow-sm">
                        </div>
                        <div class="col-md-6 mt-3 mt-md-0">
                            <div class="address-info">
                                <h6 class="text-white">Alamat Utama:</h6>
                                <a href="https://www.google.com/maps/search/Jl.+Awikoen+MadyJalan+Awikoen+Madya+Timur+1+No+18+Rt+01%2F02,+rumah+Koskosan+Paling+Pojok+Pager+Abu+Abu,+KAB.+GRESIK,+KEBOMAS,+JAWA+TIMUR,+ID,+61123a+Jaya/@-7.1708485,112.630574,15z/data=!3m1!4b1?entry=ttu&g_ep=EgoyMDI1MDUwNy4wIKXMDSoASAFQAw%3D%3D" 
                                   class="text-white-50 text-decoration-none hover-link">
                                    <p class="mb-1">Jl. Awikoen Madya Timur 1 No 18</p>
                                    <p class="mb-1">Kos Pojok, Gresik</p>
                                    <p class="mb-0">Jawa Timur, 61123</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mt-4 mt-lg-0">
                    <h6 class="fw-bold mb-3"><i class="fas fa-shield-alt me-2"></i>Jaminan Kami</h6>
                    <div class="guarantee-list">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span class="text-white-50">Garansi Resmi</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span class="text-white-50">Produk Original</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span class="text-white-50">Pengiriman Aman</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span class="text-white-50">Return Policy</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Copyright -->
            <div class="text-center mt-4 pt-4 border-top border-secondary">
                <p class="mb-0 text-white-50">
                    &copy; 2025 <strong>TokoKU</strong>. Hak Cipta Dilindungi. 
                    <span class="mx-2">|</span>
                    <a href="#" class="text-white-50 text-decoration-none hover-link">Kebijakan Privasi</a>
                    <span class="mx-2">|</span>
                    <a href="#" class="text-white-50 text-decoration-none hover-link">Syarat & Ketentuan</a>
                </p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Anti-flicker Script -->
    <script src="{{ asset('js/cursor-fix.js') }}"></script>
    <!-- Fullscreen Modal Script -->
    <script src="{{ asset('js/fullscreen-modal.js') }}"></script>
    <!-- Center Modal Script -->
    <script src="{{ asset('js/center-modal.js') }}"></script>
    <!-- Improved Fullscreen Modal Script -->
    <script src="{{ asset('js/improved-fullscreen-modal.js') }}"></script>
    
    <!-- Modal Anti-flicker Fix -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Perbaikan khusus untuk modal Bootstrap
            const fixModals = function() {
                // Pra-inisialisasi modal untuk mencegah flicker
                const modalElements = document.querySelectorAll('.modal');
                modalElements.forEach(function(modal) {
                    // Tambahkan kelas hardware-accelerated dan atur transition
                    modal.classList.add('hw-accelerated');
                    modal.style.willChange = 'opacity';
                    modal.style.backfaceVisibility = 'hidden';
                    modal.style.webkitBackfaceVisibility = 'hidden';
                    
                    // Optimasi untuk backdrop
                    const backdrop = modal.querySelector('.modal-backdrop');
                    if (backdrop) {
                        backdrop.classList.add('hw-accelerated');
                        backdrop.style.willChange = 'opacity';
                    }
                    
                    // Optimasi untuk dialog dan content
                    const content = modal.querySelector('.modal-content');
                    if (content) {
                        content.classList.add('hw-accelerated');
                        content.style.transform = 'translateZ(0)';
                        content.style.transition = 'none';
                    }
                    
                    const dialog = modal.querySelector('.modal-dialog');
                    if (dialog) {
                        dialog.classList.add('hw-accelerated');
                        dialog.style.transform = 'translate(0, 0)';
                        dialog.style.transition = 'none';
                    }
                });
                
                // Tangani klik pada tombol yang membuka modal
                const modalTriggers = document.querySelectorAll('[data-bs-toggle="modal"]');
                modalTriggers.forEach(function(trigger) {
                    // Hapus event listener default dan ganti dengan custom handler
                    const originalClickHandler = trigger.onclick;
                    trigger.onclick = null;
                    
                    trigger.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        
                        const targetId = this.getAttribute('data-bs-target');
                        const modalElement = document.querySelector(targetId);
                        
                        if (modalElement) {
                            // Pre-render modal offscreen untuk menghindari flicker
                            modalElement.style.display = 'block';
                            modalElement.style.opacity = '0';
                            
                            // Force reflow dan aplikasikan hardware acceleration
                            void modalElement.offsetWidth;
                            
                            // Tampilkan modal dengan smooth transition
                            setTimeout(function() {
                                modalElement.style.opacity = '1';
                                const modal = new bootstrap.Modal(modalElement);
                                modal.show();
                            }, 10);
                        }
                    });
                });
            };
            
            // Jalankan fix setelah semua resources dimuat
            if (document.readyState === 'complete') {
                fixModals();
            } else {
                window.addEventListener('load', fixModals);
            }
        });
    </script>
    
    <script>
        // Initialize AOS Animation
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
        });
    </script>
    
    <!-- Cart functionality -->
    <script>
        // Ambil data keranjang dari localStorage
        function getCartItems() {
            return JSON.parse(localStorage.getItem('cart') || '[]');
        }

        // Simpan data keranjang ke localStorage
        function saveCartItems(items) {
            localStorage.setItem('cart', JSON.stringify(items));
            updateCartCount();
        }

        // Update jumlah item di keranjang
        function updateCartCount() {
            const cartItems = getCartItems();
            const count = cartItems.reduce((total, item) => total + item.quantity, 0);
            document.getElementById('jumlah-keranjang').textContent = count;
        }

        // Tambah item ke keranjang
        function addToCart(product) {
            const cartItems = getCartItems();
            const existingItem = cartItems.find(item => item.id === product.id);
            
            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                cartItems.push({
                    id: product.id,
                    name: product.name,
                    price: product.price,
                    image: product.image,
                    specifications: product.specifications,
                    quantity: 1
                });
            }
            
            saveCartItems(cartItems);
            alert('Produk berhasil ditambahkan ke keranjang!');
        }

        // Event listener untuk tombol tambah ke keranjang
        document.addEventListener('DOMContentLoaded', function() {
            updateCartCount();
            
            document.querySelectorAll('.tambah-keranjang').forEach(button => {
                button.addEventListener('click', function() {
                    const product = {
                        id: this.dataset.id,
                        name: this.dataset.nama,
                        price: parseInt(this.dataset.harga),
                        image: this.dataset.gambar,
                        specifications: this.dataset.variasi
                    };
                    addToCart(product);
                });
            });
        });
    </script>
    
    <!-- Wishlist AJAX Script -->
    @auth
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Semua tombol toggle wishlist
            document.querySelectorAll('.toggle-wishlist').forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.dataset.id;
                    const isHeartFilled = this.querySelector('i').classList.contains('fas');
                    const heartIcon = this.querySelector('i');
                    const textSpan = this.querySelector('.wishlist-text');
                    
                    // AJAX request
                    fetch('{{ route('wishlist.toggle') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            product_id: productId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'added') {
                            // Update UI untuk menambahkan ke wishlist
                            heartIcon.classList.remove('far');
                            heartIcon.classList.add('fas', 'text-danger');
                            if (textSpan) {
                                textSpan.textContent = 'Hapus dari Wishlist';
                            }
                            // Tampilkan notifikasi jika diperlukan
                            showToast('Produk ditambahkan ke wishlist');
                        } else {
                            // Update UI untuk menghapus dari wishlist
                            heartIcon.classList.remove('fas', 'text-danger');
                            heartIcon.classList.add('far');
                            if (textSpan) {
                                textSpan.textContent = 'Tambahkan ke Wishlist';
                            }
                            // Tampilkan notifikasi jika diperlukan
                            showToast('Produk dihapus dari wishlist');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                });
            });
            
            // Fungsi untuk menampilkan toast notification
            function showToast(message) {
                const toast = document.createElement('div');
                toast.className = 'position-fixed bottom-0 end-0 p-3';
                toast.style.zIndex = '11';
                toast.innerHTML = `
                    <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header">
                            <strong class="me-auto">TokoKU</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body">
                            ${message}
                        </div>
                    </div>
                `;
                document.body.appendChild(toast);
                
                // Auto hide after 3 seconds
                setTimeout(() => {
                    toast.remove();
                }, 3000);
            }
        });
    </script>
    @endauth
    
    @stack('scripts')
</body>
</html>
