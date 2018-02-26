<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnsInCompaniesToNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
        Schema::table('companies', function($table) {
            $table->string('clabe')->nullable()->change();
            $table->string('bank')->nullable()->change();
            $table->string('account_holder')->nullable()->change();
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
            $table->string('clabe')->nullable(false)->change();
            $table->string('bank')->nullable(false)->change();
            $table->string('account_holder')->nullable(false)->change();
        });
    }
}
