<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'trans_code',
        'user_add',
        'phone',
        'total_payment',
        'payment_opt',
        'user_id',
        'status',
        'lat',
        'long',
        'date_delivered',
        'date_to_deliver',
        'proof_of_delivery',
        'proof_of_payment',
        'amount_paid',
        'rider_id',
        
    ];

    protected $table = 'transactions';

    public function orders()
    {
        return $this->hasMany(Orders::class, 'transaction_id');
    }
}
