<?php

use Illuminate\Support\Facades\Route;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\ProductCategoryController;
use App\Models\User;
use App\Models\Type;
use App\Models\Unit;
use App\Models\Stock;
use App\Models\Pricing;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
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

Route::get('/addprod', function () {
    return view('content.addprod', 
    [   'types' => Type::all(),
        'units' => Unit::all() 
    ] );
});

 /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
Route::post('/addproduct', function (Request $request) {
    $isTaken = ProductCategory::where('name', $request->name)->first();
    if (!$isTaken) {
        $products = $request->validate([
            'name' => 'required|string',
            'image' => 'image|mimes:jpg,jpeg,png',
            'stock' => 'required',
        ]);
        if ($request->hasFile('image')) {
            $filename = Str::random(10);
            $request->file('image')->storeAs('', $filename, 'google');
            $path = Storage::disk('google')->getMetadata($filename);
            $products['image'] = '';
            $products['image'] = $path['path'];
            $id = ProductCategory::create($products)->id;
            // $json_params = json_decode($request['prices'], true);
            // $price = array();
            // foreach ($json_params as $item) {
            //     $price = array();
            //     $price = [
            //         'product_category_id' => $id,
            //         'type' => $item['type'],
            //         'unit' => $item['unit'],
            //         'value' => $item['value'],
            //     ];
            //     Pricing::create($price);
            // }
            $price = [
                'product_category_id' => $id,
                'type' => $request['type'],
                'unit' => $request['unit'],
                'value' => $request['price'],
            ];
            Pricing::create($price);
        }
    }
});

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

Route::get('/types', function () {
    return view('content.type', [ 'types' => Type::all()] );
} );