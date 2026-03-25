<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
/*    protected $fillable = [
        'name',
        'phone',
        'address',
        'total',
        'order_id',
        'customer_name',
        'email',
        'phone_no',
        'pincode',
        'payment_type',
        'total_amount',
        'payment_status',
    ];*/
    protected $fillable = [
        'order_id',
        'customer_id',
        'customer_name',
        'email',
        'phone_no',
        'address',
        'pincode',
        'total_amount',
        'payment_type',
        'payment_status'
    ];
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
