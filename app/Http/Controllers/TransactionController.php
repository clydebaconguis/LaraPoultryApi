<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Transaction::all();
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
            'total_payment' => 'required',
            'payment_opt' => 'required|string',
            'user_id' => 'required',
            'status' => 'string',
        ]);

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
    public function show($id)
    {
        return Transaction::where('user_id', $id)->get();

        // return DB::table('orders')
        //     ->join('product_categories', 'orders.product_category_id', "=", 'product_categries.id')
        //     ->select('orders.*', 'product_categories.name', 'product_categories.image')
        //     ->where('transaction_id', $transac['id'])->get();

        // return DB::table('orders')
        //     ->join('transactions', 'orders.transaction_id', "=", 'transactions.id')
        //     ->join('product_categories', 'orders.product_category_id', "=", 'product_categories.id')
        //     ->select('orders.*', 'transactions.*', 'product_categories.image', 'product_categories.name')
        //     ->where('user_id', $id)->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
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
