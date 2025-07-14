<?php

use Illuminate\Support\Facades\Route;
use Modules\Validation\Http\Controllers\ValidationController;

Route::prefix('validation')->group(function () {
    Route::get('/', [ValidationController::class, 'index'])->name('validation.index');
    Route::get('/request', [ValidationController::class, 'create'])->name('validation.create');
    Route::post('/', [ValidationController::class, 'store'])->name('validation.store');
    Route::get('/{id}', [ValidationController::class, 'show'])->name('validation.show');
});