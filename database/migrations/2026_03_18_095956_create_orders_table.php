<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {

            $table->id();
            $table->string('order_id')->unique();

            $table->string('customer_name');
            $table->string('email')->nullable();
            $table->string('phone_no');
            $table->text('address');
            $table->string('pincode')->nullable();

            $table->integer('total_amount');
            $table->enum('payment_type', ['online', 'offline'])->default('offline');
            $table->enum('payment_status', ['pending', 'done'])->default('pending');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
