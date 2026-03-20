<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VariantsValue extends Model
{
    protected $table = 'variant_values'; // ✅ FIX

    protected $fillable = ['option_id','value'];

    public function option()
    {
        return $this->belongsTo(VariantsOption::class,'option_id');
    }
}
