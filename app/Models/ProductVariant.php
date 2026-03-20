<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariant extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id',
        'value_id',
        'stock',
        'minStock'
    ];
    public function value()
    {
        return $this->belongsTo(VariantsValue::class, 'value_id');
    }
    /**
     * Get the product associated with the product variant.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the variant value associated with the product variant.
     */


    public function variantValue()
    {
        return $this->belongsTo(VariantsValue::class, 'value_id', 'id');
    }
}

