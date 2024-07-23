<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SetSanctumGuard
{
    public function handle(Request $request, Closure $next)
    {
        if (Str::startsWith($request->getRequestUri(), '/api/v1/admins/')) {
            config(['sanctum.defaults.guard' => 'admin-api']);
        } elseif (Str::startsWith($request->getRequestUri(), '/api/v1/users/')) {
            config(['sanctum.defaults.guard' => 'user-api']);
        } else {
            config(['sanctum.defaults.guard' => 'web']);
        }

        return $next($request);
    }
}
