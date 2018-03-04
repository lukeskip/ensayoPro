<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddContactFieldsToCompaniesTabla extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function($table) {
            $table->string('contact_phones')->nullable()->after("name");
            $table->string('webpage')->nullable()->after("contact_phones");
            $table->string('facebook')->nullable()->after("facebook");
        });    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function($table) {
            $table->dropColumn('contact_phones');
            $table->dropColumn('webpage');
            $table->dropColumn('facebook');
        });
    }
}
