<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminApiAuthentication
{
    /**
     * tokenにadmin権限を持っているかどうかを確認する
     *
     * @param Request $req
     * @param Closure $next
     * @return JsonResponse
     */
    public function handle(Request $req, Closure $next): JsonResponse
    {
        if (! $req->user()->tokenCan('admin')) {
            throw new AuthorizationException();
        }

        return $next($req);
    }
}
