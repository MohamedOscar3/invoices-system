<?php

namespace App\Exceptions;

use App\Http\Responses\ApiResponse;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {

        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Exception|\Throwable $e)
    {
        if ($request->expectsJson()) {

            // Handle JSON requests with your custom JSON responses
            if ($e instanceof ValidationException) {
                return ApiResponse::errorResponse($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY,$e->errors());
            } else  {
                return ApiResponse::errorResponse($e->getMessage(), Response::HTTP_NOT_FOUND);
            }


        }

        return parent::render($request, $e);
    }
}
