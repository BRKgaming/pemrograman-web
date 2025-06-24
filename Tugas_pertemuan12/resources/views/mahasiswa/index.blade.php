@extends('layouts.app') {{-- Menggunakan layout utama 'app.blade.php' --}}

@section('title', 'CRUD Mahasiswa') {{-- Menetapkan judul halaman --}}

@section('content') {{-- Bagian konten utama --}}
<div class="card">
    <div class="card-header">
        <h4>Data Mahasiswa</h4>
    </div>
    <div class="card-body">
        <button class="btn btn-primary mb-3" id="btn-tambah">
            <i class="fas fa-plus"></i> Tambah Data
        </button>
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="table-mahasiswa">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIM</th>
                        <th>Prodi</th>
                        <th>Tanggal Lahir</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Data akan diisi via AJAX --}}
                </tbody>
            </table>
            <div class="mt-3">
                <div class="alert alert-info py-2 mb-0" role="alert" style="font-size: 0.97em;">
                    <strong>Catatan:</strong> Halaman ini menggunakan AJAX, sehingga proses tambah, edit, dan hapus data mahasiswa dilakukan <b>tanpa refresh halaman</b>.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk form tambah/edit data -->
<div class="modal fade" id="modal-mahasiswa" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Tambah Data Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-mahasiswa">
                @csrf {{-- Token keamanan Laravel --}}
                <div class="modal-body">
                    <input type="hidden" id="id" name="id">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="nim" class="form-label">NIM</label>
                        <input type="text" class="form-control" id="nim" name="nim" required>
                    </div>
                    <div class="mb-3">
                        <label for="prodi" class="form-label">Program Studi</label>
                        <input type="text" class="form-control" id="prodi" name="prodi" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        loadData();

        $('#btn-tambah').click(function() {
            $('#modal-mahasiswa').modal('show');
            $('#modal-title').text('Tambah Data Mahasiswa');
            $('#form-mahasiswa')[0].reset();
            $('#id').val('');
        });

        $('#form-mahasiswa').submit(function(e) {
            e.preventDefault();
            let id = $('#id').val();
            let url = id ? '/mahasiswa/' + id : '/mahasiswa';
            let method = id ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                method: method,
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#modal-mahasiswa').modal('hide');
                    loadData();
                    alert(response.message);
                },
                error: function(xhr) {
                    if (xhr.status === 419) {
                        alert('CSRF token mismatch. Please refresh the page.');
                    }
                    let errors = xhr.responseJSON.errors;
                    if (errors) {
                        $.each(errors, function(key, value) {
                            alert(value[0]);
                        });
                    }
                }
            });
        });
    });

    function loadData() {
        $.ajax({
            url: '/mahasiswa/get-data',
            method: 'GET',
            success: function(response) {
                let html = '';
                $.each(response.data, function(index, item) {
                    html += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.nama}</td>
                            <td>${item.nim}</td>
                            <td>${item.prodi}</td>
                            <td>${item.tanggal_lahir}</td>
                            <td>${item.alamat}</td>
                            <td>
                                <button class="btn btn-sm btn-warning btn-edit" data-id="${item.id}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger btn-delete" data-id="${item.id}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                });
                $('#table-mahasiswa tbody').html(html);
            }
        });
    }

    $(document).on('click', '.btn-edit', function() {
        let id = $(this).data('id');
        $.ajax({
            url: '/mahasiswa/' + id + '/edit',
            method: 'GET',
            success: function(response) {
                $('#modal-title').text('Edit Data Mahasiswa');
                $('#id').val(response.id);
                $('#nama').val(response.nama);
                $('#nim').val(response.nim);
                $('#prodi').val(response.prodi);
                $('#tanggal_lahir').val(response.tanggal_lahir);
                $('#alamat').val(response.alamat);
                $('#modal-mahasiswa').modal('show');
            }
        });
    });

    $(document).on('click', '.btn-delete', function() {
        if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            let id = $(this).data('id');
            $.ajax({
                url: '/mahasiswa/' + id,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    loadData();
                    alert(response.message);
                }
            });
        }
    });
</script>
@endpush
