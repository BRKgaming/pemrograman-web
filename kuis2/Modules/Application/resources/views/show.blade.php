@extends('layouts.app')

@section('header')
    <div class="text-center">
        <h1 class="display-4">Detail Lamaran</h1>
        <span class="text-muted">{{ $application->jobVacancy->company }}</span>
    </div>
@endsection

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Informasi Lamaran</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Perusahaan:</strong> {{ $application->jobVacancy->company }}</p>
                            <p><strong>Alamat:</strong> {{ $application->jobVacancy->address }}</p>
                            <p><strong>Tanggal Melamar:</strong> {{ \Carbon\Carbon::parse($application->date)->format('d F Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Status:</strong> 
                                <span class="badge badge-warning">Pending</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Posisi yang Dilamar</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Posisi</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($application->positions as $key => $position)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $position->position->position }}</td>
                                <td>
                                    @if($position->status == 'pending')
                                        <span class="badge badge-warning">Pending</span>
                                    @elseif($position->status == 'accepted')
                                        <span class="badge badge-success">Diterima</span>
                                    @else
                                        <span class="badge badge-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($position->date)->format('d F Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Catatan untuk Perusahaan</h3>
                </div>
                <div class="card-body">
                    <p>{{ $application->notes }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <a href="{{ route('applications.index') }}" class="btn btn-secondary">Kembali ke Daftar Lamaran</a>
        </div>
    </div>
</div>
@endsection
