<?php

use App\Models\Cart;
use App\Models\Size;
use App\Models\Order;
use App\Models\Orders;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SMSController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ProductCategoryController;

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

Route::post('/verify/{id}', [AuthController::class, 'verify']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/getUsers', [AuthController::class, 'getUsers']);
Route::get('/logout/{id}', [AuthController::class, 'logout']);
Route::post('/chpass/{id}', [AuthController::class, 'chpass']);

// Categories routes
Route::apiResource('product_categories', ProductCategoryController::class);

// Prices routes
Route::apiResource('pricings', PricingController::class);

// Carts
Route::apiResource('carts', CartController::class);

// Orders routes
Route::apiResource('orders', OrderController::class);

Route::post('/orderstat/{id}/cancel', function($id, Request $request){
    $transac = Transaction::find($id);
    if($request->status == "cancel" && $transac->status =="for approval"){
        Transaction::find($id)->update(['status' => $request['status']]);
        $orders = Order::where('transaction_id', $id)->get();
        foreach ($orders as $ord) {
            $stock = "";
            $stock = ProductCategory::find($ord['product_category_id']);
            $sum = $stock->stock + $ord->qty;
            $stock->update(['stock' => $sum]);
        }

        return response()->json(['message' => "cancelled"]);
    }
});

// Transaction routes
Route::apiResource('transactions', TransactionController::class);

// Types
Route::apiResource('types', TypeController::class);

// Units
Route::apiResource('units', UnitController::class);
// Accounts
Route::get('/accounts', function () {
    return Account::all();
});

Route::group(['middleware' => ['auth:sanctum']], function () {
});

Route::get('/send-sms/{id}', [SMSController::class, 'sendSMS']);


// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
