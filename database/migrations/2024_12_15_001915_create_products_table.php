<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->dateTime('created_at', 6);
            $table->string('name');
            $table->bigInteger('price');
            $table->integer('quantity');
            $table->dateTime('updated_at', 6);
            $table->bigInteger('category_id')->index('fkog2rp4qthbtt2lfyhfo32lsw9');
            $table->bigInteger('genre_id')->nullable()->index('fk1w6wsbg6w189oop2bl38v0hjk');
            $table->string('image_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
