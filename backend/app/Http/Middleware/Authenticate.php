<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * @param Request $req
     * @param Closure $next
     * @return JsonResponse
     */
    public function handle(Request $req, Closure $next): JsonResponse
    {
        $segments = explode('/', $req->path());

        $isApi = in_array('api', $segments, true);
        if (! $isApi) {
            return $next($req);
        }

        $guard = $this->getGuard($segments);
        if (! Auth::guard($guard)->check()) {
            throw new AuthenticationException('Unauthenticated.');
        }

        return $next($req);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('users.login');
        }
    }

    /**
     * @param array $segments
     * @return string
     */
    private function getGuard(array $segments): string
    {
        $segment = $segments[2] ?? null;

        switch ($segment) {
            case 'admins':
                return 'admin-api';
            case 'users':
                return 'user-api';
            default:
                return 'web';
        }
    }
}
