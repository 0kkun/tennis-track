<?php

use App\Eloquents\EloquentUser;
use App\Notifications\Auth\ResetPasswordNotification;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

// パスワードリセットメールの確認用
if (app()->isLocal()) {
    Route::get('/forgot-password-email', function () {
        $user = new EloquentUser([
            'email' => 'user_reset_password_mail@example.com',
        ]);

        return (new ResetPasswordNotification('test_token'))->toMail($user);
    });
}

Route::middleware('basic.auth')->group(function () {
    Route::get('/schemaspy', function () {
        $path = public_path('schemaspy/index.html');
        if (File::exists($path)) {
            return response()->file($path);
        }
        abort(404);
    });
});
