<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\PostController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('users', [UserController::class,'store']);
Route::get('users', [UserController::class,'index']);
Route::get('users/{id}', [UserController::class,'show']);
Route::put('users/{id}', [UserController::class,'update']);
Route::delete('users/{id}', [UserController::class,'destroy']);

Route::post('login', [AuthController::class,'login']);
Route::post('register', [AuthController::class,'register']);

Route::post('forgot-password', [ForgotPasswordController::class,'sendResetLinkEmail']);
Route::post('reset-password', [ResetPasswordController::class,'reset']);

Route::post('posts/{user_id}', [PostController::class,'store']);
Route::get('posts/{user_id}', [PostController::class,'index']);
Route::get('posts/{user_id}/{id}', [PostController::class,'show']);
Route::put('posts/{user_id}/{id}', [PostController::class,'update']);
Route::delete('posts/{user_id}/{id}', [PostController::class,'destroy']);