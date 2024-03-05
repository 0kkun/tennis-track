<?php

namespace App\Http\Controllers\Apis\V1\Users\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\Auth\SendPasswordResetMailRequest;
use App\Http\Resources\Common\SuccessResource;
use App\Models\User;
use App\Modules\ApplicationLogger;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PasswordResetController extends Controller
{
    /**
     * パスワードリセット用のメールを送信する
     *
     * @param SendPasswordResetMailRequest $request
     * @throws Exception
     * @return SuccessResource
     */
    public function sendResetLinkEmail(SendPasswordResetMailRequest $request): SuccessResource
    {
        $logger = new ApplicationLogger(__METHOD__);

        try {
            $status = $this->broker()->sendResetLink($request->only('email'));

            if ($status !== Password::RESET_LINK_SENT) {
                throw new HttpException(
                    Response::HTTP_UNPROCESSABLE_ENTITY,
                    trans($status)
                );
            }
        } catch (\Exception $e) {
            $logger->exception($e);
            throw $e;
        }
        $logger->success();

        return new SuccessResource();
    }

    /**
     * パスワードリセットを行う
     *
     * @throws Exception
     * @return SuccessResource
     */
    public function reset(): SuccessResource
    {
        $logger = new ApplicationLogger(__METHOD__);

        try {
            $credentials = request()->only(['email', 'token', 'password']);

            $status = $this->broker()->reset($credentials, function (User $user, string $password) {
                $user->password = Hash::make($password);
                $user->save();
            });

            if ($status !== Password::PASSWORD_RESET) {
                throw new HttpException(
                    Response::HTTP_UNPROCESSABLE_ENTITY,
                    trans($status)
                );
            }
        } catch (\Exception $e) {
            $logger->exception($e);
            throw $e;
        }
        $logger->success();

        return new SuccessResource();
    }

    /**
     * パスワードリセットブローカーを取得する
     *
     * @return PasswordBroker
     */
    public function broker(): PasswordBroker
    {
        return Password::broker();
    }
}
