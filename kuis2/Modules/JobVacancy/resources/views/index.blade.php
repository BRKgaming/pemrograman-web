@extends('layouts.app')

@section('header')
    <h1 class="display-4">Job Vacancies</h1>
@endsection

@section('content')
<div class="container mb-5">
    <div class="section-header mb-4">
        <h4 class="section-title text-muted font-weight-normal">List of Job Vacancies</h4>
    </div>

    <div class="section-body">
        @foreach($jobVacancies as $job)
        <article class="spot mb-4 p-3 bg-white rounded shadow-sm">
            <div class="row align-items-center">
                <div class="col-md-5">
                    <h5 class="text-primary">{{ $job->company }}</h5>
                    <span class="text-muted">{{ $job->address }}</span>
                </div>
                <div class="col-md-4">
                    <h5>Available Position (Capacity)</h5>
                    <span class="text-muted">
                        @foreach($job->availablePositions as $position)
                            {{ $position->position }} ({{ $position->capacity }})
                            @if(!$loop->last), @endif
                        @endforeach
                    </span>
                </div>
                <div class="col-md-3">
                    @if($job->hasApplied)
                        <div class="bg-success text-white p-2 text-center rounded">
                            Vacancies have been submitted
                        </div>
                    @else
                        <a href="{{ route('job-vacancies.show', $job->id) }}" class="btn btn-danger btn-lg btn-block">
                            Detail / Apply
                        </a>
                    @endif
                </div>
            </div>
        </article>
        @endforeach
    </div>
</div>
@endsection