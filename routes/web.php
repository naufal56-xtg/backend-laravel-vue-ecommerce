<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/admin/login', [LoginController::class, 'index'])->name('admin.index');
Route::post('/admin/login', [LoginController::class, 'login'])->name('admin.login');


// Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/api/categories', [CategoryController::class, 'index'])->name('api.categories');
    Route::get('/api/categories/data', [CategoryController::class, 'getData']);
    Route::post('/api/categories/store', [CategoryController::class, 'store']);
    Route::put('/api/categories/update/{category}', [CategoryController::class, 'update']);
    Route::delete('/api/categories/delete/{category}', [CategoryController::class, 'delete']);
    Route::delete('/api/categories', [CategoryController::class, 'bulkDeleteCategory']);

    Route::get('/api/products', [ProductController::class, 'index']);
    Route::get('/api/products/detail/{id}', [ProductController::class, 'detail']);
    Route::post('/api/products/store', [ProductController::class, 'store']);
    Route::post('/api/products/update/{id}', [ProductController::class, 'update']);
    Route::delete('/api/products/delete/{id}', [ProductController::class, 'delete']);
    Route::delete('/api/products', [ProductController::class, 'bulkDeleteProduct']);

    Route::get('/api/users', [UserController::class, 'index']);
    Route::get('/api/users/detail/{id}', [UserController::class, 'detail']);

    Route::get('/api/orders', [OrderController::class, 'index']);
});




Route::get('{view}', ApplicationController::class)->where('view', '(.*)')->middleware('auth');
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
