<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionsTable extends Migration
{
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // Kolom id dengan tipe string sebagai primary key
            $table->bigInteger('user_id')->unsigned()->nullable(); // Kolom user_id dengan tipe bigInteger yang dapat bernilai null
            $table->string('ip_address', 45)->nullable(); // Kolom ip_address dengan tipe string sepanjang 45 karakter
            $table->text('user_agent')->nullable(); // Kolom user_agent dengan tipe text
            $table->longText('payload'); // Kolom payload dengan tipe longText
            $table->integer('last_activity'); // Kolom last_activity dengan tipe integer
        });
    }

    public function down()
    {
        Schema::dropIfExists('sessions');
    }
}
