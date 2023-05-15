<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Str;
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

    public function render($request, Throwable $e)
    {
        if ($request->expectsJson()){
            if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException){
                $modelClass = explode('\\', $e->getModel());

                return response()->json([
                    'status' => 'error',
                    'message' => end($modelClass).' not found'
                ], 404);
            }
            if ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException){
                return response()->json([
                    'status' => 'error',
                    'message' => 'URL not found'
                ], 404);
            }
            if ($e instanceof \Illuminate\Auth\AuthenticationException){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthenticated'
                ], 401);
            }
            if ($e instanceof \Illuminate\Auth\Access\AuthorizationException){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized'
                ], 403);
            }
            if ($e instanceof \Illuminate\Validation\ValidationException){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation error',
                    'errors' => $e->errors()
                ], 422);
            }
            if ($e instanceof \Illuminate\Database\QueryException){
                $message = Str::between($e->getMessage(), '[7] ', ' (0x');
                return response()->json([
                    'status' => 'error',
                    'message' => 'Database error',
                    'errors' => $message
                ], 500);
            }
            if ($e instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Method not allowed'
                ], 405);
            }
            if ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpException){
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ], $e->getStatusCode());
            }
            if ($e instanceof \ErrorException){
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ], 500);
            }
            if ($e instanceof \TypeError){
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ], 500);
            }
            if ($e instanceof \Exception){
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ], 500);
            }
        }
        return parent::render($request, $e);
    }
}
