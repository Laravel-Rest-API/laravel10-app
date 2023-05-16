<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return response()->json(['message' => 'Successfully','data'=>['info'=>'Laravel API Version 1.0']], 200);
});

Route::get('/test', function () {
    $user = User::findOrFail(1);
    return response()->json(['message' => 'Successfully','data'=>$user], 200);
});

Route::prefix('v1')->group(function () {
    Route::apiResource('users', \App\Http\Controllers\Api\V1\UserController::class);
});
//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
