<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'carts';
    protected $fillable = ['user_id', 'product_id', 'quantity'];

    public function product(): HasOne
    {;
        return $this->hasOne('App\Models\Product', 'id', 'product_id')->latest();
    }
}
