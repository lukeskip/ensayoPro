<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->index();
            $table->datetime('starts');
            $table->datetime('ends');
            $table->string('description')->nullable();
            $table->string('price')->nullable();
            $table->integer('room_id');
            $table->integer('user_id');
            $table->integer('band_id')->nullable();
            $table->integer('payment_id')->nullable();
            $table->boolean('is_admin');
            $table->boolean('updated')->default(false);
            $table->enum('status', ['confirmed', 'pending','cancelled']);
            $table->softDeletes();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
