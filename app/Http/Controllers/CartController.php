<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\ProductCategory;
use Database\Factories\ProductFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Cart::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'product_category_id' => 'required',
        ]);
        $isExist = Cart::where('user_id', $request['user_id'])->where('product_category_id', $request['product_category_id'])->first();
        $newTray = $isExist['tray'] += $request['tray'];
        $newTotal = $isExist['total'] += $request['total'];
        if($isExist){
            Cart::where('user_id', $request['user_id'])->where('product_category_id', $request['product_category_id'])
            ->update(
                [
                'tray' => $newTray,
                'total'=> $newTotal,
            ]);
            return response()->json(['message' => 'success']);
        }
        return Cart::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return DB::table('carts')
            ->join('product_categories', 'carts.product_category_id', "=", 'product_categories.id')
            ->select('carts.*', 'product_categories.name', 'product_categories.image', 'product_categories.stock')
            ->where('user_id', $id)->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rowCart = Cart::where('user_id', $id)->where('product_category_id', $request['product_id'])->first();
        if($rowCart->tray > 1){
            Cart::where('user_id', $id)->where('product_category_id', $request['product_id'])
            ->update(['tray' => $request['tray'], 'total' => $request['total']]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        Cart::where('user_id', $id)->where('product_category_id', $request['product_id'])->delete();
    }
}
