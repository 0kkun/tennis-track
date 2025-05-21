<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BasicAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        Log::info('BasicAuthenticate');
        $username = $request->getUser();
        $password = $request->getPassword();

        if ($username == config('basic_auth.user') && $password == config('basic_auth.pass')) {
            return $next($request);
        }

        Log::warning("Basic Auth failed: username={$username}");

        return response('Enter username and password.', 401)
            ->header('WWW-Authenticate', 'Basic realm="Sample Private Page"')
            ->header('Content-Type', 'text/plain; charset=utf-8');
    }
}
