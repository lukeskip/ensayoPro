<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->boolean('company_address');
            $table->string('address')->nullable();
            $table->string('colony')->nullable();
            $table->string('deputation')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('city')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('price');
            $table->string('description');
            $table->longText('equipment');
            $table->string('days');
            $table->string('schedule_start');
            $table->string('schedule_end');
            $table->integer('company_id');
            $table->string('color');
            $table->enum('status', ['active', 'inactive','deleted']);
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
        Schema::dropIfExists('rooms');
    }
}
