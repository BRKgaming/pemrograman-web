@extends('layouts.app')

@section('content')
<main>
    <!-- S: Header -->
        <div class="container">
            <h6 class="display-4">Dashboard</h6>
        </div>
    <!-- E: Header -->

    <div class="container">

        <!-- S: Data Validation Section -->
        <section class="validation-section mb-5">
            <div class="section-header mb-3">
                <h4 class="section-title text-muted">My Data Validation</h4>
            </div>
            <div class="row">

                @if(!optional(auth('society')->user())->validation)
                <!-- S: Link to Request Data Validation -->
                <div class="col-md-4">
                    <div class="card card-default">
                        <div class="card-header">
                            <h5 class="mb-0">Data Validation</h5>
                        </div>
                        <div class="card-body">
                            <a href="{{ route('validation.create') }}" class="btn btn-primary btn-block">+ Request validation</a>
                        </div>
                    </div>
                </div>
                <!-- E: Link to Request Data Validation -->
                @endif

                @if(optional(auth('society')->user())->validation)
                <!-- S: Society Data Validation Box -->
                <div class="col-md-4">
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
                                    <td class="text-muted">{{ optional(auth('society')->user()->validation->jobCategory)->job_category ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Job Position</th>
                                    <td class="text-muted">{{ auth('society')->user()->validation->job_position ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Reason Accepted</th>
                                    <td class="text-muted">{{ auth('society')->user()->validation->reason_accepted ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Validator</th>
                                    <td class="text-muted">{{ optional(auth('society')->user()->validation->validator)->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Validator Notes</th>
                                    <td class="text-muted">{{ auth('society')->user()->validation->validator_notes ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- E: Society Data Validation Box -->
                @endif

            </div>
        </section>
        <!-- E: Data Validation Section -->

        <!-- S: List Job Seekers Section -->
        <section class="validation-section mb-5">
            <div class="section-header mb-3">
                <div class="row">
                    <div class="col-md-8">
                        <h4 class="section-title text-muted">My Job Applications</h4>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('job-vacancies.index') }}" class="btn btn-primary btn-lg btn-block">+ Add Job Applications</a>
                    </div>
                </div>
            </div>
            <div class="section-body">
                <div class="row mb-4">

                    @if(optional(auth('society')->user())->validation && auth('society')->user()->validation->status != 'accepted')
                    <!-- S: Job Applications info -->
                    <div class="col-md-12">
                        <div class="alert alert-warning">
                            Your validation must be approved by validator to applying job.
                        </div>
                    </div>
                    <!-- E: Job Applications info -->
                    @endif

                    @isset($user)
                        @forelse($user->applications ?? [] as $application)
                            @if($application)
                            <!-- S: Job Applications Box -->
                            <div class="col-md-6 mb-4">
                                <div class="card card-default">
                                    <div class="card-header border-0">
                                        <h5 class="mb-0">{{ optional($application->jobVacancy)->company ?? 'N/A' }}</h5>
                                    </div>
                                    <div class="card-body p-0">
                                        <table class="table table-striped mb-0">
                                            <tr>
                                                <th>Address</th>
                                                <td class="text-muted">{{ optional($application->jobVacancy)->address ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Position</th>
                                                <td class="text-muted">
                                                    <ul class="pl-3 mb-0">
                                                        @foreach($application->positions as $position)
                                                        <li>
                                                            {{ $position->position->position ?? 'N/A' }}
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
                                                <td class="text-muted">{{ optional($application->created_at)->format('F d, Y') ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Notes</th>
                                                <td class="text-muted">{{ $application->notes ?? '-' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- E: Job Applications Box -->
                            @endif
                        @empty
                            <div class="col-md-12">
                                <div class="alert alert-info">
                                    You haven't applied to any jobs yet.
                                </div>
                            </div>
                        @endforelse
                    @else
                        <div class="col-md-12">
                            <div class="alert alert-danger">
                                User data not available. Please try logging in again.
                            </div>
                        </div>
                    @endisset

                </div>
            </div>
        </section>
        <!-- E: List Job Seekers Section -->

    </div>
</main>

@if(session('error'))
<div class="alert alert-danger fixed-bottom m-3" style="max-width: 400px; right: 20px;">
    {{ session('error') }}
</div>
@endif
@endsection