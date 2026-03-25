<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name', 'phone', 'email', 'password'];
    public function orders()
    {
        return $this->hasMany(\App\Models\Order::class, 'customer_id');
    }
}
