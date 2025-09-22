<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    // Relationship to Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
