<?php

namespace DoeSangue\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     * @var array
     */
    protected $dontFlash = [
      'password',
      'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param \Exception $exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception               $exception
     *
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        // Validate 404 exceptions.
        if ($exception instanceof NotFoundHttpException) {
            return response()->json(
                [
                'error' => [
                    'description' => 'Invalid URI',
                    'messages' => [ ]
                ]
                ], 404
            );
        }

        // Method not allowed exception handler
        if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->json(
                [
                'error' => [
                    'description' => 'Method Not Allowed',
                    'messages' => [ ]
                ]
                ], 405
            );
        }

        return parent::render($request, $exception);
    }

    /**
     * Convert a validation exception into a JSON response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Validation\ValidationException $exception
     * @return \Illuminate\Http\JsonResponse
     */
    protected function invalidJson($request, ValidationException $exception)
    {
      return response()->json($exception->errors(), $exception->status);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param \Illuminate\Http\Request                 $request
     * @param \Illuminate\Auth\AuthenticationException $exception
     *
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {

            return response()->json([ 'error' => 'Unauthenticated.' ], 401);

        }

        // return redirect()->guest('login');
    }


}
