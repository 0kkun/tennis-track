<?php

namespace App\Http\Controllers\Apis\V1\Users\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\Auth\ResetPasswordRequest;
use App\Http\Resources\Common\SuccessResource;
use App\Eloquents\EloquentUser;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class ResetPasswordController extends Controller
{
    /**
     * パスワードリセットを行う
     * @param ResetPasswordRequest $request
     * @throws ValidationException
     * @return SuccessResource
     */
    public function __invoke(ResetPasswordRequest $request): SuccessResource
    {
        $credentials = request()->only(['email', 'token', 'password']);

        $status = Password::reset($credentials, function (EloquentUser $user, string $password) {
            $user->password = bcrypt($password);
            $user->save();
        });

        if ($status !== Password::PASSWORD_RESET) {
            throw ValidationException::withMessages([
                'email' => trans($status),
            ]);
        }

        return new SuccessResource([
            'message' => trans($status),
        ]);
    }
}
