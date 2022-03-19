<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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

Route::get('products', [ProductController::class, 'getAll']);
Route::get('products/{id}', [ProductController::class, 'getById']);
Route::post('products', [ProductController::class, 'create']);
Route::post('products/{id}/update', [ProductController::class, 'update']);
Route::post('products/{id}/delete', [ProductController::class, 'delete']);

Route::get('users', [UserController::class, 'getAll']);
Route::get('users/{email}', [UserController::class, 'getByEmail']);
Route::post('users', [UserController::class, 'create']);
Route::put('users/{email}', [UserController::class, 'update']);
Route::delete('users/{email}', [UserController::class, 'delete']);