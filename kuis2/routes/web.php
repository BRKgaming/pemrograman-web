<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocietyAuthController;
use App\Http\Controllers\Auth\ValidatorAuthController;
use App\Http\Controllers\DashboardController;
use Modules\JobVacancy\Http\Controllers\JobVacancyController;
use Modules\Validation\Http\Controllers\ValidationController;

// Society (User) Authentication Routes
Route::get('/', [SocietyAuthController::class, 'showLoginForm'])->name('society.login.form');
Route::post('/login', [SocietyAuthController::class, 'login'])->name('society.login');
Route::post('/logout', [SocietyAuthController::class, 'logout'])->name('society.logout');

// Validator (Admin) Authentication Routes
Route::get('/validator/login', [ValidatorAuthController::class, 'showLoginForm'])->name('validator.login.form');
Route::post('/validator/login', [ValidatorAuthController::class, 'login'])->name('validator.login');
Route::post('/validator/logout', [ValidatorAuthController::class, 'logout'])->name('validator.logout');

// Protected Routes - Society (User)
Route::middleware(['auth:society'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'societyDashboard'])->name('society.dashboard');

    Route::prefix('validation')->group(function () {
        Route::get('/', [ValidationController::class, 'index'])->name('validation.index');
        Route::get('/request', [ValidationController::class, 'create'])->name('validation.create');
        Route::post('/', [ValidationController::class, 'store'])->name('validation.store');
    });

    Route::prefix('job-vacancies')->group(function () {
        Route::get('/', [JobVacancyController::class, 'index'])->name('job-vacancies.index');
        Route::get('/{id}', [JobVacancyController::class, 'show'])->name('job-vacancies.show');
    });

    // Include Application module routes
    Route::prefix('applications')->group(function () {
        Route::get('/', [\Modules\Application\Http\Controllers\ApplicationController::class, 'index'])->name('applications.index');
        Route::post('/', [\Modules\Application\Http\Controllers\ApplicationController::class, 'store'])->name('applications.store');
        Route::get('/{id}', [\Modules\Application\Http\Controllers\ApplicationController::class, 'show'])->name('applications.show');
    });
});

// Protected Routes - Validator (Admin)
Route::middleware(['auth:validator'])->group(function () {
    Route::get('/validator/dashboard', [DashboardController::class, 'validatorDashboard'])->name('validator.dashboard');

    // Add validator-specific routes here
});