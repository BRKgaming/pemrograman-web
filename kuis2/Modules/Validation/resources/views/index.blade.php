@extends('layouts.app')

@section('header')
    <h1 class="display-4">Validasi Data Saya</h1>
@endsection

@section('content')
<div class="container">
    <section class="validation-section mb-5">
        <div class="row">
            @if($validation)
                <div class="col-md-6">
                    <div class="card card-default">
                        <div class="card-header border-0">
                            <h5 class="mb-0">Data Validasi</h5>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped mb-0">
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge
                                            {{ $validation->status == 'accepted' ? 'badge-success' :
                                            ($validation->status == 'rejected' ? 'badge-danger' : 'badge-warning') }}">
                                            {{ ucfirst($validation->status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Kategori Pekerjaan</th>
                                    <td>{{ $validation->jobCategory->job_category }}</td>
                                </tr>
                                <tr>
                                    <th>Posisi</th>
                                    <td>{{ $validation->job_position }}</td>
                                </tr>
                                <tr>
                                    <th>Alasan Diterima</th>
                                    <td>{{ $validation->reason_accepted }}</td>
                                </tr>
                                @if($validation->status == 'rejected')
                                <tr>
                                    <th>Catatan Validator</th>
                                    <td>{{ $validation->validator_notes }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-md-4">
                    <div class="card card-default">
                        <div class="card-body text-center">
                            <p class="text-muted mb-3">Anda belum mengajukan validasi data</p>
                            <a href="{{ route('validation.create') }}" class="btn btn-primary btn-block">
                                + Ajukan Validasi
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
</div>
@endsection
