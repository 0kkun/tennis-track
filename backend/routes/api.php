<?php

use App\Http\Controllers\Apis\V1\Users\Auth\AuthController;
use App\Http\Controllers\Apis\V1\Users\Auth\ForgotPasswordController;
use App\Http\Controllers\Apis\V1\Users\Auth\ResetPasswordController;
use App\Http\Controllers\Apis\V1\Users\FavoritePlayer\FavoritePlayerController;
use App\Http\Controllers\Apis\V1\Users\Player\PlayerController;
use App\Http\Controllers\Apis\V1\Users\TennisAtpRanking\TennisAtpRankingController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/')->group(function () {
    Route::prefix('/users')->group(function () {
        Route::post('/', [AuthController::class, 'register'])->name('users.register');
        // Route::post('/register', [AuthController::class, 'register'])->name('users.register');
        Route::post('/sessions', [AuthController::class, 'login'])->name('users.login');
        Route::post('/forgot-password', ForgotPasswordController::class)->name('password.forgot');
        Route::post('/reset-password', ResetPasswordController::class)->name('password.reset');

        Route::middleware(['auth:sanctum'])->group(function () {
            Route::get('/me', [AuthController::class, 'me'])->name('users.me');
            Route::delete('/sessions', [AuthController::class, 'logout'])->name('users.logout');
            // Route::post('/logout', [AuthController::class, 'logout'])->name('users.logout');
            Route::as('users.')->group(function () {
                Route::apiResource('/players', PlayerController::class)->only(['index', 'show']);
                Route::apiResource('/tennis_atp_rankings', TennisAtpRankingController::class)->only(['index', 'show']);
                Route::apiResource('/favorite_players', FavoritePlayerController::class)->only(['index', 'store', 'destroy']);
            });
        });
    });
});
