<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('company_id');
            $table->datetime('valid_starts');
            $table->datetime('valid_ends');
            $table->integer('hours')->nullable();
            $table->integer('schedule_starts')->nullable();
            $table->integer('schedule_ends')->nullable();
            $table->enum('type', ['direct', 'percentage','hour_price']);
            $table->enum('status', ['draft', 'published']);
            $table->integer('value');
            $table->enum('rule', ['hours', 'schedule']);
            $table->integer('min_hours')->nullable();
            $table->string('days')->nullable();
            $table->datetime('starts')->nullable();
            $table->datetime('ends')->nullable();
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
        Schema::dropIfExists('promotions');
    }
}
