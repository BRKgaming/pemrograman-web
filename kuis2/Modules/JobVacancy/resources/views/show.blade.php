@extends('layouts.app')

@section('header')
    <div class="text-center">
        <h1 class="display-4">{{ $job->company }}</h1>
        <span class="text-muted">{{ $job->address }}</span>
    </div>
@endsection

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <h3>Description</h3>
                <p>{{ $job->description ?? 'No description provided' }}</p>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <h3>Select position</h3>
                <form action="{{ route('applications.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="job_vacancy_id" value="{{ $job->id }}">

                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th width="1">#</th>
                                <th>Position</th>
                                <th>Capacity</th>
                                <th>Application / Max</th>
                                <th rowspan="{{ count($job->availablePositions) + 1 }}" style="vertical-align: middle; white-space: nowrap;" width="1">
                                    <button type="submit" class="btn btn-primary btn-lg">Apply for this job</button>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($job->availablePositions as $position)
                            <tr class="{{ $position->apply_capacity >= $position->capacity ? 'table-warning' : '' }}">
                                <td>
                                    <input type="checkbox" name="positions[]" value="{{ $position->id }}"
                                        {{ $position->apply_capacity >= $position->capacity ? 'disabled' : '' }}>
                                </td>
                                <td>{{ $position->position }}</td>
                                <td>{{ $position->capacity }}</td>
                                <td>{{ $position->apply_capacity }}/{{ $position->capacity }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="form-group mt-4">
                        <div class="d-flex align-items-center mb-3">
                            <label class="mr-3 mb-0">Notes for Company</label>
                        </div>
                        <textarea name="notes" class="form-control" cols="30" rows="6"
                            placeholder="Explain why you should be accepted" required></textarea>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection