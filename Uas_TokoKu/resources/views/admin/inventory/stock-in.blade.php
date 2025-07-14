@extends('layouts.app')

@section('title', 'Tambah Stok - TokoKU')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
@endpush

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="fw-bold">Tambah Stok (Barang Masuk)</h2>
                <div>
                    <a href="{{ route('admin.inventory.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
            <p class="text-muted">Catat barang masuk ke inventaris untuk menambah stok produk.</p>
            <hr>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Form Tambah Stok</h5>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.inventory.process-stock-in') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="product_id" class="form-label">Produk <span class="text-danger">*</span></label>
                            <select name="product_id" id="product_id" class="form-select select2" required>
                                <option value="">-- Pilih Produk --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" 
                                            data-price="{{ $product->price }}" 
                                            data-stock="{{ $product->stock }}"
                                            {{ isset($selectedProduct) && $selectedProduct->id == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }} (Stok: {{ $product->stock }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">Pilih produk yang akan ditambah stoknya.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Jumlah <span class="text-danger">*</span></label>
                            <input type="number" name="quantity" id="quantity" class="form-control" min="1" value="1" required>
                            <div class="form-text">Masukkan jumlah stok yang akan ditambahkan.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="price" class="form-label">Harga Beli per Unit <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="price" id="price" class="form-control" min="0" value="0" required>
                            </div>
                            <div class="form-text">Masukkan harga beli per unit (untuk keperluan laporan).</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="notes" class="form-label">Catatan</label>
                            <textarea name="notes" id="notes" class="form-control" rows="3" placeholder="Contoh: Pembelian dari supplier A, No. Faktur XXX"></textarea>
                            <div class="form-text">Tambahkan catatan jika diperlukan (opsional).</div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Ringkasan</h6>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Produk:</span>
                                        <span id="summary-product">-</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Stok Saat Ini:</span>
                                        <span id="summary-current-stock">-</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Jumlah Ditambahkan:</span>
                                        <span id="summary-quantity">-</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Stok Setelah Ditambahkan:</span>
                                        <span id="summary-new-stock">-</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-0">
                                        <span>Total Nilai Pembelian:</span>
                                        <span id="summary-total" class="fw-bold">-</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-1"></i> Simpan Transaksi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Select2
        $('.select2').select2({
            theme: 'bootstrap-5',
            placeholder: 'Pilih Produk',
            width: '100%'
        });
        
        const productSelect = document.getElementById('product_id');
        const quantityInput = document.getElementById('quantity');
        const priceInput = document.getElementById('price');
        const form = document.querySelector('form');
        
        const summaryProduct = document.getElementById('summary-product');
        const summaryCurrentStock = document.getElementById('summary-current-stock');
        const summaryQuantity = document.getElementById('summary-quantity');
        const summaryNewStock = document.getElementById('summary-new-stock');
        const summaryTotal = document.getElementById('summary-total');
        
        function updateSummary() {
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            const productName = selectedOption ? selectedOption.text.split(' (')[0] : '-';
            const currentStock = selectedOption ? parseInt(selectedOption.dataset.stock) : 0;
            const quantity = parseInt(quantityInput.value) || 0;
            const price = parseFloat(priceInput.value) || 0;
            const newStock = currentStock + quantity;
            const totalValue = quantity * price;
            
            summaryProduct.textContent = productName;
            summaryCurrentStock.textContent = currentStock;
            summaryQuantity.textContent = quantity;
            summaryNewStock.textContent = newStock;
            summaryTotal.textContent = `Rp ${totalValue.toLocaleString('id-ID')}`;
        }
        
        productSelect.addEventListener('change', function() {
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            if (selectedOption.value) {
                priceInput.value = selectedOption.dataset.price;
            } else {
                priceInput.value = 0;
            }
            updateSummary();
        });
        
        // Also trigger change when select2 changes
        $('.select2').on('select2:select', function(e) {
            updateSummary();
        });
        
        quantityInput.addEventListener('input', updateSummary);
        priceInput.addEventListener('input', updateSummary);
        
        // Initial summary
        updateSummary();

        // Tambahkan konfirmasi sebelum submit
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            const productName = selectedOption ? selectedOption.text.split(' (')[0] : '';
            const quantity = parseInt(quantityInput.value) || 0;
            const price = parseFloat(priceInput.value) || 0;
            const totalValue = quantity * price;
            
            Swal.fire({
                title: 'Konfirmasi Penambahan Stok',
                html: `Anda akan menambahkan <strong>${quantity} unit</strong> stok untuk produk <strong>${productName}</strong>. <br><br>
                       Total nilai: <strong>Rp ${totalValue.toLocaleString('id-ID')}</strong>. <br><br>
                       Apakah data sudah benar?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Tambahkan Stok',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
