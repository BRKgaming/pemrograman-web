@extends('layouts.app')

@section('title', 'Kelola Inventaris - TokoKU')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="fw-bold">Kelola Inventaris</h2>
                <div>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Dasbor
                    </a>
                    <a href="{{ route('admin.inventory.stock-in') }}" class="btn btn-success me-2">
                        <i class="fas fa-plus-circle me-1"></i> Barang Masuk
                    </a>
                    <a href="{{ route('admin.inventory.stock-out') }}" class="btn btn-danger me-2">
                        <i class="fas fa-minus-circle me-1"></i> Barang Keluar
                    </a>
                    <a href="{{ route('admin.inventory.report') }}" class="btn btn-info text-white">
                        <i class="fas fa-chart-bar me-1"></i> Laporan
                    </a>
                </div>
            </div>
            <p class="text-muted">Kelola stok masuk dan keluar dari produk anda.</p>
            <hr>
        </div>
    </div>
    
    <!-- Filter and Search -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold">Filter & Pencarian</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.inventory.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Tipe Transaksi</label>
                    <select name="type" class="form-select">
                        <option value="">Semua Tipe</option>
                        <option value="in" {{ request('type') == 'in' ? 'selected' : '' }}>Barang Masuk</option>
                        <option value="out" {{ request('type') == 'out' ? 'selected' : '' }}>Barang Keluar</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Kategori Produk</label>
                    <select name="category" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Produk</label>
                    <select name="product" class="form-select">
                        <option value="">Semua Produk</option>
                        @foreach($productsList as $product)
                            <option value="{{ $product->id }}" {{ request('product') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Cari</label>
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari produk, catatan, atau staff..." value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Periode</label>
                    <div class="input-group">
                        <input type="date" name="start_date" class="form-control" placeholder="Dari Tanggal" value="{{ request('start_date') }}">
                        <span class="input-group-text">hingga</span>
                        <input type="date" name="end_date" class="form-control" placeholder="Sampai Tanggal" value="{{ request('end_date') }}">
                    </div>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <div class="d-grid w-100 gap-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter me-1"></i> Filter
                        </button>
                        <a href="{{ route('admin.inventory.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-sync-alt me-1"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Inventory Transactions Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">Daftar Transaksi Inventaris</h5>
                <span class="badge bg-primary">{{ $transactions->total() }} transaksi</span>
            </div>
        </div>
        <div class="card-body p-0">
            @if(session('success'))
                <div class="alert alert-success m-3">
                    <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Tanggal</th>
                            <th>Produk</th>
                            <th>Tipe</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Total</th>
                            <th>Staff</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                            <tr>
                                <td>#{{ $transaction->id }}</td>
                                <td>{{ $transaction->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset($transaction->product->image) }}" alt="{{ $transaction->product->name }}" class="img-thumbnail me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                        <span>{{ $transaction->product->name }}</span>
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
                                <td>Rp {{ number_format($transaction->price, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($transaction->price * $transaction->quantity, 0, ',', '.') }}</td>
                                <td>{{ $transaction->user->name }}</td>
                                <td>
                                    @if($transaction->notes)
                                        <button type="button" class="btn btn-sm btn-link show-notes" data-bs-toggle="tooltip" title="{{ $transaction->notes }}">
                                            <i class="fas fa-sticky-note"></i> Lihat Catatan
                                        </button>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                        <h5>Belum Ada Transaksi</h5>
                                        <p class="text-muted">Tidak ada transaksi inventaris yang ditemukan.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $transactions->links() }}
    </div>
</div>

<!-- Modal Catatan -->
<div class="modal fade" id="notesModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Catatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="noteContent"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
          return new bootstrap.Tooltip(tooltipTriggerEl)
        });
        
        // Show notes in modal
        const noteButtons = document.querySelectorAll('.show-notes');
        const noteModal = new bootstrap.Modal(document.getElementById('notesModal'));
        const noteContent = document.getElementById('noteContent');
        
        noteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const note = this.getAttribute('data-bs-title');
                noteContent.textContent = note;
                noteModal.show();
            });
        });
    });
</script>
@endpush
