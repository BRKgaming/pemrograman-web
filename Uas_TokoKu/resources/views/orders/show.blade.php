@extends('layouts.app')

@section('title', 'Detail Pesanan #' . $order->order_number . ' - TokoKU')

@section('content')
<div class="container py-5">
    <div class="mb-4">
        <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Pesanan
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-shopping-bag text-primary me-2"></i>
                            Detail Pesanan #{{ $order->order_number }}
                        </h5>
                        <span class="badge bg-{{ $order->getStatusInfo()['color'] }}">
                            <i class="fas {{ $order->getStatusInfo()['icon'] }} me-1"></i>
                            {{ $order->getStatusInfo()['name'] }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6>Informasi Pesanan</h6>
                            <p class="mb-1 text-muted">
                                <strong>Tanggal Pesanan:</strong> {{ $order->created_at->format('d M Y, H:i') }}
                            </p>
                            <p class="mb-1 text-muted">
                                <strong>Status:</strong> {{ $order->getStatusInfo()['name'] }}
                            </p>
                            <p class="mb-1 text-muted">
                                <strong>Pengiriman:</strong> 
                                <i class="fas {{ $order->getShippingMethodInfo()['icon'] }} me-1"></i>
                                {{ $order->getShippingMethodInfo()['name'] }} ({{ $order->getShippingMethodInfo()['description'] }})
                            </p>
                            <p class="mb-0 text-muted">
                                <strong>Total:</strong> Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                            </p>
                        </div>
                        
                        <div class="col-md-6">
                            <h6>Informasi Pembayaran</h6>
                            <p class="mb-1 text-muted">
                                <i class="fas {{ $order->getPaymentMethodInfo()['icon'] }} me-2"></i>
                                {{ $order->getPaymentMethodInfo()['name'] }}
                            </p>
                            <div class="alert alert-light mt-2">
                                {{ $order->getPaymentMethodInfo()['instructions'] }}
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <h6>Alamat Pengiriman</h6>
                    @php
                        $addressParts = explode(' | ', $order->shipping_address);
                        $addressName = $addressParts[0] ?? '';
                        $addressPhone = $addressParts[1] ?? '';
                        $addressFull = $addressParts[2] ?? '';
                        $addressCity = $addressParts[3] ?? '';
                        $addressPostal = $addressParts[4] ?? '';
                    @endphp
                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <p class="mb-1"><strong>{{ $addressName }}</strong></p>
                            <p class="mb-1">{{ $addressPhone }}</p>
                            <p class="mb-1">{{ $addressFull }}</p>
                            <p class="mb-0">{{ $addressCity }}, {{ $addressPostal }}</p>
                        </div>
                    </div>

                    <h6>Item Pesanan</h6>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="min-width: 300px;">Produk</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->orderItems as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($item->product)
                                                <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->name }}" class="img-fluid me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                                <div>
                                                    <h6 class="mb-0">{{ $item->product->name }}</h6>
                                                </div>
                                            @else
                                                <div>
                                                    <h6 class="mb-0">Produk tidak tersedia</h6>
                                                    <span class="text-muted">Produk mungkin telah dihapus</span>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td class="text-end">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Subtotal</strong></td>
                                    <td class="text-end">Rp {{ number_format($order->total_amount - $order->shipping_cost, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end">
                                        <strong>Biaya Pengiriman</strong>
                                        @if($order->shipping_method)
                                            <small class="text-muted d-block">
                                                {{ $order->getShippingMethodInfo()['name'] }}
                                            </small>
                                        @endif
                                    </td>
                                    <td class="text-end">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Total</strong></td>
                                    <td class="text-end"><strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    @if($order->notes)
                    <div class="mt-4">
                        <h6>Catatan:</h6>
                        <p class="mb-0 text-muted">{{ $order->notes }}</p>
                    </div>
                    @endif
                </div>
                <div class="card-footer bg-white d-flex justify-content-between">
                    <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-list me-1"></i> Lihat Semua Pesanan
                    </a>
                    
                    @if($order->status == 'pending')
                    <form action="{{ route('orders.cancel', $order) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?');">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-times me-1"></i> Batalkan Pesanan
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm sticky-lg-top" style="top: 100px;">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Ringkasan Pesanan</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($order->total_amount - $order->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>
                                Pengiriman
                                @if($order->shipping_method)
                                    <small class="d-block text-muted">
                                        {{ $order->getShippingMethodInfo()['name'] }}
                                    </small>
                                @endif
                            </span>
                            <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-0 fw-bold">
                            <span>Total</span>
                            <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="bg-light p-3 rounded mb-3">
                        <h6><i class="fas {{ $order->getStatusInfo()['icon'] }} me-2 text-{{ $order->getStatusInfo()['color'] }}"></i> {{ $order->getStatusInfo()['name'] }}</h6>
                        @if($order->status == 'pending')
                        <p class="mb-0 small text-muted">Silakan lakukan pembayaran untuk memproses pesanan Anda.</p>
                        @elseif($order->status == 'processing')
                        <p class="mb-0 small text-muted">Pesanan Anda sedang diproses dan akan segera dikirim.</p>
                        @elseif($order->status == 'shipped')
                        <p class="mb-0 small text-muted">Pesanan Anda sedang dalam perjalanan.</p>
                        @elseif($order->status == 'delivered')
                        <p class="mb-0 small text-muted">Pesanan Anda telah diterima. Terima kasih telah berbelanja!</p>
                        @elseif($order->status == 'cancelled')
                        <p class="mb-0 small text-muted">Pesanan ini telah dibatalkan.</p>
                        @endif
                    </div>
                    
                    <div class="d-grid">
                        <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-shopping-cart me-2"></i>Lanjutkan Belanja
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
