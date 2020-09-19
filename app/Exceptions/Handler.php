<?php

namespace App\Exceptions;

use App\Traits\ApiResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponse;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
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
        //
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($e, $request);
        }

        if ($e instanceof ModelNotFoundException) {
            $resource = strtolower(class_basename($e->getModel()));
            return $this->errorResponse($resource . ' not found.', 404);
        }

        if ($e instanceof AuthenticationException) {
            return $this->unauthenticated($request, $e);
        }

        if ($e instanceof AuthorizationException) {
            return $this->errorResponse('User is not authorized.', 403);
        }

        if ($e instanceof NotFoundHttpException) {
            return $this->errorResponse('Route not found.', 404);
        }

        if ($e instanceof MethodNotAllowedHttpException) {
            return $this->errorResponse('Invalid request method .', 405);
        }

        if ($e instanceof HttpException) {
            $message = $e->getMessage();
            $status = $e->getStatusCode();
            return $this->errorResponse($message, $status);
        }

        if (config('app.debug')) {
            return parent::render($request, $e);
        }

        return $this->errorResponse('An internal error occurred. Please try again later.', 500);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $this->errorResponse('User is not authenticated.', 401);
    }

    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        $message = $e->getMessage();
        $errors = $e->validator->errors()->getMessages();
        $status = $e->status;
        return $this->errorResponse($message, $status, $errors);
    }
}
