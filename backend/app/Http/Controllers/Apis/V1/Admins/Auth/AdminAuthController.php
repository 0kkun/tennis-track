<?php

namespace App\Http\Controllers\Apis\V1\Admins\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admins\Auth\LoginRequest;
use App\Http\Requests\Admins\Auth\RegisterRequest;
use App\Http\Resources\Common\SuccessResource;
use App\Models\User;
use App\Modules\ApplicationLogger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminAuthController extends Controller
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

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => User::ADMIN,
            'password' => Hash::make($request->password)
        ]);
        $token = $user->createToken($request->token_name)->plainTextToken;

        $logger->success();
        return new SuccessResource(['token' => $token]);
    }

    /**
     * トークン認証ログイン
     * 1emailにつき1つのトークンを発行する仕様
     *
     * @param LoginRequest $request
     * @return SuccessResource
     * @throws Exception
     */
    public function login(LoginRequest $request): SuccessResource
    {
        $logger = new ApplicationLogger(__METHOD__);
        $credentials = $request->only(['email', 'password']);
        try {
            if (!Auth::attempt($credentials)) {
                throw ValidationException::withMessages([trans('auth.password')]);
            }
            $user = User::where('email', $request->email)->first();
            $user->tokens()->where('name', $request->email)->delete();
            $token = $request->user()->createToken($request->email)->plainTextToken;
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
     * @return SuccessResource
     * @throws Exception
     */
    public function logout(): SuccessResource
    {
        $logger = new ApplicationLogger(__METHOD__);
        try {
            /** @var \App\Models\MyUserModel $user **/
            $user = Auth::guard('sanctum')->user();
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
     * @return SuccessResource
     * @throws Exception
     */
    public function me(): SuccessResource
    {
        $logger = new ApplicationLogger(__METHOD__);
        try {
            /** @var \App\Models\MyUserModel $user **/
            $user = Auth::guard('sanctum')->user();
            $result = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->convertRoleString(),
            ];
        } catch (\Exception $e) {
            $logger->exception($e);
            throw $e;
        }
        $logger->success();
        return new SuccessResource($result);
    }
}
