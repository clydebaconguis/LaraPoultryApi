<?php

use App\Models\Cart;
use App\Models\Size;
use App\Models\Orders;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\TransactionController;
use App\Models\Transaction;

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

// Public routes

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
// Route::post('/logout', [UserController::class, 'logout']);

// Categories routes
Route::apiResource('product_categories', ProductCategoryController::class);

// Prices routes
Route::apiResource('pricings', PricingController::class);

// Carts
Route::Resource('carts', CartController::class);

// Orders routes
// Route::apiResource('orders', OrdersController::class);

// Transaction routes
// Route::apiResource('transactions', TransactionController::class);

// Types
Route::apiResource('types', TypeController::class);


// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
