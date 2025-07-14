@extends('layouts.app')

@section('title', 'Laporan Inventaris - TokoKU')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="fw-bold">Laporan Inventaris</h2>
                <div>
                    <a href="{{ route('admin.inventory.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                    <button class="btn btn-primary" onclick="printReport()">
                        <i class="fas fa-print me-1"></i> Cetak Laporan
                    </button>
                </div>
            </div>
            <p class="text-muted">Laporan inventaris produk dan riwayat transaksi.</p>
            <hr>
        </div>
    </div>
    
    <!-- Stock Summary -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold">Ringkasan Stok</h5>
        </div>
        <div class="card-body">
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="border rounded p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Total Produk</h6>
                                <h4 class="mb-0">{{ $products->count() }}</h4>
                            </div>
                            <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                                <i class="fas fa-box fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="border rounded p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Produk Tersedia</h6>
                                <h4 class="mb-0">{{ $products->where('stock', '>', 0)->count() }}</h4>
                            </div>
                            <div class="rounded-circle bg-success bg-opacity-10 p-3">
                                <i class="fas fa-check fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="border rounded p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Stok Menipis</h6>
                                <h4 class="mb-0">{{ $products->whereBetween('stock', [1, 10])->count() }}</h4>
                            </div>
                            <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                                <i class="fas fa-exclamation-triangle fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="border rounded p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Stok Habis</h6>
                                <h4 class="mb-0">{{ $products->where('stock', 0)->count() }}</h4>
                            </div>
                            <div class="rounded-circle bg-danger bg-opacity-10 p-3">
                                <i class="fas fa-times fa-2x text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Filter -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.inventory.report') }}" method="GET" class="row g-3">
                <div class="col-md-3">
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
                    <select name="filter" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="available" {{ request('filter') == 'available' ? 'selected' : '' }}>Tersedia</option>
                        <option value="low_stock" {{ request('filter') == 'low_stock' ? 'selected' : '' }}>Stok Menipis</option>
                        <option value="out_of_stock" {{ request('filter') == 'out_of_stock' ? 'selected' : '' }}>Stok Habis</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari produk..." value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Inventory Report Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold">Detail Inventaris Produk</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="reportTable">
                    <thead class="table-light">
                        <tr>
                            <th>Gambar</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok Masuk</th>
                            <th>Stok Keluar</th>
                            <th>Stok Saat Ini</th>
                            <th>Nilai Inventaris</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                </td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category->name }}</td>
                                <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td>{{ $product->stock_in }}</td>
                                <td>{{ $product->stock_out }}</td>
                                <td>{{ $product->current_stock }}</td>
                                <td>Rp {{ number_format($product->current_stock * $product->price, 0, ',', '.') }}</td>
                                <td>
                                    @if($product->stock <= 0)
                                        <span class="badge bg-danger">Habis</span>
                                    @elseif($product->stock <= 10)
                                        <span class="badge bg-warning">Menipis</span>
                                    @else
                                        <span class="badge bg-success">Tersedia</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.inventory.stock-in') }}?product={{ $product->id }}" class="btn btn-sm btn-success" title="Tambah Stok">
                                            <i class="fas fa-plus-circle"></i>
                                        </a>
                                        @if($product->stock > 0)
                                        <a href="{{ route('admin.inventory.stock-out') }}?product={{ $product->id }}" class="btn btn-sm btn-danger" title="Kurangi Stok">
                                            <i class="fas fa-minus-circle"></i>
                                        </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                        <h5>Belum Ada Produk</h5>
                                        <p class="text-muted">Tidak ada produk yang ditemukan.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <th colspan="6" class="text-end">Total Nilai Inventaris:</th>
                            <th colspan="4">Rp {{ number_format($products->sum(function($product) { return $product->current_stock * $product->price; }), 0, ',', '.') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function printReport() {
        // Create a new window for printing
        const printWindow = window.open('', '_blank');
        
        // Create the content for the print window
        const printContent = `
            <!DOCTYPE html>
            <html>
            <head>
                <title>Laporan Inventaris - TokoKU</title>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                <style>
                    body { font-family: Arial, sans-serif; }
                    .header { text-align: center; margin-bottom: 20px; }
                    .table th, .table td { padding: 8px; }
                    @media print {
                        .no-print { display: none; }
                        @page { size: landscape; }
                    }
                </style>
            </head>
            <body>
                <div class="container mt-4">
                    <div class="header">
                        <h2>LAPORAN INVENTARIS</h2>
                        <h4>TokoKU</h4>
                        <p>Tanggal Cetak: ${new Date().toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' })}</p>
                    </div>
                    
                    ${document.getElementById('reportTable').outerHTML}
                    
                    <div class="text-end mt-4">
                        <p>Dibuat oleh: ${document.querySelector('.dropdown-toggle').innerText.trim()}</p>
                    </div>
                    
                    <div class="no-print text-center mt-4">
                        <button class="btn btn-primary" onclick="window.print()">Cetak</button>
                        <button class="btn btn-secondary" onclick="window.close()">Tutup</button>
                    </div>
                </div>
            </body>
            </html>
        `;
        
        // Write the content to the print window
        printWindow.document.write(printContent);
        printWindow.document.close();
    }
</script>
@endpush
