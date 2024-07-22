<?php

use App\Http\Controllers\Apis\V1\Admins\Auth\AuthController;
use App\Http\Controllers\Apis\V1\Admins\Csv\CsvController;
use App\Http\Controllers\Apis\V1\Admins\File\FileController;
use App\Http\Controllers\Apis\V1\Admins\Player\AdminPlayerController;
use App\Http\Controllers\Apis\V1\Admins\Translate\TranslateController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/')->group(function () {
    Route::prefix('/admins')->name('admins.')->group(function () {
        Route::post('/', [AuthController::class, 'register'])->name('register');
        Route::post('/sessions', [AuthController::class, 'login'])->name('login');

        Route::middleware(['auth:sanctum'])->group(function () {
            Route::get('/me', [AuthController::class, 'me'])->name('me');
            Route::delete('/sessions', [AuthController::class, 'logout'])->name('logout');
            Route::apiResource('/csv', CsvController::class)->only(['index', 'store']);
            Route::apiResource('/file', FileController::class)->only(['index', 'store']);
            Route::post('/players/imports', [AdminPlayerController::class, 'import']);
            Route::get('/players/exports', [AdminPlayerController::class, 'export']);
            Route::apiResource('/players', AdminPlayerController::class);
            Route::get('/translate-mihon', [TranslateController::class, 'translateByMihon']);
        });
    });
});
