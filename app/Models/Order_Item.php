<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_Item extends Model
{
    use HasFactory;

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }
}
