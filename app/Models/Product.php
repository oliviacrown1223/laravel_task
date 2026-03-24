<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /*protected $fillable = [
        'name',
        'image',
        'price'
    ];*/
    protected $fillable = [
        'name','price','listed_price','description','brands','categories','image'
    ];

    // Brand relationship
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brands');
    }

    // Category relationship
    public function category()
    {
        return $this->belongsTo(Category::class, 'categories');
    }
}
