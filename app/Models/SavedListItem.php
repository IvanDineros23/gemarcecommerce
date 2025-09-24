<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedListItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'saved_list_id',
        'product_id',
    ];

    public function savedList()
    {
        return $this->belongsTo(SavedList::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
