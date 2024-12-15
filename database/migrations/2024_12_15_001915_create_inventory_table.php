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
        Schema::create('inventory', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->dateTime('last_updated', 6);
            $table->integer('quantity');
            $table->bigInteger('product_id')->index('fkq2yge7ebtfuvwufr6lwfwqy9l');
            $table->bigInteger('user_id')->index('fk6s70ikopm646wy54vwowsnp6d');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory');
    }
};
