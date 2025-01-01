<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtpTokenTable extends Migration
{
    public function up()
    {
        Schema::create('otp_token', function (Blueprint $table) {
            $table->bigIncrements('id'); // Menambahkan primary key pada id
            $table->dateTime('expires_at', 6)->nullable(); // Kolom expires_at dengan presisi 6 dan nullable
            $table->string('otp')->nullable(); // Kolom otp yang nullable
            $table->bigInteger('user_id')->unsigned()->nullable(); // Kolom user_id yang nullable dan unsigned
            $table->foreign('user_id')->references('id')->on('users'); // Foreign key ke tabel users
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('otp_token');
    }
}
