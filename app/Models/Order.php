<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'reference_number',
        'status',
        'subtotal_amount',
        'shipping_amount',
        'tax_amount',
        'total_amount',
        'ship_to_name',
        'ship_to_address',
        'notes',
        'created_at',
        'updated_at',
    ];
    // Relationship: Order has many OrderItems
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
