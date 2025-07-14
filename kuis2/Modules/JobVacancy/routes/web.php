<?php

use Illuminate\Support\Facades\Route;
use Modules\JobVacancy\Http\Controllers\JobVacancyController;

Route::prefix('job-vacancies')->group(function () {
    Route::get('/', [JobVacancyController::class, 'index'])->name('job-vacancies.index');
    Route::get('/{id}', [JobVacancyController::class, 'show'])->name('job-vacancies.show');
});
