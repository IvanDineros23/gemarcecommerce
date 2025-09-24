<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavedList extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'description',
    ];
}
