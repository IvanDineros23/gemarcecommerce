<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'name',
        'qty',
        'unit_price',
        'line_total',
    ];

    // Relationship to Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
