<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        return Order::all();
    }
    public function show($transaction_id)
    {
        return DB::table('orders')
            ->join('product_categories', 'orders.product_category_id', "=", 'product_categories.id')
            ->select('orders.*', 'product_categories.name', 'product_categories.image')
            ->where('transaction_id', $transaction_id)->get();
    }
}
