@extends('layouts.app')

@section('title', 'Keranjang Belanja - TokoKU')

@section('content')
    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold text-primary">Keranjang Belanja</h1>
            <p class="lead">Kelola produk yang akan Anda beli</p>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div id="cart-items">
                    <!-- Cart items will be loaded here by JavaScript -->
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Ringkasan Pesanan</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span id="subtotal">Rp 0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Total:</span>
                            <span id="total" class="fw-bold">Rp 0</span>
                        </div>
                    
                        <hr>
                        
                        <button class="btn btn-success w-100 mb-2" id="checkout-btn">
                            <i class="fas fa-credit-card me-2"></i>Checkout
                        </button>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-shopping-cart me-2"></i>Lanjut Belanja
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    loadCartItems();

    function loadCartItems() {
        const cartItems = getCartItems();
        const cartContainer = document.getElementById('cart-items');
        
        if (cartItems.length === 0) {
            cartContainer.innerHTML = `
                <div class="text-center py-5">
                    <i class="fas fa-shopping-cart fa-5x text-muted mb-3"></i>
                    <h3>Keranjang Kosong</h3>
                    <p class="text-muted">Belum ada produk di keranjang Anda</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">Mulai Belanja</a>
                </div>
            `;
            updateSummary(0);
            return;
        }

        let html = '';
        cartItems.forEach((item, index) => {
            const itemTotal = item.price * item.quantity;
            html += `
                <div class="card mb-3 cart-item" data-index="${index}">
                    <div class="row g-0">
                        <div class="col-md-2">
                            <img src="${item.image}" class="img-fluid rounded-start h-100" alt="${item.name}" style="object-fit: cover;">
                        </div>
                        <div class="col-md-10">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5 class="card-title">${item.name}</h5>
                                        <p class="card-text text-muted">${item.specifications}</p>
                                        <p class="card-text"><strong>Rp ${item.price.toLocaleString()}</strong></p>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Jumlah:</label>
                                        <div class="input-group">
                                            <button class="btn btn-outline-secondary" type="button" onclick="updateQuantity(${index}, ${item.quantity - 1})">-</button>
                                            <input type="number" class="form-control text-center" value="${item.quantity}" min="1" onchange="updateQuantity(${index}, this.value)">
                                            <button class="btn btn-outline-secondary" type="button" onclick="updateQuantity(${index}, ${item.quantity + 1})">+</button>
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-end">
                                        <p class="fw-bold">Rp ${itemTotal.toLocaleString()}</p>
                                        <button class="btn btn-danger btn-sm" onclick="removeItem(${index})">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });

        cartContainer.innerHTML = html;
        updateSummary(calculateSubtotal(cartItems));
    }

    function calculateSubtotal(items) {
        return items.reduce((total, item) => total + (item.price * item.quantity), 0);
    }

    function updateSummary(subtotal) {
        document.getElementById('subtotal').textContent = `Rp ${subtotal.toLocaleString()}`;
        document.getElementById('total').textContent = `Rp ${subtotal.toLocaleString()}`;
    }

    window.updateQuantity = function(index, newQuantity) {
        newQuantity = parseInt(newQuantity);
        if (newQuantity < 1) return;
        
        const cartItems = getCartItems();
        cartItems[index].quantity = newQuantity;
        saveCartItems(cartItems);
        loadCartItems();
    }

    window.removeItem = function(index) {
        if (confirm('Apakah Anda yakin ingin menghapus item ini?')) {
            const cartItems = getCartItems();
            cartItems.splice(index, 1);
            saveCartItems(cartItems);
            loadCartItems();
        }
    }

    document.getElementById('checkout-btn').addEventListener('click', function() {
        const cartItems = getCartItems();
        if (cartItems.length === 0) {
            alert('Keranjang masih kosong!');
            return;
        }
        
        // Redirect ke halaman checkout
        window.location.href = '{{ route('orders.checkout') }}';
    });
});
</script>
@endpush
