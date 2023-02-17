<?php

use Illuminate\Support\Facades\Route;
use App\Models\ProductCategory;
use App\Http\Controllers\ProductCategoryController;
use App\Models\User;
use App\Models\Type;
use App\Models\Unit;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Size;
use App\Models\Stock;
use App\Models\Pricing;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ProductCategoryResource;

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

Route::post('/addproduct', function (Request $request) {
    
        if ($request['purpose'] == "add") {
            $isTaken = ProductCategory::where('name', $request->name)->first();
            if (!$isTaken) {
                $products = $request->validate([
                    'name' => 'required|string',
                    'image' => 'image|mimes:jpg,jpeg,png',
                    'stock' => 'required',
                    'status' => 'required',
                ]);
                if ($request->hasFile('image')) {
                    $filename = Str::random(10);
                    $request->file('image')->storeAs('', $filename, 'google');
                    $path = Storage::disk('google')->getMetadata($filename);
                    $products['image'] = '';
                    $products['image'] = $path['path'];
                    $id = ProductCategory::create($products)->id;
                    $json_params = json_decode($request['prices'], true);
                    $price = array();
                    foreach ($json_params as $item) {
                        $price = array();
                        $price = [
                            'product_category_id' => $id,
                            'type' => $item['type'],
                            'unit' => $item['unit'],
                            'value' => $item['value'],
                        ];
                        Pricing::create($price);
                    }
                }
            }
        } else {

            $formfields = $request->validate([
                'name' => 'required|string',
                'image' => 'image|mimes:jpg,jpeg,png',
                'stock' => 'required',
                'status' => 'required',
            ]);

            if ($request->hasFile('image')) {
                $filename = Str::random(10);
                $request->file('image')->storeAs('', $filename, 'google');
                $path = Storage::disk('google')->getMetadata($filename);
                $formfields['image'] = '';
                $formfields['image'] = $path['path'];
            }

            $json_params = json_decode($request['prices'], true);
            $price = array();
            foreach ($json_params as $item) {
                $price = array();
                $price = [
                    'product_category_id' => $request['id'],
                    'type' => $item['type'],
                    'unit' => $item['unit'],
                    'value' => $item['value'],
                ];
                if ($item['id'] != 0) {
                    Pricing::where('id', $item['id'])->update($price);
                } else {
                    Pricing::create($price);
                }
            }

        return ProductCategory::where('id', $request['id'])->update($formfields);
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