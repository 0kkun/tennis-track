<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e, $request) {
            if ($request->is('api/*')) {
                return $this->apiErrorResponse($e, $request);
            }
        });
    }

    /**
     * APIのエラーハンドリング
     *
     * @param [type] $request
     * @param \Throwable $exception
     * @return void
     */
    private function apiErrorResponse(Throwable $e, $request)
    {
        if ($e instanceof HttpException) {
            $statusCode = $e->getStatusCode();
            return match ($statusCode) {
                400 => response()->error(Response::HTTP_BAD_REQUEST, 'Bad Request'),
                401 => response()->error(Response::HTTP_UNAUTHORIZED, 'Unauthorized'),
                403 => response()->error(Response::HTTP_FORBIDDEN, 'Forbidden'),
                404 => response()->error(Response::HTTP_NOT_FOUND, 'Not Found'),
                405 => response()->error(Response::HTTP_METHOD_NOT_ALLOWED, 'Method Not Allowed'),
                422 => response()->error(Response::HTTP_UNPROCESSABLE_ENTITY, 'Unprocessable Entity'),
                500 => response()->error(Response::HTTP_INTERNAL_SERVER_ERROR, 'Server Error'),
                503 => response()->error(Response::HTTP_SERVICE_UNAVAILABLE, 'Service Unavailable'),
            };
        }
    }
}
