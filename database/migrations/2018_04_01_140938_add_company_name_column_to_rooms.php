<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompanyNameColumnToRooms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rooms', function($table) {
            $table->string('company_name')->nullable()->after("name");
            $table->boolean('is_admin')->nullable()->after("company_name");
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
            $table->dropColumn('company_name');
            $table->dropColumn('is_admin');
        });
    }
}
