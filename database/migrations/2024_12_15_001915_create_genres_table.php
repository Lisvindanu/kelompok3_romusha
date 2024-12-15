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
        Schema::create('genres', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('name')->unique('ukpe1a9woik1k97l87cieguyhh4');
            $table->bigInteger('category_id')->index('fk7sykxw6ipq2yr9y232oya5djp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('genres');
    }
};
