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
            $table->increments('id');
            $table->string('productid');
            $table->string('groupid');
            $table->double('stockqty');
            $table->double('price');
            $table->boolean('newproduct');
            $table->boolean('featureproduct');
            $table->boolean('slideproduct');
            $table->string('image');
            $table->timestamps();
            $table->double('discount');
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
