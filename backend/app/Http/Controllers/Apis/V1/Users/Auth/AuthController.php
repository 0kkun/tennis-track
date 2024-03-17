<?php

namespace App\Http\Controllers\Apis\V1\Users\Auth;

use App\Eloquents\EloquentUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\Auth\LoginRequest;
use App\Http\Requests\Users\Auth\RegisterRequest;
use App\Http\Resources\Common\SuccessResource;
use App\Modules\ApplicationLogger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * ユーザー新規登録
     *
     * @param RegisterRequest $request
     * @return SuccessResource
     */
    public function register(RegisterRequest $request): SuccessResource
    {
        $logger = new ApplicationLogger(__METHOD__);

        $user = EloquentUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        $token = $user->createToken($request->email)->plainTextToken;

        $logger->success();

        return new SuccessResource(['token' => $token]);
    }

    /**
     * トークン認証ログイン
     * 1emailにつき1つのトークンを発行する仕様
     *
     * @param LoginRequest $request
     * @throws Exception
     * @return SuccessResource
     */
    public function login(LoginRequest $request): SuccessResource
    {
        $logger = new ApplicationLogger(__METHOD__);
        $user = EloquentUser::where('email', $request->email)->first();
        try {
            if (! $user || ! Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([trans('auth.password')]);
            }
            $user->tokens()->where('name', $request->email)->delete();
            $token = $user->createToken($request->email)->plainTextToken;
        } catch (\Exception $e) {
            $logger->exception($e);
            throw $e;
        }
        $logger->success();

        return new SuccessResource(['token' => $token]);
    }

    /**
     * ログアウト
     *
     * @throws Exception
     * @return SuccessResource
     */
    public function logout(): SuccessResource
    {
        $logger = new ApplicationLogger(__METHOD__);
        try {
            /** @var \App\EloquentUser\MyUserModel $user * */
            $user = Auth::guard('user-api')->user();
            if (empty($user)) {
                $logger->success();

                return new SuccessResource([trans('auth.already_logout')]);
            }
            $user->currentAccessToken()->delete();
        } catch (\Exception $e) {
            $logger->exception($e);
            throw $e;
        }
        $logger->success();

        return new SuccessResource();
    }

    /**
     * 自身のアカウント情報を取得する
     *
     * @throws Exception
     * @return SuccessResource
     */
    public function me(): SuccessResource
    {
        $logger = new ApplicationLogger(__METHOD__);
        try {
            /** @var \App\EloquentUser\MyUserModel $user * */
            $user = Auth::guard('user-api')->user();
            $result = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ];
        } catch (\Exception $e) {
            $logger->exception($e);
            throw $e;
        }
        $logger->success();

        return new SuccessResource($result);
    }
}
