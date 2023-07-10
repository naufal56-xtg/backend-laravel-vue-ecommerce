<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Front\FrontCartController;
use App\Http\Controllers\Front\FrontCategoryController;
use App\Http\Controllers\Front\FrontOrderController;
use App\Http\Controllers\Front\FrontProductController;
use App\Http\Controllers\Front\FrontUserController;
use App\Http\Controllers\Front\FrontWishlistController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/users', [UserController::class, 'index']);
Route::post('/users/store', [UserController::class, 'store']);

Route::get('/products', [FrontProductController::class, 'index']);
Route::get('/carts', [FrontCartController::class, 'index']);
Route::get('/wishlists', [FrontWishlistController::class, 'index']);
Route::get('/categories', [FrontCategoryController::class, 'index']);
Route::get('/orders', [FrontOrderController::class, 'index']);
Route::get('/users', [FrontUserController::class, 'index']);
