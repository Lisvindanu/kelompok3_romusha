<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasswordResetTokensTable extends Migration
{
    public function up()
    {
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->bigIncrements('id'); // Menambahkan primary key pada id
            $table->dateTime('expires_at', 6); // Kolom expires_at dengan presisi 6
            $table->string('token'); // Kolom token dengan tipe string
            $table->bigInteger('user_id')->unsigned(); // Kolom user_id dengan tipe bigInteger dan unsigned
            $table->foreign('user_id')->references('id')->on('users'); // Foreign key ke tabel users
        });
    }

    public function down()
    {
        Schema::dropIfExists('password_reset_tokens');
    }
}
