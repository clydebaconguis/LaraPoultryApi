<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'transaction_id',
        'product_category_id',
        'size',
        'qty',
    ];

    public function transactions()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }
}
