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
        Schema::create('payments', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('amount');
            $table->dateTime('canceled_at', 6)->nullable();
            $table->dateTime('confirmed_at', 6)->nullable();
            $table->dateTime('created_at', 6);
            $table->string('reason')->nullable();
            $table->string('status');
            $table->bigInteger('purchase_id')->index('fkojjfjcwuims3swikm1hlaofan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
