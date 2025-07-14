@extends('layouts.app')

@section('title', 'Pesanan Saya - TokoKU')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h2">
                <i class="fas fa-shopping-bag text-primary"></i> Pesanan Saya
            </h1>
            <p class="text-muted">Daftar semua pesanan yang telah Anda buat.</p>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
        <div class="d-flex">
            <div class="me-3">
                <i class="fas fa-check-circle fa-2x text-success"></i>
            </div>
            <div>
                <h5 class="alert-heading">Berhasil!</h5>
                <p class="mb-0">{{ session('success') }}</p>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        <div class="col-12">
            @if($orders->count() > 0)
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>No. Pesanan</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th class="text-center">Jumlah Item</th>
                                        <th>Pembayaran</th>
                                        <th class="text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                    <tr>
                                        <td>
                                            <a href="{{ route('orders.show', $order) }}" class="text-decoration-none text-dark">
                                                {{ $order->order_number }}
                                            </a>
                                        </td>
                                        <td>{{ $order->created_at->format('d M Y') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $order->getStatusInfo()['color'] }}">
                                                <i class="fas {{ $order->getStatusInfo()['icon'] }} me-1"></i>
                                                {{ $order->getStatusInfo()['name'] }}
                                            </span>
                                        </td>
                                        <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                        <td class="text-center">{{ $order->orderItems->sum('quantity') }} item</td>
                                        <td>
                                            <span class="badge bg-light text-dark">
                                                <i class="fas {{ $order->getPaymentMethodInfo()['icon'] }} me-1"></i>
                                                {{ $order->getPaymentMethodInfo()['name'] }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                            @if($order->status == 'pending')
                                            <form action="{{ route('orders.cancel', $order) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-shopping-bag text-muted fa-4x"></i>
                    </div>
                    <h3>Belum ada pesanan</h3>
                    <p class="text-muted">Anda belum memiliki pesanan.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-shopping-cart me-2"></i>Belanja Sekarang
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
