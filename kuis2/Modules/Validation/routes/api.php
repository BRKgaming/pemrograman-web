<?php

use Illuminate\Support\Facades\Route;
use Modules\Validation\Http\Controllers\ValidationController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('validations', ValidationController::class)->names('validation');
});
