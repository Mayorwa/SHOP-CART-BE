<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;

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

Route::prefix('auth')->name('auth.')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::prefix('user')->name('user.')->middleware('jwt-auth')->group(function () {
    Route::get('/get-logged-in', [AuthController::class, 'getLoggedInUser']);
});

Route::prefix('cart')->name('cart.')->middleware('jwt-auth')->group(function () {
    Route::post('/add-product', [CartController::class, 'addProductToCart'])->name('addProductToCart');
    Route::get('/get-all', [CartController::class, 'getCartProducts'])->name('getCartProducts');
});

Route::prefix('products')->name('products.')->middleware('jwt-auth')->group(function () {
    Route::post('/create', [ProductController::class, 'createAnProduct'])->name('createAnItem');
    Route::get('/get-all', [ProductController::class, 'getAllProducts'])->name('getAllProducts');
    Route::get('/{product_id}', [ProductController::class, 'getOneProduct'])->name('getOneProduct');
});
