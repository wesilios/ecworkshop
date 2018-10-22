<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('address');
            $table->string('district');
            $table->string('city');
            $table->text('note')->nullable();
            $table->integer('totalQty');
            $table->float('totalPrice',10,2);
            $table->string('orderCode');
            $table->integer('customer_id')->index()->default(0);
            $table->integer('extra_customer_id')->index()->default(0);
            $table->integer('order_status_id')->index()->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
