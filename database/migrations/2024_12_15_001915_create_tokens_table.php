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
        Schema::create('tokens', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->dateTime('expires_at', 6);
            $table->string('token')->unique('ukna3v9f8s7ucnj16tylrs822qj');
            $table->string('username');
            $table->bigInteger('user_id')->index('fk2dylsfo39lgjyqml2tbe0b0ss');
            $table->string('sub')->nullable()->unique('ukdh3mmlp0osglrb2btpcaxa9co');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tokens');
    }
};
