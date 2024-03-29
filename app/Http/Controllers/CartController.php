<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use Database\Factories\ProductFactory;

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
        try{
            $request->validate([
                'user_id' => 'required',
                'product_category_id' => 'required',
            ]);
            $isExist = Cart::where('user_id', $request['user_id'])->where('product_category_id', $request['product_category_id'])->first();
            if($isExist){
                $stock = ProductCategory::where('id', $request['product_category_id'])->get();
                $newTray = $isExist['tray'] += $request['tray'];
                $newTotal = $isExist['total'] += $request['total'];
                if($newTray <= $stock[0]['stock']){
                    Cart::where('user_id', $request['user_id'])->where('product_category_id', $request['product_category_id'])
                    ->update(
                        [
                        'tray' => $newTray,
                        'total'=> $newTotal,
                    ]);
                    return response()->json(['message' => 'success']);
                }
                return response()->json(['message' => 'You have reach stock limit']);
            }
            Cart::create($request->all());
            return response()->json(['message' => 'success']);
        }catch(Exception $e){
            return response()->json(['message' => 'fail'.$e]);
        }
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
        Cart::where('user_id', $id)->where('product_category_id', $request['product_id'])
            ->update([
                'tray' => $request['tray'], 
                'total' => $request['total'],
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Cart::where('user_id', $id)
        // ->where('product_category_id', $request['product_id'])
        // ->delete;
        // return response()->json(['message' => 'Deleted']);
    }
}
