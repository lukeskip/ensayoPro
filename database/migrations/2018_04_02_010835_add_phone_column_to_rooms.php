<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPhoneColumnToRooms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rooms', function($table) {
            $table->string('phone')->nullable()->after("city");
            $table->string('webpage')->nullable()->after("phone");
            $table->string('facebook')->nullable()->after("webpage");
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rooms', function($table) {
            $table->dropColumn('phone');
            $table->dropColumn('webpage');
            $table->dropColumn('facebook');

        });
    }
}
