@extends('layouts.app')

@section('title', 'Checkout - TokoKU')

@push('scripts')
<script>
// Script global untuk memastikan tombol-tombol kuantitas berfungsi
document.addEventListener('click', function(e) {
    // Menggunakan event delegation untuk menangani klik pada tombol kuantitas
    if (e.target && e.target.classList.contains('quantity-decrease-btn')) {
        const input = e.target.parentNode.querySelector('input[type="number"]');
        if (input) {
            const currentValue = parseInt(input.value) || 1;
            if (currentValue > 1) {
                input.value = currentValue - 1;
                // Trigger event untuk update total
                const event = new Event('input', { bubbles: true });
                input.dispatchEvent(event);
            }
        }
    }
    
    if (e.target && e.target.classList.contains('quantity-increase-btn')) {
        const input = e.target.parentNode.querySelector('input[type="number"]');
        if (input) {
            const currentValue = parseInt(input.value) || 1;
            const maxValue = parseInt(input.getAttribute('max')) || 100;
            if (currentValue < maxValue) {
                input.value = currentValue + 1;
                // Trigger event untuk update total
                const event = new Event('input', { bubbles: true });
                input.dispatchEvent(event);
            }
        }
    }
});
</script>
@endpush

@section('content')
<style>
    .quantity-input {
        max-width: 60px;
        text-align: center;
    }
    .quantity-btn {
        min-width: 30px;
        padding: 0.25rem 0.5rem;
    }
    .input-group-sm .form-control {
        height: calc(1.5em + 0.5rem + 2px);
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        line-height: 1.5;
        border-radius: 0.2rem;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="mb-4">
                <h1 class="h2 mb-0">
                    <i class="fas fa-shopping-cart text-primary"></i> Checkout
                </h1>
                <p class="text-muted">Mohon lengkapi informasi berikut untuk menyelesaikan pembelian</p>
            </div>
            
            @if(session('error'))
            <div class="alert alert-danger mb-4">
                {{ session('error') }}
            </div>
            @endif
            
            <!-- Pesan fitur belum tersedia (diatur melalui variabel di controller) -->
            @if(isset($checkoutDisabled) && $checkoutDisabled)
            <div class="alert alert-warning mb-4">
                <h5 class="alert-heading"><i class="fas fa-tools me-2"></i>Fitur Sedang Dikembangkan</h5>
                <p class="mb-0">Mohon maaf, fitur checkout saat ini sedang dalam pengembangan. Silakan coba lagi nanti.</p>
            </div>
            @endif
            
            <div class="row">
                <!-- Checkout Form -->
                <div class="col-lg-8 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <form id="checkout-form" method="POST" action="{{ route('orders.store') }}">
                                @csrf
                                
                                <!-- Cart Items (Hidden fields) -->
                                <div id="cart-items-container">
                                    <!-- Will be populated by JavaScript -->
                                </div>
                                
                                <!-- Shipping Information -->
                                <h5 class="mb-3">Informasi Pengiriman</h5>
                                <div class="mb-4">
                                    <label for="shipping_name" class="form-label">Nama Penerima</label>
                                    <input type="text" class="form-control @error('shipping_name') is-invalid @enderror" id="shipping_name" name="shipping_name" value="{{ old('shipping_name', Auth::user()->name) }}">
                                    @error('shipping_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="shipping_phone" class="form-label">Nomor Telepon</label>
                                    <input type="text" class="form-control @error('shipping_phone') is-invalid @enderror" id="shipping_phone" name="shipping_phone" value="{{ old('shipping_phone', Auth::user()->phone) }}">
                                    @error('shipping_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="shipping_address" class="form-label">Alamat Lengkap</label>
                                    <textarea class="form-control @error('shipping_address') is-invalid @enderror" id="shipping_address" name="shipping_address" rows="3">{{ old('shipping_address', Auth::user()->address) }}</textarea>
                                    @error('shipping_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="shipping_city" class="form-label">Kota</label>
                                        <input type="text" class="form-control @error('shipping_city') is-invalid @enderror" id="shipping_city" name="shipping_city" value="{{ old('shipping_city', Auth::user()->city) }}">
                                        @error('shipping_city')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label for="shipping_postal_code" class="form-label">Kode Pos</label>
                                        <input type="text" class="form-control @error('shipping_postal_code') is-invalid @enderror" id="shipping_postal_code" name="shipping_postal_code" value="{{ old('shipping_postal_code', Auth::user()->postal_code) }}">
                                        @error('shipping_postal_code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <!-- Shipping Method -->
                                <h5 class="mb-3">Metode Pengiriman</h5>
                                <div class="mb-4">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input shipping-method" type="radio" name="shipping_method" id="shipping_regular" value="regular" checked>
                                        <label class="form-check-label" for="shipping_regular">
                                            <i class="fas fa-truck me-2"></i> Pengiriman Reguler
                                        </label>
                                        <div class="form-text small text-muted ms-4">Rp 10.000 - Estimasi pengiriman 3-5 hari kerja</div>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input shipping-method" type="radio" name="shipping_method" id="shipping_express" value="express" 
                                            {{ old('shipping_method') == 'express' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="shipping_express">
                                            <i class="fas fa-shipping-fast me-2"></i> Pengiriman Ekspres
                                        </label>
                                        <div class="form-text small text-muted ms-4">Rp 20.000 - Estimasi pengiriman 1-2 hari kerja</div>
                                    </div>
                                </div>
                                
                                <!-- Payment Method -->
                                <h5 class="mb-3">Metode Pembayaran</h5>
                                <div class="mb-4">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="payment_method" id="payment_transfer" value="transfer" 
                                            {{ old('payment_method', 'transfer') == 'transfer' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="payment_transfer">
                                            <i class="fas fa-university me-2"></i> Transfer Bank
                                        </label>
                                        <div class="form-text small text-muted ms-4">untuk pembayaran masih dalam tahap pengembangan </div>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="payment_method" id="payment_wallet" value="wallet" 
                                            {{ old('payment_method') == 'wallet' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="payment_wallet">
                                            <i class="fas fa-wallet me-2"></i> E-Wallet (DANA, OVO, Gopay)
                                        </label>
                                        <div class="form-text small text-muted ms-4">untuk pembayaran masih dalam tahap pengembangan</div>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method" id="payment_cod" value="cod" 
                                            {{ old('payment_method') == 'cod' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="payment_cod">
                                            <i class="fas fa-hand-holding-usd me-2"></i> Bayar di Tempat (COD)
                                        </label>
                                        <div class="form-text small text-muted ms-4">untuk pembayaran masih dalam tahap pengembangan</div>
                                    </div>
                                </div>
                                
                                <!-- Notes -->
                                <div class="mb-4">
                                    <label for="notes" class="form-label">Catatan (Opsional)</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="2" placeholder="Catatan tambahan untuk pesanan ini">{{ old('notes') }}</textarea>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Order Summary -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm sticky-lg-top" style="top: 100px;">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Ringkasan Pesanan</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3" id="cart-summary">
                                <!-- Will be populated by JavaScript -->
                                <div class="text-center py-4">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" form="checkout-form" id="submitOrderBtn" class="btn btn-primary btn-lg">
                                    <i class="fas fa-check-circle me-2"></i>Selesaikan Pesanan
                                </button>
                        @if(isset($directProduct) || request()->has('product_id'))
                            <a href="{{ isset($directProduct) ? url('/produk/'.$directProduct->slug) : url('/produk') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Produk
                            </a>
                        @else
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Lanjutkan Belanja
                            </a>
                        @endif
                    </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Untuk mengosongkan keranjang jika checkout dari halaman success -->
@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        localStorage.removeItem('cart');
        updateCartCount();
        
        // Menampilkan notifikasi sukses (jika ada library toast/notif)
        if (typeof Toastify === 'function') {
            Toastify({
                text: "Pesanan berhasil dibuat! Keranjang telah dikosongkan.",
                duration: 5000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
            }).showToast();
        }
    });
</script>
@endif
<script>
    document.addEventListener('DOMContentLoaded', function() {                // Check if there's a direct purchase from controller data
        @if(isset($directProduct) && isset($directQuantity))
        const directProductId = {{ $directProduct->id }};
        const directQuantity = {{ $directQuantity }};
        const directProductData = {
            id: {{ $directProduct->id }},
            name: "{{ $directProduct->name }}",
            price: {{ $directProduct->price }},
            image: "{{ $directProduct->image }}",
            description: "{{ $directProduct->description }}",
            specifications: "{{ $directProduct->specifications }}",
            stock: {{ $directProduct->stock }}
        };
        const isBuyNow = true;
        @else
        // Check if there's a direct purchase from URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        const directProductId = urlParams.get('product_id');
        const directQuantity = urlParams.get('quantity') || 1;
        const isBuyNow = directProductId ? true : false;
        @endif
        
        // Get cart items from localStorage
        const cartItems = JSON.parse(localStorage.getItem('cart') || '[]');
        
        // If no direct purchase and cart is empty, redirect to home
        if (!directProductId && cartItems.length === 0) {
            window.location.href = '{{ route('home') }}';
            alert('Keranjang Anda kosong. Silakan tambahkan produk terlebih dahulu.');
            return;
        }
        
        // Populate hidden form fields for cart items or direct product
        const cartItemsContainer = document.getElementById('cart-items-container');
        
        if (directProductId) {                // Direct purchase - Use product data from controller or fetch from API
                const handleDirectProduct = function(product) {
                    // Add direct product to form
                    const productIdInput = document.createElement('input');
                    productIdInput.type = 'hidden';
                    productIdInput.name = `items[0][product_id]`;
                    productIdInput.value = product.id;
                    cartItemsContainer.appendChild(productIdInput);
                    
                    // Create quantity input and add it to the form
                    const initialQuantity = parseInt(directQuantity) || 1;
                    const quantityInput = document.createElement('input');
                    quantityInput.type = 'hidden';
                    quantityInput.name = `items[0][quantity]`;
                    quantityInput.value = initialQuantity;
                    cartItemsContainer.appendChild(quantityInput);
                    
                    // Calculate and display order summary
                    const cartSummary = document.getElementById('cart-summary');
                    let summaryHTML = '';
                    
                    // Add an indicator that this is a direct purchase
                    if (isBuyNow) {
                        summaryHTML += `
                            <div class="alert alert-success mb-3">
                                <i class="fas fa-bolt me-2"></i>
                                <strong>Pembelian Langsung</strong> - Anda akan melakukan checkout untuk produk ini.
                            </div>
                        `;
                    }
                    
                    const quantity = initialQuantity;
                    const itemTotal = product.price * quantity;
                    const subtotal = itemTotal;
                
                summaryHTML += `
                    <div class="mb-3">
                        <div class="mb-2">
                            <h6 class="mb-0">${product.name}</h6>
                            <div class="text-muted small">Harga: Rp ${number_format(product.price)}</div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <label class="me-2 text-muted">Jumlah:</label>
                                <div class="input-group input-group-sm" style="width: 120px;">
                                    <button type="button" class="btn btn-outline-secondary quantity-decrease-btn">-</button>
                                    <input type="number" name="items[0][quantity]" class="form-control text-center quantity-input" value="${quantity}" min="1" max="${product.stock}" required>
                                    <button type="button" class="btn btn-outline-secondary quantity-increase-btn">+</button>
                                </div>
                            </div>
                            <span class="item-total fw-bold">Rp ${number_format(itemTotal)}</span>
                        </div>
                    </div>
                `;
                
                // Initialize shipping cost (default: regular)
                let shippingCost = 10000;
                const shippingMethodEl = document.querySelector('input[name="shipping_method"]:checked');
                if (shippingMethodEl && shippingMethodEl.value === 'express') {
                    shippingCost = 20000;
                }
                const total = subtotal + shippingCost;
                
                summaryHTML += `
                    <hr>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <span>Rp ${number_format(subtotal)}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Pengiriman</span>
                        <span>Rp ${number_format(shippingCost)}</span>
                    </div>
                    <div class="d-flex justify-content-between fw-bold">
                        <span>Total</span>
                        <span>Rp ${number_format(total)}</span>
                    </div>
                    
                    <input type="hidden" name="subtotal" value="${subtotal}">
                    <input type="hidden" name="shipping_cost" value="${shippingCost}">
                    <input type="hidden" name="total_amount" value="${total}">
                `;
                
                cartSummary.innerHTML = summaryHTML;
                
                // Setelah merender HTML, pasang event listener untuk tombol kuantitas
                setupQuantityButtons();
            };
            
            @if(isset($directProduct))
            // If we have direct product data from controller
            const directProductData = {
                id: {{ $directProduct->id }},
                name: "{{ $directProduct->name }}",
                price: {{ $directProduct->price }},
                image: "{{ $directProduct->image }}"
            };
            handleDirectProduct(directProductData);
            @else
            // If we need to fetch product data
            fetch(`/api/products/${directProductId}`)
                .then(response => response.json())
                .then(product => {
                    handleDirectProduct(product);
                })
                .catch(error => {
                    console.error('Error fetching product:', error);
                    window.location.href = '{{ route('home') }}';
                    alert('Produk tidak ditemukan.');
                });
            @endif
        } else {
            // Cart items
            cartItems.forEach((item, index) => {
                const productIdInput = document.createElement('input');
                productIdInput.type = 'hidden';
                productIdInput.name = `items[${index}][product_id]`;
                productIdInput.value = item.id;
                cartItemsContainer.appendChild(productIdInput);
                
                const quantityInput = document.createElement('input');
                quantityInput.type = 'hidden';
                quantityInput.name = `items[${index}][quantity]`;
                quantityInput.value = item.quantity;
                cartItemsContainer.appendChild(quantityInput);
            });
            
            // Populate order summary
            const cartSummary = document.getElementById('cart-summary');
            
            let summaryHTML = '';
            let subtotal = 0;
            
            cartItems.forEach(item => {
                const itemTotal = item.price * item.quantity;
                subtotal += itemTotal;
                
                summaryHTML += `
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="mb-0">${item.name}</h6>
                            <small class="text-muted">${item.quantity} x Rp ${number_format(item.price)}</small>
                        </div>
                        <span>Rp ${number_format(itemTotal)}</span>
                    </div>
                `;
            });
            
            // Initialize shipping cost (default: regular)
            let shippingCost = 10000;
            const shippingMethodEl = document.querySelector('input[name="shipping_method"]:checked');
            if (shippingMethodEl && shippingMethodEl.value === 'express') {
                shippingCost = 20000;
            }
            const total = subtotal + shippingCost;
            
            summaryHTML += `
                <hr>
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal</span>
                    <span>Rp ${number_format(subtotal)}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Pengiriman</span>
                    <span>Rp ${number_format(shippingCost)}</span>
                </div>
                <div class="d-flex justify-content-between fw-bold">
                    <span>Total</span>
                    <span>Rp ${number_format(total)}</span>
                </div>
                
                <input type="hidden" name="subtotal" value="${subtotal}">
                <input type="hidden" name="shipping_cost" value="${shippingCost}">
                <input type="hidden" name="total_amount" value="${total}">
            `;
            
            cartSummary.innerHTML = summaryHTML;
        }
        
        // Helper function to format numbers with thousand separator
        function number_format(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
        
        // Debug function to help troubleshoot form issues
        function debugLog(message, data = null) {
            const debugMode = true; // Set to false in production
            if (debugMode) {
                console.log(`[CHECKOUT DEBUG] ${message}`, data || '');
            }
        }
        
        // Handle form submission
        const checkoutForm = document.getElementById('checkout-form');
        const submitOrderBtn = document.getElementById('submitOrderBtn');
        
        debugLog('Checkout form initialized', { 
            formExists: !!checkoutForm, 
            buttonExists: !!submitOrderBtn 
        });
        
        if (checkoutForm && submitOrderBtn) {
            // Prevent double submission
            checkoutForm.addEventListener('submit', function(e) {
                debugLog('Form submission started');
                
                // Check if the form has already been submitted
                if (this.classList.contains('submitting')) {
                    debugLog('Form already submitting - preventing resubmission');
                    e.preventDefault();
                    return false;
                }
                
                // Validate form fields
                const requiredFields = ['shipping_name', 'shipping_phone', 'shipping_address', 'shipping_city', 'shipping_postal_code'];
                debugLog('Validating required fields', requiredFields);
                let isValid = true;
                
                for (const fieldName of requiredFields) {
                    const field = document.getElementById(fieldName);
                    if (!field || !field.value.trim()) {
                        isValid = false;
                        if (field) {
                            field.classList.add('is-invalid');
                            debugLog(`Field validation failed: ${fieldName}`, { value: field ? field.value : 'field not found' });
                        }
                    } else if (field) {
                        field.classList.remove('is-invalid');
                        debugLog(`Field validation passed: ${fieldName}`);
                    }
                }
                
                // Check if there are any items in the cart
                const itemInputs = document.querySelectorAll('input[name^="items["][name$="[product_id]"]');
                debugLog('Found product items in form', { count: itemInputs.length, items: Array.from(itemInputs).map(i => i.value) });
                
                if (itemInputs.length === 0) {
                    isValid = false;
                    alert('Tidak ada produk dalam pesanan Anda.');
                    debugLog('No products found in order - validation failed');
                    
                    // If this is a direct checkout, try to recover by adding the product again
                    if (directProductId) {
                        // This is a direct purchase but somehow the inputs are missing
                        // Let's recreate them
                        @if(isset($directProduct))
                        const product = {
                            id: {{ $directProduct->id }},
                            name: "{{ $directProduct->name }}",
                            price: {{ $directProduct->price }}
                        };
                        const qty = {{ $directQuantity }};
                        
                        const productIdInput = document.createElement('input');
                        productIdInput.type = 'hidden';
                        productIdInput.name = `items[0][product_id]`;
                        productIdInput.value = product.id;
                        cartItemsContainer.appendChild(productIdInput);
                        
                        const quantityInput = document.createElement('input');
                        quantityInput.type = 'hidden';
                        quantityInput.name = `items[0][quantity]`;
                        quantityInput.value = qty;
                        cartItemsContainer.appendChild(quantityInput);
                        
                        // Now we can continue
                        isValid = true;
                        @endif
                    }
                }
                
                if (!isValid) {
                    e.preventDefault();
                    alert('Mohon lengkapi semua field yang diperlukan.');
                    debugLog('Form validation failed - preventing submission');
                    return false;
                }
                
                // Ensure payment and shipping methods are selected
                const shippingMethod = document.querySelector('input[name="shipping_method"]:checked');
                const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
                
                debugLog('Checking shipping and payment methods', {
                    shippingSelected: !!shippingMethod,
                    shippingValue: shippingMethod ? shippingMethod.value : null,
                    paymentSelected: !!paymentMethod,
                    paymentValue: paymentMethod ? paymentMethod.value : null
                });
                
                if (!shippingMethod || !paymentMethod) {
                    e.preventDefault();
                    alert('Mohon pilih metode pengiriman dan pembayaran.');
                    debugLog('Missing shipping or payment method - preventing submission');
                    return false;
                }
                
                // Show loading state
                submitOrderBtn.disabled = true;
                submitOrderBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Memproses...';
                this.classList.add('submitting');
                
                debugLog('Form validation passed - submitting form');
                
                // Continue with form submission
                return true;
            });
        }
        
        // Add event listeners for shipping method changes
        const shippingMethodInputs = document.querySelectorAll('.shipping-method');
        shippingMethodInputs.forEach(input => {
            input.addEventListener('change', updateShippingCost);
        });
        
        function updateShippingCost() {
            // Get the current shipping method
            const isExpress = document.getElementById('shipping_express').checked;
            const shippingCost = isExpress ? 20000 : 10000;
            
            // Get the current subtotal from hidden input
            const subtotal = parseFloat(document.querySelector('input[name="subtotal"]').value);
            const total = subtotal + shippingCost;
            
            // Update the shipping cost display
            const shippingEl = document.querySelector('.d-flex.justify-content-between:nth-child(8) span:last-child');
            if (shippingEl) {
                shippingEl.textContent = `Rp ${number_format(shippingCost)}`;
            }
            
            // Update the total display
            const totalEl = document.querySelector('.d-flex.justify-content-between.fw-bold span:last-child');
            if (totalEl) {
                totalEl.textContent = `Rp ${number_format(total)}`;
            }
            
            // Update hidden inputs
            document.querySelector('input[name="shipping_cost"]').value = shippingCost;
            document.querySelector('input[name="total_amount"]').value = total;
        }
        
        // Handle quantity change for direct purchase
        function setupQuantityButtons() {
            const decreaseBtn = document.querySelector('.quantity-decrease-btn');
            const increaseBtn = document.querySelector('.quantity-increase-btn');
            const quantityInput = document.querySelector('.quantity-input');
            
            if (quantityInput) {
                // Add event listeners to quantity buttons
                if (decreaseBtn) {
                    decreaseBtn.addEventListener('click', function() {
                        const currentValue = parseInt(quantityInput.value);
                        if (currentValue > 1) {
                            quantityInput.value = currentValue - 1;
                            // Update totals
                            updateDirectProductTotal();
                        }
                    });
                }
                
                if (increaseBtn) {
                    increaseBtn.addEventListener('click', function() {
                        const currentValue = parseInt(quantityInput.value);
                        const maxValue = parseInt(quantityInput.getAttribute('max'));
                        if (currentValue < maxValue) {
                            quantityInput.value = currentValue + 1;
                            // Update totals
                            updateDirectProductTotal();
                        }
                    });
                }
                
                // Also listen for direct input changes
                quantityInput.addEventListener('input', function() {
                    let currentValue = parseInt(this.value) || 0;
                    const maxValue = parseInt(this.getAttribute('max'));
                    
                    // Validate min/max values
                    if (currentValue < 1) {
                        currentValue = 1;
                        this.value = 1;
                    } else if (currentValue > maxValue) {
                        currentValue = maxValue;
                        this.value = maxValue;
                    }
                    
                    // Update totals
                    updateDirectProductTotal();
                });
            }
        }
        
        // Update totals when quantity changes for direct purchase
        function updateDirectProductTotal() {
            @if(isset($directProduct))
            const productPrice = {{ $directProduct->price }};
            const quantityInput = document.querySelector('input[name="items[0][quantity]"]');
            if (quantityInput) {
                const quantity = parseInt(quantityInput.value) || 1;
                const itemTotal = productPrice * quantity;
                
                // Update item total display
                const itemTotalEl = document.querySelector('.item-total');
                if (itemTotalEl) {
                    itemTotalEl.textContent = `Rp ${number_format(itemTotal)}`;
                }
                
                // Update subtotal, hidden inputs and recalculate total
                const subtotalInput = document.querySelector('input[name="subtotal"]');
                if (subtotalInput) {
                    subtotalInput.value = itemTotal;
                
                // Update shipping cost which will also update the total
                updateShippingCost();
                }
            }
            @endif
            
            // Use the debug function for consistency
            debugLog('Quantity updated to: ' + (quantityInput ? quantityInput.value : 'undefined'));
        }
        
        // Hapus setTimeout dan integrasikan ke dalam handleDirectProduct
        // Fungsi akan dipanggil langsung setelah HTML dirender
        
        // Form submission for cart clearing
        // Make sure we're not adding another event listener if one exists already
        if (!checkoutForm.hasAttribute('data-cart-clear-listener')) {
            checkoutForm.setAttribute('data-cart-clear-listener', 'true');
            checkoutForm.addEventListener('submit', function() {
                debugLog('Form submitted successfully, clearing cart if needed');
                // Only clear cart if not direct purchase
                if (!directProductId) {
                    localStorage.removeItem('cart');
                    debugLog('Cart cleared from localStorage');
                } else {
                    debugLog('Direct purchase - cart not cleared');
                }
            });
        }
    });
</script>
@endpush
