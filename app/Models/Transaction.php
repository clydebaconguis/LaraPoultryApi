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
        'total_payment',
        'payment_opt',
        'user_id',
        'status',
    ];

    protected $table = 'CreateTransactionsTable.transactions';

    // public function orders()
    // {
    //     return $this->hasMany(Orders::class, 'transaction_id');
    // }
}
