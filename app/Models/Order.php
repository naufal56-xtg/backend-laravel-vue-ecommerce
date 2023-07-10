<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['no_pesanan', 'qty', 'status', 'total', 'user_id'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
