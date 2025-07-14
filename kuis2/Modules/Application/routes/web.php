<?php

use Illuminate\Support\Facades\Route;
use Modules\Application\Http\Controllers\ApplicationController;

Route::prefix('applications')->group(function () {
    Route::get('/', [ApplicationController::class, 'index'])->name('applications.index');
    Route::post('/', [ApplicationController::class, 'store'])->name('applications.store');
    Route::get('/{id}', [ApplicationController::class, 'show'])->name('applications.show');
});
