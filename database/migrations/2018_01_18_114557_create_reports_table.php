<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->string('user_comissions');
            $table->string('company_comissions');
            $table->string('company_incomings');
            $table->string('admin_incomings');
            $table->string('hours');
            $table->string('hours_prom');
            $table->dateTime('period_starts');
            $table->dateTime('period_ends');
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
        Schema::dropIfExists('reports');
    }
}
