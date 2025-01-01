<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id'); // Primary key, auto increment
            $table->string('name')->unique(); // Nama kategori
            $table->timestamps(); // created_at, updated_at
        });
    }
    
    

    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
