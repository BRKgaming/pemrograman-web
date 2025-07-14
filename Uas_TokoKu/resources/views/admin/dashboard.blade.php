@extends('layouts.app')

@section('title', 'Dasbor Admin - TokoKU')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">Dasbor Admin</h2>
            <p class="text-muted">Selamat datang kembali, {{ Auth::user()->name }}! Berikut adalah ringkasan toko Anda.</p>
            <hr>
        </div>
    </div>
    
    @if($lowStockProducts->count() > 0)
    <div class="alert alert-warning alert-dismissible fade show mb-4" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
            <div>
                <h5 class="alert-heading mb-1">Perhatian: Stok Menipis!</h5>
                <p class="mb-0">Terdapat {{ $stats['low_stock_products'] }} produk dengan stok kurang dari 10. <a href="#low-stock-section" class="alert-link">Lihat detail</a> atau <a href="{{ route('admin.inventory.stock-in') }}" class="alert-link">tambah stok sekarang</a>.</p>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    
    <!-- Statistik Utama -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                            <i class="fas fa-users fa-2x text-primary"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Total Pengguna</h6>
                            <h4 class="mb-0">{{ $stats['total_users'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3">
                            <i class="fas fa-box fa-2x text-success"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Total Produk</h6>
                            <h4 class="mb-0">{{ $stats['total_products'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-info bg-opacity-10 p-3 me-3">
                            <i class="fas fa-shopping-bag fa-2x text-info"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Total Pesanan</h6>
                            <h4 class="mb-0">{{ $stats['total_orders'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-warning bg-opacity-10 p-3 me-3">
                            <i class="fas fa-money-bill fa-2x text-warning"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Total Pendapatan</h6>
                            <h4 class="mb-0">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Tambahan -->
    <div class="row g-4 mb-4">
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold">Status Pesanan</h6>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Menunggu</span>
                            <span class="badge bg-warning">{{ $stats['pending_orders'] }}</span>
                        </div>
                        <div class="progress" style="height: 5px;">
                            <div class="progress-bar bg-warning" style="width: {{ ($stats['pending_orders'] / max($stats['total_orders'], 1)) * 100 }}%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Diproses</span>
                            <span class="badge bg-info">{{ $stats['processing_orders'] ?? 0 }}</span>
                        </div>
                        <div class="progress" style="height: 5px;">
                            <div class="progress-bar bg-info" style="width: {{ (($stats['processing_orders'] ?? 0) / max($stats['total_orders'], 1)) * 100 }}%"></div>
                        </div>
                    </div>
                    <div class="mb-0">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Selesai</span>
                            <span class="badge bg-success">{{ $stats['completed_orders'] ?? 0 }}</span>
                        </div>
                        <div class="progress" style="height: 5px;">
                            <div class="progress-bar bg-success" style="width: {{ (($stats['completed_orders'] ?? 0) / max($stats['total_orders'], 1)) * 100 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold">Status Inventaris</h6>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Produk Tersedia</span>
                            <span class="badge bg-success">{{ $stats['available_products'] ?? $stats['total_products'] - $stats['low_stock_products'] }}</span>
                        </div>
                        <div class="progress" style="height: 5px;">
                            <div class="progress-bar bg-success" style="width: {{ (($stats['available_products'] ?? $stats['total_products'] - $stats['low_stock_products']) / max($stats['total_products'], 1)) * 100 }}%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Stok Menipis</span>
                            <span class="badge bg-warning">{{ $stats['low_stock_products'] }}</span>
                        </div>
                        <div class="progress" style="height: 5px;">
                            <div class="progress-bar bg-warning" style="width: {{ ($stats['low_stock_products'] / max($stats['total_products'], 1)) * 100 }}%"></div>
                        </div>
                    </div>
                    <div class="mb-0">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Stok Habis</span>
                            <span class="badge bg-danger">{{ $stats['out_of_stock_products'] ?? 0 }}</span>
                        </div>
                        <div class="progress" style="height: 5px;">
                            <div class="progress-bar bg-danger" style="width: {{ (($stats['out_of_stock_products'] ?? 0) / max($stats['total_products'], 1)) * 100 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold">Aktivitas Hari Ini</h6>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-3">
                            <i class="fas fa-shopping-cart text-primary"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">{{ $stats['today_orders'] ?? 0 }} Pesanan Baru</h6>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-success bg-opacity-10 p-2 me-3">
                            <i class="fas fa-arrow-circle-up text-success"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">{{ $stats['today_stock_in'] ?? 0 }} Transaksi Stok Masuk</h6>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-0">
                        <div class="rounded-circle bg-danger bg-opacity-10 p-2 me-3">
                            <i class="fas fa-arrow-circle-down text-danger"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">{{ $stats['today_stock_out'] ?? 0 }} Transaksi Stok Keluar</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pesanan Terbaru dan Produk Stok Rendah -->
    <div class="row g-4 mb-4">
        <!-- Pesanan Terbaru -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">Pesanan Terbaru</h5>
                        <a href="{{ route('admin.orders') }}" class="btn btn-sm btn-outline-primary">
                            Lihat Semua
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Pelanggan</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders as $order)
                                <tr>
                                    <td>#{{ $order->id }}</td>
                                    <td>{{ $order->user->name }}</td>
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
                                        @else
                                            <span class="badge bg-danger">Dibatalkan</span>
                                        @endif
                                    </td>
                                    <td>{{ $order->created_at->format('d M Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-3">Belum ada pesanan</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Produk Stok Rendah -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm" id="low-stock-section">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">Stok Menipis</h5>
                        <a href="{{ route('admin.products.index') }}?filter=low_stock" class="btn btn-sm btn-outline-warning">
                            Lihat Semua
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Produk</th>
                                    <th>Stok</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lowStockProducts as $product)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="img-thumbnail me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                            <div style="max-width: 200px;">
                                                <div class="text-truncate">{{ $product->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($product->stock <= 0)
                                            <span class="badge bg-danger">Habis</span>
                                        @else
                                            <span class="badge bg-warning">{{ $product->stock }} tersisa</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.inventory.stock-in') }}?product={{ $product->id }}" class="btn btn-sm btn-success">
                                            <i class="fas fa-plus-circle"></i> Tambah Stok
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-3">Semua produk memiliki stok yang cukup</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Transaksi Inventaris Terbaru -->
    <div class="row g-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">Aktivitas Inventaris Terbaru</h5>
                        <a href="{{ route('admin.inventory.index') }}" class="btn btn-sm btn-outline-primary">
                            Lihat Semua
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Produk</th>
                                    <th>Tipe</th>
                                    <th>Jumlah</th>
                                    <th>Staff</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentInventory as $transaction)
                                <tr>
                                    <td>{{ $transaction->created_at->format('d M Y H:i') }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset($transaction->product->image) }}" alt="{{ $transaction->product->name }}" class="img-thumbnail me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                            <span class="text-truncate" style="max-width: 150px;">{{ $transaction->product->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if($transaction->type == 'in')
                                            <span class="badge bg-success">Masuk</span>
                                        @else
                                            <span class="badge bg-danger">Keluar</span>
                                        @endif
                                    </td>
                                    <td>{{ $transaction->quantity }}</td>
                                    <td>{{ $transaction->user->name }}</td>
                                    <td class="text-truncate" style="max-width: 200px;">{{ $transaction->notes ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-3">Belum ada transaksi inventaris</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
