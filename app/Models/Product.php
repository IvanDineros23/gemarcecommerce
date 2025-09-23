<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name','slug','sku','price','stock','description','is_active'];

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function firstImagePath()
    {
        $img = $this->images()->orderBy('sort_order')->first();
        return $img ? $img->path : null;
    }
}
