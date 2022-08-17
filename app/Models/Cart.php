<?php

namespace App\Models;

use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'product_category_id',
        'size',
        'tray',
        'total',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
