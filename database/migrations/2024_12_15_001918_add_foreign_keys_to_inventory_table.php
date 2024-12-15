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
        Schema::table('inventory', function (Blueprint $table) {
            $table->foreign(['user_id'], 'FK6s70ikopm646wy54vwowsnp6d')->references(['id'])->on('users')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['product_id'], 'FKq2yge7ebtfuvwufr6lwfwqy9l')->references(['id'])->on('products')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventory', function (Blueprint $table) {
            $table->dropForeign('FK6s70ikopm646wy54vwowsnp6d');
            $table->dropForeign('FKq2yge7ebtfuvwufr6lwfwqy9l');
        });
    }
};
