@extends('layouts.app')

@section('title', 'Kurangi Stok - TokoKU')

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
                <h2 class="fw-bold">Kurangi Stok (Barang Keluar)</h2>
                <div>
                    <a href="{{ route('admin.inventory.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
            <p class="text-muted">Catat barang keluar dari inventaris untuk mengurangi stok produk.</p>
            <hr>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Form Kurangi Stok</h5>
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

                    <form action="{{ route('admin.inventory.process-stock-out') }}" method="POST">
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
                            <div class="form-text">Pilih produk yang akan dikurangi stoknya.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Jumlah <span class="text-danger">*</span></label>
                            <input type="number" name="quantity" id="quantity" class="form-control" min="1" value="1" required>
                            <div class="form-text">Masukkan jumlah stok yang akan dikurangi.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="reason" class="form-label">Alasan <span class="text-danger">*</span></label>
                            <select name="reason" id="reason" class="form-select" required>
                                <option value="">-- Pilih Alasan --</option>
                                <option value="Produk rusak">Produk rusak</option>
                                <option value="Pengecekan kualitas">Pengecekan kualitas</option>
                                <option value="Sampel pameran">Sampel pameran</option>
                                <option value="Penyesuaian stok">Penyesuaian stok</option>
                                <option value="Lainnya">Lainnya (tulis di catatan)</option>
                            </select>
                            <div class="form-text">Pilih alasan pengurangan stok.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="notes" class="form-label">Catatan</label>
                            <textarea name="notes" id="notes" class="form-control" rows="3" placeholder="Berikan detail lebih lanjut tentang alasan pengurangan stok"></textarea>
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
                                        <span>Jumlah Dikurangi:</span>
                                        <span id="summary-quantity">-</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Stok Setelah Dikurangi:</span>
                                        <span id="summary-new-stock">-</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-danger" id="submit-btn">
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
        const submitBtn = document.getElementById('submit-btn');
        const form = document.querySelector('form');
        
        const summaryProduct = document.getElementById('summary-product');
        const summaryCurrentStock = document.getElementById('summary-current-stock');
        const summaryQuantity = document.getElementById('summary-quantity');
        const summaryNewStock = document.getElementById('summary-new-stock');
        
        function updateSummary() {
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            const productName = selectedOption ? selectedOption.text.split(' (')[0] : '-';
            const currentStock = selectedOption ? parseInt(selectedOption.dataset.stock) : 0;
            const quantity = parseInt(quantityInput.value) || 0;
            const newStock = currentStock - quantity;
            
            summaryProduct.textContent = productName;
            summaryCurrentStock.textContent = currentStock;
            summaryQuantity.textContent = quantity;
            summaryNewStock.textContent = newStock;
            
            // Disable submit button if quantity is more than stock
            if (newStock < 0 || !selectedOption || !selectedOption.value) {
                submitBtn.disabled = true;
                if (newStock < 0) {
                    summaryNewStock.innerHTML = `<span class="text-danger">${newStock} (Stok tidak mencukupi)</span>`;
                }
            } else {
                submitBtn.disabled = false;
            }
        }
        
        productSelect.addEventListener('change', function() {
            updateSummary();
            // Set max value for quantity input based on current stock
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            if (selectedOption && selectedOption.value) {
                const currentStock = parseInt(selectedOption.dataset.stock);
                quantityInput.setAttribute('max', currentStock);
                
                // If current quantity is more than stock, adjust it
                if (parseInt(quantityInput.value) > currentStock) {
                    quantityInput.value = currentStock;
                }
            }
        });
        
        // Also trigger change when select2 changes
        $('.select2').on('select2:select', function(e) {
            updateSummary();
        });
        
        quantityInput.addEventListener('input', updateSummary);
        
        // Initial summary
        updateSummary();

        // Tambahkan konfirmasi sebelum submit
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            const productName = selectedOption ? selectedOption.text.split(' (')[0] : '';
            const quantity = parseInt(quantityInput.value) || 0;
            const reason = document.getElementById('reason').options[document.getElementById('reason').selectedIndex].text;
            
            Swal.fire({
                title: 'Konfirmasi Pengurangan Stok',
                html: `Anda akan mengurangi <strong>${quantity} unit</strong> stok dari produk <strong>${productName}</strong>. <br><br>
                       Alasan: <strong>${reason}</strong><br><br>
                       Apakah Anda yakin?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Kurangi Stok',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
        
        // Auto-fill notes when reason is selected
        document.getElementById('reason').addEventListener('change', function() {
            const reason = this.options[this.selectedIndex].text;
            const notes = document.getElementById('notes');
            
            if (this.value === 'Lainnya') {
                notes.placeholder = 'Harap berikan penjelasan detail untuk alasan pengurangan stok';
                notes.focus();
            } else {
                notes.placeholder = `Detail tambahan untuk: ${reason}`;
            }
        });
        
        // If product is preselected, trigger change event
        if (productSelect.value) {
            // Trigger the change event manually
            const event = new Event('change');
            productSelect.dispatchEvent(event);
        }
    });
</script>
@endpush
