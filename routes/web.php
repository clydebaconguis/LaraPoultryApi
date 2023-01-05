<?php

use Illuminate\Support\Facades\Route;
use App\Http\Model\ProductCategory;
use App\Http\Controllers\ProductCategoryController;

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

// Route::get('/login', function () {
//     return view('login');
// });

Route::get('/', function () {
    return view('content.dashboard');
});

Route::get('/products', function (){
    return view('content.products', ['products' => ProductCategory::all()]);
} );