<?php

use Illuminate\Support\Facades\Route;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\ProductCategoryController;
use App\Models\User;
use App\Models\Order;
use App\Models\Type;
use App\Models\Unit;
use App\Models\Stock;
use App\Models\Pricing;
use App\Models\Transaction;
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

Route::get('/verify/{id}', function ($id) {
    $result = User::find($id)->update(['status' => 1]);
    if ($result) {
        return redirect('/users');
    }
});

Route::get('/addprod', function () {
    return view(
        'content.addprod',
        [
            'types' => Type::all(),
            'units' => Unit::all()
        ]
    );
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

            $price = [
                'product_category_id' => $id,
                'type' => $request['type'],
                'unit' => $request['unit'],
                'value' => $request['price'],
            ];
            Pricing::create($price);
        }
        return back()->with('message', 'Updated successfully!');
    }
});
Route::post('/updateprod/{id}', function ($id, Request $request) {

    $products = $request->validate([
        'name' => 'string',
        'stock' => 'numeric',
        'image' => 'image|mimes:jpg,jpeg,png',
    ]);

    if ($request->hasFile('image')) {
        $filename = Str::random(10);
        $request->file('image')->storeAs('', $filename, 'google');
        $path = Storage::disk('google')->getMetadata($filename);
        $formfields['image'] = '';
        $formfields['image'] = $path['path'];
        ProductCategory::find($id)->update($products);
    }

    ProductCategory::find($id)->update([
        'name' => $request['name'],
        'stock' => $request['stock'],
    ]);

    $priceid = $request['priceid'];
    $price = $request['price'];

    for ($i = 0; $i < count($price); $i++) {
        Pricing::where('id', $priceid[$i])->update([
            'value' => $price[$i],
        ]);
    }

    return back()->with('message', 'Updated successfully!');
});

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dash', function () {
    return view('content.dashboard');
});

Route::get('/products', function () {
    return view('content.products', ['products' => ProductCategory::all()]);
});

Route::get('/editprod/{prod}/edit', function (ProductCategory $prod) {
    return view(
        'content.editprod',
        [
            'products' => $prod,
            'prices' =>  Pricing::where('product_category_id', $prod['id'])->get()
        ]
    );
});

Route::get('/orders', function () {
    return view('content.orders', ['orders' => DB::table('transactions')
        ->join('users', 'transactions.user_id', "=", 'users.id')
        ->select('transactions.*', 'users.name')
        ->orderBy('created_at', 'DESC')->get()]);
});

Route::post('/orderstat/{orderid}', function ($orderid, Request $request) {
    Transaction::find($orderid)->update(['status' => $request['orderstat']]);

    return back()->with('message', 'Status updated successfully!');
});

Route::get('/users', function () {
    return view('content.users', ['users' => User::where('status', 0)->orderBy('created_at', 'ASC')->get()]);
});

Route::get('/types', function () {
    return view('content.type', ['types' => Type::all()]);
});

Route::get('/orderdetails/{id}', function ($id) {
    return view(
        'content.orderdetails',
        [
            'details' => DB::table('transactions')
                ->join('users', 'transactions.user_id', "=", 'users.id')
                ->select('transactions.*', 'users.name')
                ->where('transactions.id', $id)->get(),

            'items' => DB::table('orders')
                ->join('product_categories', 'orders.product_category_id', "=", 'product_categories.id')
                ->select('orders.*', 'product_categories.name', 'product_categories.image')
                ->where('transaction_id', $id)->get(),
        ]
    );
});
