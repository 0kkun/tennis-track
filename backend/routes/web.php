<?php

use App\Models\User;
use App\Notifications\Auth\ResetPasswordNotification;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// パスワードリセットメールの確認用
if (app()->isLocal()) {
    Route::get('/forgot-password-email', function () {
        $user = new User([
            'email' => 'user_reset_password_mail@example.com',
        ]);

        return (new ResetPasswordNotification('test_token'))->toMail($user);
    });
}
