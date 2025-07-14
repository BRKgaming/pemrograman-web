@extends('layouts.app')

@section('title', 'Kelola Pesanan - Admin TokoKU')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-orders.css') }}">
<style>
    /* Modal backdrop fix */
    .modal-backdrop {
        opacity: 0.5;
        z-index: 1040 !important;
    }
    
    .modal {
        z-index: 1050 !important;
    }
    
    /* Ensure modals appear on top of everything */
    .modal-dialog {
        z-index: 1055 !important;
    }
    
    /* Fix for modal animations */
    .modal.fade .modal-dialog {
        transform: translate(0, -10px);
        transition: transform 0.3s ease-out;
    }
    
    .modal.show .modal-dialog {
        transform: translate(0, 0);
    }
    
    /* Fix for multiple modals */
    body.modal-open {
        overflow: hidden;
        padding-right: 17px; /* Width of scrollbar */
    }
    
    /* Fix for modal content scrolling */
    .modal-body {
        max-height: calc(100vh - 200px);
        overflow-y: auto;
    }
</style>
@endpush

@section('content')
<div class="container mt-5 pt-5">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="fw-bold">Kelola Pesanan</h2>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
                </a>
            </div>
            <p class="text-muted">Kelola semua pesanan pelanggan di sini.</p>
            <hr>
        </div>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.orders') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-7">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan ID atau nama pelanggan" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </div>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.orders') }}" class="btn btn-outline-secondary w-100">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">ID Pesanan</th>
                            <th scope="col">Pelanggan</th>
                            <th scope="col">Total</th>
                            <th scope="col">Status</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm dropdown-toggle 
                                        @if($order->status == 'pending') btn-warning
                                        @elseif($order->status == 'processing') btn-info
                                        @elseif($order->status == 'shipped') btn-primary
                                        @elseif($order->status == 'delivered') btn-success
                                        @else btn-danger @endif"
                                        type="button" data-bs-toggle="dropdown">
                                        {{ ucfirst($order->status) }}
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="pending">
                                                <button type="submit" class="dropdown-item {{ $order->status == 'pending' ? 'active' : '' }}">
                                                    <span class="badge bg-warning me-2">●</span> Pending
                                                </button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="processing">
                                                <button type="submit" class="dropdown-item {{ $order->status == 'processing' ? 'active' : '' }}">
                                                    <span class="badge bg-info me-2">●</span> Processing
                                                </button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="shipped">
                                                <button type="submit" class="dropdown-item {{ $order->status == 'shipped' ? 'active' : '' }}">
                                                    <span class="badge bg-primary me-2">●</span> Shipped
                                                </button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="delivered">
                                                <button type="submit" class="dropdown-item {{ $order->status == 'delivered' ? 'active' : '' }}">
                                                    <span class="badge bg-success me-2">●</span> Delivered
                                                </button>
                                            </form>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="cancelled">
                                                <button type="submit" class="dropdown-item {{ $order->status == 'cancelled' ? 'active' : '' }}">
                                                    <span class="badge bg-danger me-2">●</span> Cancelled
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary order-detail-btn" data-bs-toggle="modal" data-bs-target="#orderDetailsModal{{ $order->id }}">
                                    <i class="fas fa-eye"></i> Detail
                                </button>
                                
                                <!-- Order Details Modal -->
                                <div class="modal fade" id="orderDetailsModal{{ $order->id }}" tabindex="-1" aria-labelledby="orderDetailsModalLabel{{ $order->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="orderDetailsModalLabel{{ $order->id }}">Detail Pesanan #{{ $order->id }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-0">
                                                <div class="order-detail-header">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h6 class="fw-bold mb-2">Informasi Pelanggan</h6>
                                                            <p class="mb-1"><i class="fas fa-user me-2 text-secondary"></i>{{ $order->user->name }}</p>
                                                            <p class="mb-1"><i class="fas fa-envelope me-2 text-secondary"></i>{{ $order->user->email }}</p>
                                                            <p class="mb-1"><i class="fas fa-calendar me-2 text-secondary"></i>{{ $order->created_at->format('d M Y H:i') }}</p>
                                                        </div>
                                                        <div class="col-md-6 text-md-end">
                                                            <h6 class="fw-bold mb-2">Status Pesanan</h6>
                                                            <p class="mb-1">
                                                                <span class="order-status-badge badge 
                                                                    @if($order->status == 'pending') bg-warning
                                                                    @elseif($order->status == 'processing') bg-info
                                                                    @elseif($order->status == 'shipped') bg-primary
                                                                    @elseif($order->status == 'delivered') bg-success
                                                                    @else bg-danger @endif">
                                                                    <i class="fas fa-circle me-1" style="font-size: 0.5rem; vertical-align: middle;"></i>
                                                                    {{ ucfirst($order->status) }}
                                                                </span>
                                                            </p>
                                                            <p class="mb-1"><strong class="me-2">Total Pembayaran:</strong> Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                                            <p class="mb-1">
                                                                <strong class="me-2">Metode Pembayaran:</strong>
                                                                <span class="badge bg-secondary">{{ $order->payment_method ?: 'Transfer Bank' }}</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="p-3">
                                                
                                                <h6 class="fw-bold mb-3">Item yang Dibeli</h6>
                                                <div class="table-responsive">
                                                    <table class="table table-sm order-items-table">
                                                        <thead>
                                                            <tr>
                                                                <th width="50%">Produk</th>
                                                                <th width="20%">Harga</th>
                                                                <th width="10%">Qty</th>
                                                                <th width="20%">Subtotal</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($order->orderItems as $item)
                                                            <tr>
                                                                <td class="align-middle">{{ $item->product_name }}</td>
                                                                <td class="align-middle">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                                                <td class="align-middle text-center">{{ $item->quantity }}</td>
                                                                <td class="align-middle">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                
                                                <div class="mt-3 bg-light p-3 rounded">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h6 class="fw-bold mb-2">Informasi Pengiriman</h6>
                                                            <p class="mb-1 small">
                                                                <strong>Alamat:</strong> {{ $order->user->address ?: 'Tidak tercantum' }}
                                                            </p>
                                                            <p class="mb-1 small">
                                                                <strong>Kota:</strong> {{ $order->user->city ?: 'Tidak tercantum' }}
                                                            </p>
                                                            <p class="mb-1 small">
                                                                <strong>Kode Pos:</strong> {{ $order->user->postal_code ?: 'Tidak tercantum' }}
                                                            </p>
                                                            <p class="mb-1 small">
                                                                <strong>Telepon:</strong> {{ $order->user->phone ?: 'Tidak tercantum' }}
                                                            </p>
                                                        </div>
                                                        <div class="col-md-6 text-md-end">
                                                            <h6 class="fw-bold mb-2">Ringkasan Biaya</h6>
                                                            <div class="d-flex justify-content-between">
                                                                <span>Subtotal:</span>
                                                                <span>Rp {{ number_format($order->total_amount - ($order->shipping_cost ?? 0), 0, ',', '.') }}</span>
                                                            </div>
                                                            <div class="d-flex justify-content-between">
                                                                <span>Biaya Pengiriman:</span>
                                                                <span>Rp {{ number_format($order->shipping_cost ?? 0, 0, ',', '.') }}</span>
                                                            </div>
                                                            <hr class="my-2">
                                                            <div class="d-flex justify-content-between">
                                                                <strong>Total:</strong>
                                                                <strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="modal-footer">
                                                <div class="d-flex gap-2 w-100 justify-content-between align-items-center">
                                                    <div>
                                                        <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <div class="input-group">
                                                                <select name="status" class="form-select form-select-sm">
                                                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                                                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                                                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                                </select>
                                                                <button type="submit" class="btn btn-sm btn-primary">
                                                                    <i class="fas fa-check me-1"></i> Update Status
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">Tidak ada pesanan yang ditemukan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $orders->links() }}
    </div>
</div>

@push('scripts')
<script src="{{ asset('js/modal-fix-advanced.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tambahkan kelas untuk status badges
        document.querySelectorAll('.badge').forEach(badge => {
            badge.classList.add('status-badge');
        });
        
        // Perbaikan modal Bootstrap
        const fixModals = function() {
            // Pastikan setiap modal memiliki struktur yang benar
            document.querySelectorAll('.modal').forEach(function(modal) {
                // Tambahkan event listener untuk memastikan modal ditutup dengan benar
                modal.addEventListener('hidden.bs.modal', function() {
                    // Bersihkan sisa backdrop dan kelas
                    setTimeout(function() {
                        document.querySelectorAll('.modal-backdrop').forEach(function(backdrop) {
                            backdrop.remove();
                        });
                        
                        // Hanya hilangkan kelas modal-open jika tidak ada modal lain yang terbuka
                        if (!document.querySelector('.modal.show')) {
                            document.body.classList.remove('modal-open');
                            document.body.style.paddingRight = '';
                            document.body.style.overflow = '';
                        }
                    }, 200);
                });
                
                // Fix untuk interaksi modal
                modal.addEventListener('click', function(e) {
                    // Tutup modal saat mengklik area luar konten modal
                    if (e.target === modal) {
                        const modalInstance = bootstrap.Modal.getInstance(modal);
                        if (modalInstance) {
                            modalInstance.hide();
                        }
                    }
                });
            });
        };
        
        // Jalankan perbaikan modal
        fixModals();
        
        // Handle detail button clicks to ensure modals are properly initialized
        document.querySelectorAll('.order-detail-btn').forEach(function(button) {
            button.addEventListener('click', function(e) {
                // First, ensure any existing backdrops are removed if there's no active modal
                if (!document.querySelector('.modal.show')) {
                    document.querySelectorAll('.modal-backdrop').forEach(function(backdrop) {
                        backdrop.remove();
                    });
                    document.body.classList.remove('modal-open');
                }
                
                // Get the target modal ID
                const modalId = this.getAttribute('data-bs-target');
                const modal = document.querySelector(modalId);
                
                // After modal is shown, ensure it's the top-most element
                const handleShown = function() {
                    // Make sure modal is on top
                    modal.style.zIndex = '1055';
                    
                    // Make sure only one backdrop exists
                    const backdrops = document.querySelectorAll('.modal-backdrop');
                    if (backdrops.length > 1) {
                        // Remove all but the last one
                        for (let i = 0; i < backdrops.length - 1; i++) {
                            backdrops[i].remove();
                        }
                    }
                    
                    // Remove the event listener to avoid duplicates
                    modal.removeEventListener('shown.bs.modal', handleShown);
                };
                
                // Listen for the shown event
                modal.addEventListener('shown.bs.modal', handleShown);
            });
        });
        
        // Stabilkan pencarian dan filter
        const filterForm = document.querySelector('form[action="{{ route('admin.orders') }}"]');
        if (filterForm) {
            // Simpan form sebelum submit untuk mencegah UI flicker
            filterForm.addEventListener('submit', function(e) {
                const submitButton = this.querySelector('button[type="submit"]');
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mencari...';
            });
        }
        
        // Reinitialize Bootstrap modals to ensure they work correctly
        document.querySelectorAll('.modal').forEach(function(modalEl) {
            // Destroy any existing modal instance
            const oldModal = bootstrap.Modal.getInstance(modalEl);
            if (oldModal) oldModal.dispose();
            
            // Create fresh instance with proper options
            new bootstrap.Modal(modalEl, {
                backdrop: true,
                keyboard: true,
                focus: true
            });
        });
    });
</script>
@endpush

@endsection
