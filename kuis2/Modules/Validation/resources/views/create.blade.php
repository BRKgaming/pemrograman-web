@extends('layouts.app')

@section('header')
    <h1 class="display-4">Request Data Validation</h1>
@endsection

@section('content')
<div class="container">
    <section class="validation-section mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">
                        <h4 class="mb-0">Validation Request Form</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('validation.store') }}" method="POST">
                            @csrf

                            <!-- Job Category -->
                            <div class="form-group row">
                                <label for="job_category_id" class="col-md-4 col-form-label text-right">Job Category</label>
                                <div class="col-md-8">
                                    <select name="job_category_id" id="job_category_id" class="form-control" required>
                                        <option value="">Select Job Category</option>
                                        @foreach($jobCategories as $category)
                                            <option value="{{ $category->id }}" {{ old('job_category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->job_category }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('job_category_id')
                                        <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Work Experience -->
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-right">Work Experience</label>
                                <div class="col-md-8">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="work_experience" id="experience_yes" value="1" {{ old('work_experience') == '1' ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="experience_yes">Yes, I have</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="work_experience" id="experience_no" value="0" {{ old('work_experience') == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="experience_no">No experience</label>
                                    </div>
                                    @error('work_experience')
                                        <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Job Position -->
                            <div class="form-group row">
                                <label for="job_position" class="col-md-4 col-form-label text-right">Job Position</label>
                                <div class="col-md-8">
                                    <textarea name="job_position" id="job_position" rows="2" class="form-control" placeholder="e.g. Web Developer, UI Designer" required>{{ old('job_position') }}</textarea>
                                    <small class="text-muted">Separate with comma</small>
                                    @error('job_position')
                                        <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Reason Accepted -->
                            <div class="form-group row">
                                <label for="reason_accepted" class="col-md-4 col-form-label text-right">Reason Accepted</label>
                                <div class="col-md-8">
                                    <textarea name="reason_accepted" id="reason_accepted" rows="4" class="form-control" placeholder="Explain why you should be accepted" required>{{ old('reason_accepted') }}</textarea>
                                    @error('reason_accepted')
                                        <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="form-group row">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Send Request
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection