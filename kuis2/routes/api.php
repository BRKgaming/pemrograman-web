<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\JobSeekerController;

Route::prefix('v1')->group(function () {
    // A1 - Authentication
    Route::post('/auth/login', [JobSeekerController::class, 'login']);
    Route::post('/auth/logout', [JobSeekerController::class, 'logout']);

    // A2 - Validations
    Route::post('/validation', [JobSeekerController::class, 'requestValidation']);
    Route::get('/validations', [JobSeekerController::class, 'getValidation']);

    // A3 - Job Vacancies
    Route::get('/job_vacancies', [JobSeekerController::class, 'getJobVacancies']);
    Route::get('/job_vacancies/{id}', [JobSeekerController::class, 'getJobVacancyDetail']);

    // A4 - Applications
    Route::post('/applications', [JobSeekerController::class, 'applyForJob']);
    Route::get('/applications', [JobSeekerController::class, 'getJobApplications']);
});
