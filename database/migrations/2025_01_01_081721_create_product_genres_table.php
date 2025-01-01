<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductGenresTable extends Migration
{
    public function up()
    {
        Schema::create('product_genres', function (Blueprint $table) {
            $table->bigInteger('product_id')->unsigned(); // Kolom product_id dengan tipe bigInteger dan unsigned
            $table->bigInteger('genre_id')->unsigned(); // Kolom genre_id dengan tipe bigInteger dan unsigned
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade'); // Foreign key ke tabel products
            $table->foreign('genre_id')->references('id')->on('genres')->onDelete('cascade'); // Foreign key ke tabel genres
            $table->primary(['product_id', 'genre_id']); // Menetapkan kombinasi product_id dan genre_id sebagai primary key
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_genres');
    }
}
