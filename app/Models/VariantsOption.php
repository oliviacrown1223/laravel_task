<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VariantsOption extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['name','user_id'];

    public function values()
    {
        return $this->hasMany(VariantsValue::class, 'option_id');
    }
    public function variantValues()
    {
        return $this->hasMany(VariantsValue::class, 'option_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}
