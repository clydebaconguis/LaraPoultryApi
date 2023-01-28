<?php

use Illuminate\Support\Facades\Route;
use App\Models\ProductCategory;
use App\Http\Controllers\ProductCategoryController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/', function () {
    return view('content.dashboard');
});

Route::get('/products', function () {
    return view('content.products', [ 'products' => ProductCategory::all() ] );
} );

Route::get('/orders', function () {
    return view('content.orders', [ 'orders' => DB::table('transactions')
    ->join('users', 'transactions.user_id', "=", 'users.id')
    ->select('transactions.*', 'users.name')
    ->orderBy('created_at', 'DESC')->get() ] );
} );

Route::get('/users', function () {
    return view('content.users', [ 'users' => User::where('status', 0)->orderBy('created_at', 'ASC')->get() ] );
} );
