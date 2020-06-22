<?php

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

Route::post('/auth', [\App\Http\Controllers\Api\UserController::class, 'auth']);
Route::post('/register', [\App\Http\Controllers\Api\UserController::class, 'register']);
Route::post('/check-auth', [\App\Http\Controllers\Api\UserController::class, 'checkAuth'])->middleware(['auth:api']);

Route::get('/product', [\App\Http\Controllers\Api\ProductController::class, 'index']);
Route::get('/delivery', [\App\Http\Controllers\Api\DeliveryController::class, 'getDeliveryList']);
Route::post('/calcDelivery', [\App\Http\Controllers\Api\DeliveryController::class, 'calcDelivery']);

Route::post('/order', [\App\Http\Controllers\Api\OrderController::class, 'store']);
Route::get('/order-list', [\App\Http\Controllers\Api\OrderController::class, 'index'])->middleware(['auth:api']);

