@extends('layouts.app')

@section('title', 'Detail Pengguna - TokoKU')

@section('content')
<div class="container py-5">
    <div class="mb-4">
        <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary mb-3">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Pengguna
        </a>
        <h2 class="fw-bold">Detail Pengguna</h2>
        <p class="text-muted">Melihat informasi lengkap dan aktivitas pengguna</p>
    </div>
    
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row g-4">
        <!-- User Profile Info -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body text-center py-4">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="rounded-circle mb-3" width="120" height="120">
                    @else
                        <div class="rounded-circle bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 120px; height: 120px;">
                            <i class="fas fa-user fa-4x text-secondary"></i>
                        </div>
                    @endif
                    <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
                    <p class="text-muted mb-3">{{ $user->email }}</p>
                    
                    <div class="d-flex justify-content-center gap-2 mb-3">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-1"></i> Edit Profil
                        </a>
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteUserModal">
                            <i class="fas fa-trash me-1"></i> Hapus
                        </button>
                    </div>
                </div>
                <div class="card-footer bg-light">
                    <div class="row text-center">
                        <div class="col">
                            <h5 class="fw-bold mb-0">{{ $user->orders_count }}</h5>
                            <small class="text-muted">Pesanan</small>
                        </div>
                        <div class="col">
                            <h5 class="fw-bold mb-0">{{ $user->created_at->diffForHumans() }}</h5>
                            <small class="text-muted">Bergabung</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Details -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0">Informasi Kontak</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0 py-3 d-flex justify-content-between">
                            <span class="text-muted">No. Telepon</span>
                            <span class="fw-medium">{{ $user->phone ?? 'Belum diatur' }}</span>
                        </li>
                        <li class="list-group-item px-0 py-3 d-flex justify-content-between">
                            <span class="text-muted">Alamat</span>
                            <span class="fw-medium">{{ $user->address ?? 'Belum diatur' }}</span>
                        </li>
                        <li class="list-group-item px-0 py-3 d-flex justify-content-between">
                            <span class="text-muted">Kota</span>
                            <span class="fw-medium">{{ $user->city ?? 'Belum diatur' }}</span>
                        </li>
                        <li class="list-group-item px-0 py-3 d-flex justify-content-between">
                            <span class="text-muted">Kode Pos</span>
                            <span class="fw-medium">{{ $user->postal_code ?? 'Belum diatur' }}</span>
                        </li>
                        <li class="list-group-item px-0 py-3 d-flex justify-content-between">
                            <span class="text-muted">Bergabung Pada</span>
                            <span class="fw-medium">{{ $user->created_at->format('d M Y, H:i') }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <!-- User Orders -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Pesanan Terakhir</h5>
                    <a href="{{ route('admin.orders') }}?search={{ $user->email }}" class="btn btn-sm btn-outline-primary">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    @if($userOrders->count() > 0)
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Tanggal</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($userOrders as $order)
                                <tr>
                                    <td>#{{ $order->id }}</td>
                                    <td>{{ $order->created_at->format('d M Y') }}</td>
                                    <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                    <td>
                                        @php
                                            $badgeClass = match($order->status) {
                                                'pending' => 'bg-warning',
                                                'processing' => 'bg-info',
                                                'shipped' => 'bg-primary',
                                                'delivered' => 'bg-success',
                                                'cancelled' => 'bg-danger',
                                                default => 'bg-secondary'
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ ucfirst($order->status) }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-info">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-4">
                        <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
                        <h5>Belum Ada Pesanan</h5>
                        <p class="text-muted">Pengguna ini belum pernah melakukan pembelian.</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- User Activity -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0">Aktivitas Terakhir</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0 py-3">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-3">
                                    <i class="fas fa-user text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Pengguna mendaftar</h6>
                                    <small class="text-muted">{{ $user->created_at->format('d M Y, H:i') }}</small>
                                </div>
                            </div>
                        </li>
                        @foreach($userOrders as $order)
                        <li class="list-group-item px-0 py-3">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-success bg-opacity-10 p-2 me-3">
                                    <i class="fas fa-shopping-cart text-success"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Membuat pesanan #{{ $order->id }}</h6>
                                    <small class="text-muted">{{ $order->created_at->format('d M Y, H:i') }}</small>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete User Modal -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus pengguna <strong>{{ $user->name }}</strong>?</p>
                <p class="text-danger"><small>Tindakan ini tidak dapat dibatalkan dan akan menghapus semua data terkait pengguna ini.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
