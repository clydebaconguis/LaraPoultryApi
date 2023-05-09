<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\ProductCategory;
use App\Models\Transaction;
use DateTime;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return Transaction::all();

        return DB::table('transactions')
            ->join('users', 'transactions.user_id', "=", 'users.id')
            ->select('transactions.*', 'users.name')
            ->orderBy('created_at', 'DESC')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $formfields = $request->validate([
            'user_add' => 'required|string',
            'phone' => 'required|string',
            'total_payment' => 'required',
            'payment_opt' => 'required|string',
            'user_id' => 'required',
            'status' => 'string',
        ]);

        $formfields['lat'] = $request->lat;
        $formfields['long'] = $request->long;
        $formfields['trans_code'] = Str::random(10);
        $transaction = Transaction::create($formfields);

        $products = json_decode($request['products'], true);
        foreach ($products as $item) {
            $prod = [
                'product_category_id' => $item['product_category_id'],
                'transaction_id' => $transaction['id'],
                'size' => $item['size'],
                'qty' => $item['qty'],
            ];
            Order::create($prod);
            $prod = array();
        }
        Cart::where('user_id', $formfields['user_id'])->delete();
        $transaction['message'] = 'Success';
        return response($transaction, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show($user_id)
    {
        return Transaction::where('user_id', $user_id)
            ->orderBy('created_at', 'DESC')->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id )
    {
        $formfields = $request->validate([
            'image' => 'image|mimes:jpg,jpeg,png',
            'status' => 'required',
        ]);
        if ($request->hasFile('image')) {
            $filename = Str::random(10);
            $request->file('image')->storeAs('', $filename, 'google');
            $path = Storage::disk('google')->getMetadata($filename);
            $formfields['image'] = $path['path'];
            if($request->payment == "COD"){
                $formfields['proof_of_payment'] = $path['path'];
            }

            Transaction::find($id)->update([   
                'status' => $formfields['status'],
                'date_delivered' => date('Y-m-d H:i:s'),
                'proof_of_delivery' => $$formfields['image'],
                'proof_of_payment' => $$$formfields['proof_of_payment'],
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
