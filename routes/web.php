<?php

use Carbon\Carbon;
use App\Models\Type;
use App\Models\Unit;
use App\Models\User;
use App\Models\Order;
use App\Models\Stock;
use App\Models\Account;
use App\Models\Pricing;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ProductCategoryController;
use Illuminate\Support\Facades\Auth;

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
})->middleware('auth');

Route::get('/addprod', function () {
    return view(
        'content.addprod',
        [
            'types' => Type::all(),
            'units' => Unit::select('units.*','types.name')
            ->join('types', 'units.type_id', "=", 'types.id')
            ->get(),
        ]
    );
})->middleware('auth');

// Route::get('/dropdown', function (Request $request) {
//     return view(
//         'content.addprod',
//         [
//             'units' => Unit::select('units.*','types.name')
//             ->join('types', 'units.type_id', "=", 'types.id')
//             ->where('units.type_id', $request['id'])
//             ->get(),
//         ]
//     );
// })->middleware('auth');

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
            'price' => 'required',
            'unit' => 'required',
            'type' => 'required',

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
        return back()->with('message', 'Added successfully!');
    }
})->middleware('auth');
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
})->name('login')->middleware('guest');

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/');
})->middleware('auth');

Route::post('/auth-admin', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if(Auth::attempt($credentials)){
        $request->session()->regenerate();
        return redirect('/dash');
    }
    return redirect()->back()->withErrors(['email', 'Invalid Credentials']);
});


Route::get('/dash', function () {
    $totalProducts = ProductCategory::count();
    $totalCategory = Type::count();
    $totalOrder = Transaction::count();
    $totalUser = User::count();
    return view('content.dashboard', [
        'totalProducts' => $totalProducts,
        'totalCategory' => $totalCategory,
        'totalOrder' => $totalOrder,
        'totalUser' => $totalUser,
        'user' => auth()->user(),
        'orders' => Transaction::select('transactions.*','users.name')
        ->join('users', 'transactions.user_id', "=", 'users.id')
        ->where('transactions.status', 'delivery')
        ->orderBy('id', 'desc')->get() ,
        'orders2' => Transaction::select('transactions.*','users.name')
        ->join('users', 'transactions.user_id', "=", 'users.id')
        ->where('transactions.status', 'for approval')
        ->orderBy('id', 'desc')->get() ,
    ]);
})->middleware('auth');

Route::get('/products', function () {
    return view('content.products', ['products' => ProductCategory::orderBy('created_at', 'ASC')->get()]);
})->middleware('auth');

Route::get('/editprod/{prod}/edit', function (ProductCategory $prod) {
    return view(
        'content.editprod',
        [
            'products' => $prod,
            'prices' =>  Pricing::where('product_category_id', $prod['id'])->get()
        ]
    );
})->middleware('auth');

Route::get('/orders', function () {
    return view('content.orders', ['orders' => Transaction::select('transactions.*','users.name')
        ->join('users', 'transactions.user_id', "=", 'users.id')
        ->orderBy('id', 'desc')->get()]);
})->middleware('auth');

Route::post('/orderstat/{orderid}', function ($orderid, Request $request) {
    $today = Carbon::now();
    $tomorrow = $today->addDay();
    if($request['orderstat'] == "preparing for delivery"){
        Transaction::find($orderid)->update([
            'status' => $request['orderstat']]);
        $orders = Order::where('transaction_id', $orderid)->get();
        foreach ($orders as $ord) {
            $stock = "";
            $stock = ProductCategory::find($ord['product_category_id']);
            $diff = $stock->stock - $ord->qty;
            $stock->update(['stock' => $diff]);
        }
    }
    if($request['orderstat'] == "delivery"){
        Transaction::find($orderid)->update([
            'status' => $request['orderstat'],
            'date_to_deliver' => $tomorrow ]);
        $orders = Order::where('transaction_id', $orderid)->get();
        
        // $forApproval = Transaction::find($orderid)->where('status','for approval')->first();
        // if($forApproval){
        //     Transaction::find($orderid)->update([
        //         'status' => $request['orderstat'],
        //         'date_to_deliver' => $tomorrow ]);
        //     $orders = Order::where('transaction_id', $orderid)->get();
        //     foreach ($orders as $ord) {
        //         $stock = "";
        //         $stock = ProductCategory::find($ord['product_category_id']);
        //         $diff = $stock->stock - $ord->qty;
        //         $stock->update(['stock' => $diff]);
        //     }
        // }
    }else if($request['orderstat'] == "cancel"){
        Transaction::find($orderid)->update(['status' => $request['orderstat']]);
        $orders = Order::where('transaction_id', $orderid)->get();
        foreach ($orders as $ord) {
            $stock = "";
            $stock = ProductCategory::find($ord['product_category_id']);
            $sum = $stock->stock + $ord->qty;
            $stock->update(['stock' => $sum]);
        }

    }else if($request['orderstat'] == "delivered"){
        Transaction::find($orderid)->update([
            'status' => $request['orderstat'],
            'date_delivered' => $today,
        ]);
        
    }else if($request['orderstat'] == "failed"){
        $proven = Transaction::find($orderid)->where('status', 'delivery')->first();
        if($proven){
            Transaction::find($orderid)->update([
                'status' => $request['orderstat'],
                'date_to_deliver' => $tomorrow
            ]);
            return back()->with('message', 'Order Rescheduled successfully on'. $tomorrow);
        }
    }

    return back()->with('message', 'status updated successfully!');
})->middleware('auth');

Route::get('/users', function () {
    return view('content.users', 
    ['users' => User::all()]);
    
})->middleware('auth');

Route::get('/types', function () {
    return view('content.type', ['types' => Type::all()]);
})->middleware('auth');

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
})->middleware('auth');


Route::get('/accounts', function () {
    return view('content.accounts', ['accounts' => Account::all()]);
})->middleware('auth');

Route::get('/editaccount/{item}/edit', function (Account $item) {
    return view('content.editaccount', ['detail' => $item]);
})->middleware('auth');

Route::post('/updateaccount/{account}', function (Account $account, Request $request) {

    $account->update([
        'num' => $request['num'],
    ]);

    return back()->with('message', 'Updated successfully!');
})->middleware('auth');

Route::post('/addaccount', function (Request $request) {
    $formfields = $request->validate([
        'num' => 'string',
    ]);
    Account::create($formfields);
    
    return back()->with('message', 'Added successfully!');
})->middleware('auth');

Route::get('/forapproval', function () {
    return view('content.ondelivery',
     [
        'orders' => Transaction::select('transactions.*','users.name')
        ->join('users', 'transactions.user_id', "=", 'users.id')
        ->where('transactions.status', 'for approval')
        ->orderBy('id', 'desc')->get()
    ]);
})->middleware('auth');
Route::get('/preparing', function () {
    return view('content.ondelivery',
     [
        'orders' => Transaction::select('transactions.*','users.name')
        ->join('users', 'transactions.user_id', "=", 'users.id')
        ->where('transactions.status', 'preparing for delivery')
        ->orderBy('id', 'desc')->get()
    ]);
})->middleware('auth');
Route::get('/ondelivery', function () {
    return view('content.ondelivery',
     [
        'orders' => Transaction::select('transactions.*','users.name')
        ->join('users', 'transactions.user_id', "=", 'users.id')
        ->where('transactions.status', 'delivery')
        ->orderBy('id', 'desc')->get()
    ]);
})->middleware('auth');
Route::get('/delivered', function () {
    return view('content.ondelivery',
     [
        'orders' => Transaction::select('transactions.*','users.name')
        ->join('users', 'transactions.user_id', "=", 'users.id')
        ->where('transactions.status', 'delivered')
        ->orderBy('id', 'desc')->get()
    ]);
})->middleware('auth');

Route::get('/showtype', function(){
    return view('content.addtype');
});

Route::post('/addtype', function(Request $request){
    $isTaken = Type::where('name', $request['name'])->first();
    if ($isTaken) {
        return response(['message' => 'Redundant Category!'], 200);
    }

    $formfields = $request->validate([
        'name' => 'required|string',
    ]);
    $id = Type::create($formfields)->id;

    $params = $request['units'];
    $tags = explode(',', $params);
    $units = array();
    foreach ($tags as $item) {
        if ($item != "" || $item != null) {
            $units = array();
            $units = [
                'type_id' => $id,
                'unit' => trim($item),
            ];
            Unit::create($units);
        }
    }
    if ($units) {
        return back()->with('message', 'Added successfully!');
    }
} );
