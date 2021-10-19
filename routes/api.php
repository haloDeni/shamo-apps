<?php

use App\Http\Controllers\API\ProductCategoryController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('products', [ProductController::class, 'all']);
Route::get('products-category', [ProductCategoryController::class, 'all']);
Route::post('products-category', [ProductCategoryController::class, 'createdata']);
Route::post('products-category/{id}', [ProductCategoryController::class, 'updatedata']);
Route::delete('products-category/{id}', [ProductCategoryController::class, 'deletedata']);
Route::get('register', [UserController::class, 'register']);
