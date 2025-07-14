@extends('layouts.app')

@section('title', 'Dashboard - Laravel App')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h2">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </h1>
                <div class="text-muted">
                    <i class="fas fa-clock"></i> {{ $stats['last_login'] }}
                </div>
            </div>
        </div>
    </div>

    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <div class="bg-primary rounded-circle p-3">
                                <i class="fas fa-user text-white fa-2x"></i>
                            </div>
                        </div>
                        <div>
                            <h4 class="mb-1">{{ $stats['welcome_message'] }}</h4>
                            <p class="text-muted mb-0">Selamat datang kembali di dashboard Anda</p>
                            
                            <!-- Tombol untuk menampilkan informasi alamat -->
                            <button class="btn btn-sm btn-outline-primary mt-2" type="button" data-bs-toggle="collapse" data-bs-target="#userAddressInfo" aria-expanded="false" aria-controls="userAddressInfo">
                                <i class="fas fa-map-marker-alt"></i> Lihat Informasi Alamat
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Informasi Alamat (Collapsed) -->
                <div class="collapse mt-3" id="userAddressInfo">
                    <div class="card card-body border-0 bg-light">
                        <h5 class="mb-3"><i class="fas fa-address-card text-primary"></i> Informasi Alamat Anda</h5>
                        
                        @if(Auth::user()->address || Auth::user()->phone || Auth::user()->city || Auth::user()->postal_code)
                            <div class="row">
                                @if(Auth::user()->address)
                                <div class="col-md-6 mb-2">
                                    <label class="text-muted small">Alamat:</label>
                                    <p class="mb-1">{{ Auth::user()->address }}</p>
                                </div>
                                @endif
                                
                                @if(Auth::user()->phone)
                                <div class="col-md-6 mb-2">
                                    <label class="text-muted small">Telepon:</label>
                                    <p class="mb-1">{{ Auth::user()->phone }}</p>
                                </div>
                                @endif
                                
                                @if(Auth::user()->city)
                                <div class="col-md-6 mb-2">
                                    <label class="text-muted small">Kota:</label>
                                    <p class="mb-1">{{ Auth::user()->city }}</p>
                                </div>
                                @endif
                                
                                @if(Auth::user()->postal_code)
                                <div class="col-md-6 mb-2">
                                    <label class="text-muted small">Kode Pos:</label>
                                    <p class="mb-1">{{ Auth::user()->postal_code }}</p>
                                </div>
                                @endif
                            </div>
                            
                            <div class="mt-2">
                                <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i> Perbarui Alamat
                                </a>
                            </div>
                        @else
                            <div class="alert alert-info mb-0">
                                <i class="fas fa-info-circle"></i> Anda belum mengisi informasi alamat.
                                <div class="mt-2">
                                    <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-plus-circle"></i> Tambahkan Alamat Sekarang
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">                        <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Pesanan Anda
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['total_orders'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-bag fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">                        <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Produk Dibeli
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $purchasedProducts->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">                        <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Pesanan Selesai
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['completed_orders'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">                        <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Pengeluaran
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Rp {{ number_format($stats['total_spent'], 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt"></i> Aksi Cepat
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="d-grid">
                                <a href="{{ route('orders.index') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-shopping-bag"></i> Lihat Semua Pesanan
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="d-grid">
                                <a href="{{ route('products.index') }}" class="btn btn-outline-success">
                                    <i class="fas fa-shopping-cart"></i> Belanja Lagi
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="d-grid">
                                <a href="{{ route('wishlist.index') }}" class="btn btn-outline-danger">
                                    <i class="fas fa-heart"></i> Wishlist Saya
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="d-grid">
                                <a href="{{ route('profile.edit') }}" class="btn btn-outline-info">
                                    <i class="fas fa-user-edit"></i> Edit Profil
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 mt-3">
                            <div class="d-grid">
                                <a href="{{ route('home') }}" class="btn btn-outline-warning">
                                    <i class="fas fa-home"></i> Halaman Utama
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Riwayat Pesanan -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0">
                        <i class="fas fa-receipt"></i> Riwayat Pesanan Anda
                    </h5>
                </div>
                <div class="card-body">
                    @if($recentOrders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID Pesanan</th>
                                        <th>Tanggal</th>
                                        <th>Produk</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentOrders as $order)
                                        <tr>
                                            <td>#{{ $order->id }}</td>
                                            <td>{{ $order->created_at->format('d M Y') }}</td>
                                            <td>
                                                @foreach($order->orderItems->take(2) as $item)
                                                    <span class="badge bg-light text-dark">{{ $item->product->name }}</span>
                                                @endforeach
                                                @if($order->orderItems->count() > 2)
                                                    <span class="badge bg-secondary">+{{ $order->orderItems->count() - 2 }} lagi</span>
                                                @endif
                                            </td>
                                            <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                            <td>
                                                @if($order->status == 'pending')
                                                    <span class="badge bg-warning">Menunggu</span>
                                                @elseif($order->status == 'processing')
                                                    <span class="badge bg-info">Diproses</span>
                                                @elseif($order->status == 'shipped')
                                                    <span class="badge bg-primary">Dikirim</span>
                                                @elseif($order->status == 'delivered')
                                                    <span class="badge bg-success">Selesai</span>
                                                @elseif($order->status == 'cancelled')
                                                    <span class="badge bg-danger">Dibatalkan</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
                            <h6 class="text-muted">Anda belum memiliki pesanan</h6>
                            <a href="{{ route('products.index') }}" class="btn btn-primary">
                                <i class="fas fa-shopping-cart"></i> Mulai Berbelanja
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Produk yang Dibeli -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0">
                        <i class="fas fa-shopping-basket"></i> Produk yang Telah Anda Beli
                    </h5>
                </div>
                <div class="card-body">
                    @if($recentProducts->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th>Kategori</th>
                                        <th>Harga</th>
                                        <th>Stok</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentProducts as $product)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($product->image)
                                                        <img src="{{ asset('img/products/' . $product->image) }}" class="rounded me-3" width="40" height="40" style="object-fit: cover;">
                                                    @else
                                                        <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                            <i class="fas fa-image text-muted"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <h6 class="mb-0">{{ $product->name }}</h6>
                                                        <small class="text-muted">{{ $product->created_at->format('d M Y') }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary">{{ $product->category->name }}</span>
                                            </td>
                                            <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                            <td>{{ $product->stock }}</td>
                                            <td>
                                                @if($product->is_featured)
                                                    <span class="badge bg-warning">Featured</span>
                                                @else
                                                    <span class="badge bg-secondary">Regular</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('products.show', $product->slug) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('products.edit', $product->slug) }}" class="btn btn-sm btn-outline-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                            <h6 class="text-muted">Anda belum melakukan pembelian produk apapun</h6>
                            <a href="{{ route('products.index') }}" class="btn btn-primary">
                                <i class="fas fa-shopping-cart"></i> Jelajahi Produk
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0">
                        <i class="fas fa-history"></i> Aktivitas Akun
                    </h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Login Berhasil</h6>
                                <p class="text-muted mb-0">Anda berhasil masuk ke akun</p>
                                <small class="text-muted">{{ $stats['last_login'] }}</small>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Akun Dibuat</h6>
                                <p class="text-muted mb-0">Akun Anda berhasil dibuat</p>
                                <small class="text-muted">{{ Auth::user()->created_at->format('d F Y, H:i') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .timeline {
        position: relative;
        padding-left: 30px;
    }
    
    .timeline::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e9ecef;
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 30px;
    }
    
    .timeline-marker {
        position: absolute;
        left: -23px;
        top: 0;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        border: 2px solid #fff;
        box-shadow: 0 0 0 2px #e9ecef;
    }
    
    .timeline-content {
        padding-left: 20px;
    }
    
    .text-xs {
        font-size: 0.75rem;
    }
    
    .font-weight-bold {
        font-weight: 700;
    }
    
    .text-gray-800 {
        color: #5a5c69;
    }
    
    .text-gray-300 {
        color: #dddfeb;
    }
    
    .card {
        transition: all 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1) !important;
    }
</style>
@endpush
