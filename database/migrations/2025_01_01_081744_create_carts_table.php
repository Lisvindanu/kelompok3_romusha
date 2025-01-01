<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('user_id')->unsigned(); // Tambahkan `unsigned()`
            $table->bigInteger('product_id')->unsigned(); // Tambahkan `unsigned()`
            $table->integer('quantity');
            $table->string('status')->default('active');
            $table->timestamps();
    
            // Relasi dengan tabel users dan products
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }
    

    public function down()
    {
        Schema::dropIfExists('carts');
    }
}
