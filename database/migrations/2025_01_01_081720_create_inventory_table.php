<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryTable extends Migration
{
    public function up()
    {
        Schema::create('inventory', function (Blueprint $table) {
            $table->bigIncrements('id'); // Menambahkan primary key pada id
            $table->dateTime('last_updated', 6); // Kolom untuk last_updated dengan presisi 6
            $table->integer('quantity'); // Kolom untuk quantity
            $table->bigInteger('product_id')->unsigned(); // Kolom untuk product_id dengan tipe bigInteger dan unsigned
            $table->bigInteger('user_id')->unsigned(); // Kolom untuk user_id dengan tipe bigInteger dan unsigned
            $table->timestamps(); // Kolom created_at dan updated_at
            $table->enum('status', ['pending', 'canceled', 'progress', 'completed'])->default('pending'); // Kolom status dengan nilai enum
            $table->string('reason')->nullable(); // Kolom reason yang nullable
            $table->foreign('product_id')->references('id')->on('products'); // Foreign key ke tabel products
            $table->foreign('user_id')->references('id')->on('users'); // Foreign key ke tabel users
        });
    }
    
    
    

    public function down()
    {
        Schema::dropIfExists('inventory');
    }
}
