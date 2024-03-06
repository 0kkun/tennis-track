<?php

declare(strict_types=1);

namespace App\Http\Controllers\Apis\V1\Users\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\Auth\ForgotPasswordRequest;
use App\Http\Resources\Common\SuccessResource;
use App\Modules\ApplicationLogger;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

final class ForgotPasswordController extends Controller
{
    /**
     * パスワードリセット用のメールを送信する
     * @param ForgotPasswordRequest $request
     * @throws ValidationException
     * @return SuccessResource
     */
    public function __invoke(ForgotPasswordRequest $request): SuccessResource
    {
        $logger = new ApplicationLogger(__METHOD__);
        $status = Password::sendResetLink($request->only('email'));
        try {
            if ($status !== Password::RESET_LINK_SENT) {
                throw ValidationException::withMessages([
                    'email' => trans($status),
                ]);
            }
        } catch (\Exception $e) {
            $logger->exception($e);
            throw $e;
        }
        $logger->success();

        return new SuccessResource(['message' => trans($status)]);
    }
}
