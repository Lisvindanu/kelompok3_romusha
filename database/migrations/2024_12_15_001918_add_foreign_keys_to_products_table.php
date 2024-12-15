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
        Schema::table('products', function (Blueprint $table) {
            $table->foreign(['genre_id'], 'FK1w6wsbg6w189oop2bl38v0hjk')->references(['id'])->on('genres')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['category_id'], 'FKog2rp4qthbtt2lfyhfo32lsw9')->references(['id'])->on('categories')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('FK1w6wsbg6w189oop2bl38v0hjk');
            $table->dropForeign('FKog2rp4qthbtt2lfyhfo32lsw9');
        });
    }
};
