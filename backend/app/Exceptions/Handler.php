<?php

namespace App\Exceptions;

use App\Http\Resources\Common\ErrorResource;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
        $this->reportable(function (\Throwable $e) {
            //
        });

        $this->renderable(function (\Throwable $e, $request) {
            if ($request->is('api/*')) {
                return $this->apiErrorResponse($e);
            }
        });
    }

    /**
     * APIのエラーハンドリング
     *
     * @param \Throwable $e
     * @return ErrorResource
     */
    private function apiErrorResponse(\Throwable $e): ErrorResource
    {
        if ($e instanceof HttpException) {
            $messages = config('api_response.messages');
            $statusCode = $e->getStatusCode();
            Log::alert(print_r([
                'status' => $statusCode,
                'message' => $e->getMessage(),
                'class' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ],true));
            return match ($statusCode) {
                400 => new ErrorResource([$messages[Response::HTTP_BAD_REQUEST]], Response::HTTP_BAD_REQUEST),
                401 => new ErrorResource([$messages[Response::HTTP_UNAUTHORIZED]], Response::HTTP_UNAUTHORIZED),
                403 => new ErrorResource([$messages[Response::HTTP_BAD_REQUEST]], Response::HTTP_BAD_REQUEST),
                404 => new ErrorResource([$messages[Response::HTTP_NOT_FOUND]], Response::HTTP_NOT_FOUND),
                405 => new ErrorResource([$messages[Response::HTTP_METHOD_NOT_ALLOWED]], Response::HTTP_METHOD_NOT_ALLOWED),
                422 => new ErrorResource([$messages[Response::HTTP_UNPROCESSABLE_ENTITY]], Response::HTTP_UNPROCESSABLE_ENTITY),
                500 => new ErrorResource([$messages[Response::HTTP_INTERNAL_SERVER_ERROR]], Response::HTTP_INTERNAL_SERVER_ERROR),
                503 => new ErrorResource([$messages[Response::HTTP_SERVICE_UNAVAILABLE]], Response::HTTP_SERVICE_UNAVAILABLE),
            };
        }
    }
}
