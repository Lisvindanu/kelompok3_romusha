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
        Schema::create('otp_token', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->dateTime('expires_at', 6)->nullable();
            $table->string('otp')->nullable();
            $table->bigInteger('user_id')->nullable();

            $table->unique(['user_id', 'otp'], 'ukjo6dcptokd4wslvipwkiw8aid');
            $table->unique(['user_id', 'otp'], 'ukp95e57dijmnw22xv6hiypih4g');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otp_token');
    }
};
