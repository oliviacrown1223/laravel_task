<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'name','code','usage_limit','used_count','expiry_date','type','discount'
    ];
}
