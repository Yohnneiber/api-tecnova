<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->increments('id');
            $table->string('name',100);
            $table->text('description');
            $table->float('price');
            $table->string('status',20);
            $table->integer('stock');
            $table->string('image')->nullable();
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')
                ->references('id')->on('categories');
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
        Schema::dropIfExists('products');
    }
}
