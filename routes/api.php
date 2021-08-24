<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('login', [UserController::class, 'login']);

Route::post('logout', [UserController::class, 'logout'])
    ->middleware('auth:sanctum');

Route::get('posts', [PostController::class, 'index']);

Route::get('posts/{post}', [PostController::class, 'show'])
    ->where('post', '[0-9]+');

Route::post('posts', [PostController::class, 'store'])
    ->middleware('auth:sanctum');

Route::put('posts/{post}', [PostController::class, 'update'])
    ->where('id', '[0-9]+')
    ->middleware('auth:sanctum');

Route::delete('posts/{post}', [PostController::class, 'destroy'])
    ->middleware('auth:sanctum');
