
# Laravel 10 - Handle Exception

Make API with laravel 10 need to handle exception and show response with json format. This package will help you to handle exception and show response with json format.





[![MIT License](https://img.shields.io/badge/License-MIT-green.svg)](https://choosealicense.com/licenses/mit/)

## Configuration

To make this response, you can follow the steps below:

edit file `app/Exceptions/Handler.php` and add the following code

```php
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
        }
        return parent::render($request, $e);
    }
```

You can add other exception what you need.

## Test
You can test this package with postman or other tools.

```bash
php artisan serve
```

## Result

open postman and make request with url `http://localhost:8000/api/test` with method `GET`
```json
{
    "status": "error",
    "message": "User not found"
}
```

open postman and make request with url `http://localhost:8000/api/test` with method `POST`
```json
{
    "status": "error",
    "message": "Method not allowed"
}
```

## License

[MIT](https://choosealicense.com/licenses/mit/)

