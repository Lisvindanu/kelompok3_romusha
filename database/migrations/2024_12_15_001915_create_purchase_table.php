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
        Schema::create('purchase', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->dateTime('created_at', 6);
            $table->integer('quantity');
            $table->bigInteger('total_price');
            $table->bigInteger('product_id')->index('fksfqpk5xjv93po29vn4fmy5exq');
            $table->bigInteger('user_id')->index('fkoj7ky1v8cf4ibkk0s7alikp52');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase');
    }
};
