<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseTable extends Migration
{
    public function up()
    {
        Schema::create('purchase', function (Blueprint $table) {
            $table->bigIncrements('id'); // Kolom id dengan tipe bigIncrements untuk auto increment
            $table->timestamps(); // Kolom created_at dan updated_at otomatis
            $table->integer('quantity'); // Kolom quantity dengan tipe integer
            $table->bigInteger('total_price'); // Kolom total_price dengan tipe bigInteger
            $table->bigInteger('product_id')->unsigned(); // Kolom product_id dengan tipe bigInteger dan unsigned
            $table->bigInteger('user_id')->unsigned(); // Kolom user_id dengan tipe bigInteger dan unsigned
            $table->foreign('product_id')->references('id')->on('products'); // Foreign key ke tabel products
            $table->foreign('user_id')->references('id')->on('users'); // Foreign key ke tabel users
        });
    }
    

    public function down()
    {
        Schema::dropIfExists('purchase');
    }
}
