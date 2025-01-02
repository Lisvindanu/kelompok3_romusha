<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id'); // Menambahkan primary key pada id
            $table->bigInteger('amount'); // Kolom amount dengan tipe bigInteger
            $table->dateTime('canceled_at', 6)->nullable(); // Kolom canceled_at dengan tipe dateTime dan nullable
            $table->dateTime('confirmed_at', 6)->nullable(); // Kolom confirmed_at dengan tipe dateTime dan nullable
            $table->dateTime('created_at', 6); // Kolom created_at dengan tipe dateTime
            $table->string('reason')->nullable(); // Kolom reason dengan tipe string dan nullable
            $table->string('status'); // Kolom status dengan tipe string
            $table->bigInteger('purchase_id')->unsigned(); // Kolom purchase_id dengan tipe bigInteger dan unsigned
            $table->foreign('purchase_id')->references('id')->on('purchase'); // Foreign key ke tabel purchase
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
