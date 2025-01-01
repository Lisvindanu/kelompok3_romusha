<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('username')->nullable();
            $table->string('google_id')->nullable();
            $table->boolean('is_otp_verified')->nullable();
            $table->string('role')->nullable();
            $table->string('fullname')->nullable();
            $table->string('image_url')->nullable();
            $table->string('uuid')->nullable();
            $table->string('alamat')->nullable();
            $table->string('nomer_hp')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
