<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_products', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->integer('orders_id')->unsigned();
            $table->integer('quantity');
            $table->foreign('product_id')
                ->references('id')->on('products');
            $table->foreign('orders_id')
                ->references('id')->on('orders');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('orders_products');
    }
}
