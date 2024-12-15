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
        Schema::table('purchase', function (Blueprint $table) {
            $table->foreign(['user_id'], 'FKoj7ky1v8cf4ibkk0s7alikp52')->references(['id'])->on('users')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['product_id'], 'FKsfqpk5xjv93po29vn4fmy5exq')->references(['id'])->on('products')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase', function (Blueprint $table) {
            $table->dropForeign('FKoj7ky1v8cf4ibkk0s7alikp52');
            $table->dropForeign('FKsfqpk5xjv93po29vn4fmy5exq');
        });
    }
};
