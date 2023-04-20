<?php

use App\Http\Controllers\Apis\V1\Admins\Auth\AdminAuthController;
use App\Http\Controllers\Apis\V1\Users\Auth\UserAuthController;
use App\Http\Controllers\Apis\V1\Users\Auth\UserPasswordResetController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1/')->group(function() {
    Route::prefix('/users')->group(function() {
        Route::post('/register', [UserAuthController::class, 'register']);
        Route::post('/login', [UserAuthController::class, 'login']);
        Route::post('/logout', [UserAuthController::class, 'logout']);
        Route::post('/reset/send', [UserPasswordResetController::class, 'sendResetLinkEmail'])->name('password.reset.send');
        Route::patch('/reset', [UserPasswordResetController::class, 'reset'])->name('password.reset');

        Route::middleware(['auth:sanctum', 'can:general'])->group(function() {
            Route::get('/me', [UserAuthController::class, 'me']);
            Route::as('users.')->group(function () {
                Route::patch('reset/{id}', [UserPasswordResetController::class, 'reset'])->name('password.reset');
            });
        });
    });

    Route::prefix('/admins')->group(function() {
        Route::post('/register', [AdminAuthController::class, 'register']);
        Route::post('/login', [AdminAuthController::class, 'login']);
        Route::post('/logout', [AdminAuthController::class, 'logout']);
        Route::middleware(['auth:sanctum', 'can:admin'])->group(function() {
            Route::get('/me', [AdminAuthController::class, 'me']);
            // Route::apiResource('/csv', CsvController::class)->only(['index', 'store']);
        });
    });
});