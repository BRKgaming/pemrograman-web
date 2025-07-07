<?php

use Illuminate\Support\Facades\Route;
use Modules\JobVacancy\Http\Controllers\JobVacancyController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('jobvacancies', JobVacancyController::class)->names('jobvacancy');
});
