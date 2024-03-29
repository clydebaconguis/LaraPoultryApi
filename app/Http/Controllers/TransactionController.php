<?php

namespace App\Http\Controllers;

use DateTime;
use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\Sale;
use App\Models\User;
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
        $today = Carbon::now();
        if ($request->hasFile('image') && $request->status == "delivered") {
            $filename = Str::random(10);
            $request->file('image')->storeAs('', $filename, 'google');
            $path = Storage::disk('google')->getMetadata($filename);
            Transaction::find($request['id'])->update([   
                'status' => $request['status'],
                'date_delivered' => $today,
                'proof_of_delivery' => $path['path'],
                'amount_paid' => $request['amount_paid'],
            ]);
            $user = User::find($request['rider_id']);
            $result = User::find($request['rider_id'])->update(['rider_total_collected' => $user['rider_total_collected'] + $request['amount_paid']]);

            // if($result){
            //     Sale::create([
            //         'rider_id' => $request['rider_id'],
            //         'profit' => $request['amount_paid'],
            //     ]);
            // }
           
            return response()->json(['message' => "Successfully delivered"]);
        }

        if($request->has("purpose") && $request->purpose == "store"){
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

            if ($request->hasFile('image')) {
                $filename = Str::random(10);
                $request->file('image')->storeAs('', $filename, 'google');
                $path = Storage::disk('google')->getMetadata($filename); 
                $formfields['proof_of_payment'] = $path['path'];
            }

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
                Cart::where('user_id', $formfields['user_id'])
                ->where('product_category_id', $item['product_category_id'])
                ->delete();
            }
            $transaction['message'] = 'Success';
            return response($transaction, 201);
        }

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
    public function update(Request $request, $rowId)
    {
        $today = Carbon::now();
        $tomorrow = $today->addDay();
        if(!$request->hasFile('image') && $request['status'] == "failed"){
            Transaction::find($rowId)->update([   
                'status' => $request['status'],
                'date_to_deliver' => $tomorrow,
            ]);

            return response()->json(['message' => "Rescheduled Successfully"]);
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
