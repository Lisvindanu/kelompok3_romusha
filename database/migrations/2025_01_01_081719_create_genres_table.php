<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGenresTable extends Migration
{
    public function up()
    {
        Schema::create('genres', function (Blueprint $table) {
            $table->bigIncrements('id'); // Primary key, auto increment
            $table->string('name'); // Kolom nama genre
            $table->bigInteger('category_id')->unsigned(); // Pastikan unsigned untuk konsistensi dengan bigIncrements
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade'); // Foreign key ke tabel categories
            $table->timestamps(); // created_at, updated_at
        });
    }
    

    public function down()
    {
        Schema::dropIfExists('genres');
    }
}
