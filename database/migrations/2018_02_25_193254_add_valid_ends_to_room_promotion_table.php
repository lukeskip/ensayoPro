<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddValidEndsToRoomPromotionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('room_promotion', function($table) {
            $table->datetime('pivot_valid_ends')->nullable();
            $table->string('pivot_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('room_promotion', function($table) {
            $table->dropColumn('pivot_valid_ends');
            $table->dropColumn('pivot_status');
        });    
    }
}
