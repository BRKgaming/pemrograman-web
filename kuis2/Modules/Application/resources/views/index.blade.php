@extends('layouts.app')

@section('header')
@endsection

@section('content')
<div class="container">
    <!-- My Data Validation Section -->
    <section class="validation-section mb-5">
        <div class="section-header mb-3">
            <h4 class="section-title text-muted">My Data Validation</h4>
        </div>

        <div class="row">
            @if(auth('society')->user()->validation)
                <div class="col-md-6">
                    <div class="card card-default">
                        <div class="card-header border-0">
                            <h5 class="mb-0">Data Validation</h5>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped mb-0">
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge
                                            {{ auth('society')->user()->validation->status == 'accepted' ? 'badge-success' :
                                            (auth('society')->user()->validation->status == 'rejected' ? 'badge-danger' : 'badge-info') }}">
                                            {{ ucfirst(auth('society')->user()->validation->status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Job Category</th>
                                    <td>{{ auth('society')->user()->validation->jobCategory->job_category ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Job Position</th>
                                    <td>{{ auth('society')->user()->validation->job_position ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Reason Accepted</th>
                                    <td>{{ auth('society')->user()->validation->reason_accepted ?? '-' }}</td>
                                </tr>
                                @if(auth('society')->user()->validation->validator)
                                <tr>
                                    <th>Validator</th>
                                    <td>{{ auth('society')->user()->validation->validator->name }}</td>
                                </tr>
                                @endif
                                @if(auth('society')->user()->validation->validator_notes)
                                <tr>
                                    <th>Validator Notes</th>
                                    <td>{{ auth('society')->user()->validation->validator_notes }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-md-4">
                    <div class="card card-default">
                        <div class="card-header">
                            <h5 class="mb-0">Data Validation</h5>
                        </div>
                        <div class="card-body text-center">
                            <p class="text-muted mb-3">You haven't submitted validation data yet.</p>
                            <a href="{{ route('validation.create') }}" class="btn btn-primary btn-block">
                                + Request validation
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- My Job Applications Section -->
    <section class="validation-section mb-5">
        <div class="section-header mb-3">
            <h4 class="section-title text-muted">My Job Applications</h4>
        </div>

        <div class="row">
            @if(auth('society')->user()->validation && auth('society')->user()->validation->status != 'accepted')
            <div class="col-md-12">
                <div class="alert alert-warning">
                    Your validation must be approved by validator to applying job.
                </div>
            </div>
            @endif

            @forelse($applications as $application)
            <div class="col-md-6 mb-4">
                <div class="card card-default">
                    <div class="card-header border-0">
                        <h5 class="mb-0">{{ $application->jobVacancy->company }}</h5>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped mb-0">
                            <tr>
                                <th>Address</th>
                                <td>{{ $application->jobVacancy->address }}</td>
                            </tr>
                            <tr>
                                <th>Position</th>
                                <td>
                                    <ul class="pl-3 mb-0">
                                        @foreach($application->positions as $position)
                                        <li>
                                            {{ $position->position->position }}
                                            <span class="badge
                                                {{ $position->status == 'accepted' ? 'badge-success' :
                                                ($position->status == 'rejected' ? 'badge-danger' : 'badge-info') }}">
                                                {{ ucfirst($position->status) }}
                                            </span>
                                        </li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <th>Apply Date</th>
                                <td>{{ $application->created_at }}</td>
                            </tr>
                            @if($application->notes)
                            <tr>
                                <th>Notes</th>
                                <td>{{ $application->notes }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-md-12">
                <div class="alert alert-info">
                    You haven't applied to any jobs yet.
                </div>
            </div>
            @endforelse
        </div>
    </section>
</div>
@endsection