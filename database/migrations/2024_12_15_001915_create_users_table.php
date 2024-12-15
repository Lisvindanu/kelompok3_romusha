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
        Schema::create('users', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->dateTime('created_at', 6)->nullable();
            $table->string('email');
            $table->string('password')->nullable();
            $table->string('username')->nullable()->unique('ukr43af9ap4edm43mmtq01oddj6');
            $table->string('google_id')->nullable();
            $table->boolean('is_otp_verified')->nullable();
            $table->string('role')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
