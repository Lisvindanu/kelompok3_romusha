<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('purchase_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id');  // Ubah menjadi unsignedBigInteger
            $table->integer('quantity');
            $table->unsignedBigInteger('purchase_id');  // Ubah menjadi unsignedBigInteger
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('purchase_id')->references('id')->on('purchase');
        });
    }
    

    public function down()
    {
        Schema::dropIfExists('purchase_details');
    }
}
