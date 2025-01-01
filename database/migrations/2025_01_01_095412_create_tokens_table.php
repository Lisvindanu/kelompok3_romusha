<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTokensTable extends Migration
{
    public function up()
    {
        Schema::create('tokens', function (Blueprint $table) {
            $table->bigIncrements('id'); // Kolom id sebagai primary key
            $table->dateTime('expires_at', 6); // Kolom expires_at dengan tipe datetime dan presisi 6
            $table->string('token', 255); // Kolom token dengan tipe string sepanjang 255 karakter
            $table->string('username', 255); // Kolom username dengan tipe string sepanjang 255 karakter
            $table->bigInteger('user_id'); // Kolom user_id dengan tipe bigInteger
            $table->string('sub', 255)->nullable(); // Kolom sub dengan tipe string sepanjang 255 karakter, nullable
            $table->tinyInteger('is_logged_in')->default(1); // Kolom is_logged_in dengan tipe tinyInteger dan nilai default 1
        });
    }

    public function down()
    {
        Schema::dropIfExists('tokens');
    }
}
