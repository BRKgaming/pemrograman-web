@extends('layouts.app')

@section('title', 'Kelola Pengguna - TokoKU')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">Kelola Pengguna</h2>
            <p class="text-muted">Lihat dan kelola data pengguna pada sistem</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-1"></i> Tambah Pengguna
        </a>
    </div>
    
    <!-- Filter & Search -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form action="{{ route('admin.users') }}" method="GET" class="row g-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control" name="search" placeholder="Cari pengguna..." value="{{ request()->search }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Cari</button>
                    <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>
    
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    
    <!-- Users Table -->
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Total Pesanan</th>
                            <th>Terdaftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($user->avatar)
                                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="rounded-circle me-2" width="40">
                                    @else
                                        <div class="rounded-circle bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                                            <i class="fas fa-user text-secondary"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <h6 class="mb-0">{{ $user->name }}</h6>
                                        <small class="text-muted">{{ $user->phone ?? 'No Phone' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge bg-primary rounded-pill">{{ $user->orders_count }}</span>
                            </td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                
                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
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
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                    <h5>Tidak ada pengguna yang ditemukan</h5>
                                    <p class="text-muted">Tidak ada pengguna yang cocok dengan kriteria pencarian Anda.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
