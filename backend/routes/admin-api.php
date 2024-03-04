<?php

use App\Http\Controllers\Apis\V1\Admins\Auth\AdminAuthController;
use App\Http\Controllers\Apis\V1\Admins\Csv\CsvController;
use App\Http\Controllers\Apis\V1\Admins\File\FileController;
use App\Http\Controllers\Apis\V1\Admins\Player\AdminPlayerController;
use App\Http\Controllers\Apis\V1\Admins\Translate\TranslateController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/')->group(function () {
    Route::prefix('/admins')->group(function () {
        Route::post('/register', [AdminAuthController::class, 'register']);
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login');
        Route::post('/logout', [AdminAuthController::class, 'logout']);
        Route::middleware(['auth:sanctum', 'can:admin'])->group(function () {
            Route::get('/me', [AdminAuthController::class, 'me']);
            Route::apiResource('/csv', CsvController::class)->only(['index', 'store']);
            Route::apiResource('/file', FileController::class)->only(['index', 'store']);
            Route::post('/players/imports', [AdminPlayerController::class, 'import']);
            Route::get('/players/exports', [AdminPlayerController::class, 'export']);
            Route::apiResource('/players', AdminPlayerController::class);
            Route::get('/translate-mihon', [TranslateController::class, 'translateByMihon']);
        });
    });
});
