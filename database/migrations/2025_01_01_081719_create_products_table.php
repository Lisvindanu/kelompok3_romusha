<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id'); // Menambahkan primary key pada id
            $table->dateTime('created_at', 6); // Kolom created_at dengan tipe dateTime
            $table->string('name'); // Kolom name dengan tipe string
            $table->bigInteger('price'); // Kolom price dengan tipe bigInteger
            $table->integer('quantity'); // Kolom quantity dengan tipe integer
            $table->dateTime('updated_at', 6); // Kolom updated_at dengan tipe dateTime
            $table->bigInteger('category_id')->unsigned(); // Kolom category_id dengan tipe bigInteger dan unsigned
            $table->bigInteger('genre_id')->unsigned()->nullable(); // Kolom genre_id dengan tipe bigInteger, unsigned, dan nullable
            $table->string('image_url')->nullable(); // Kolom image_url dengan tipe string dan nullable
            $table->text('description')->nullable(); // Kolom description dengan tipe text dan nullable
            $table->text('specifications')->nullable(); // Kolom specifications dengan tipe text dan nullable
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade'); // Foreign key ke tabel categories
            $table->foreign('genre_id')->references('id')->on('genres')->onDelete('set null'); // Foreign key ke tabel genres
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
