<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQuantityPromotionsToPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function($table) {
            $table->integer('quantity_prom')->nullable()->after('quantity');
            $table->integer('unit_price')->nullable()->after('quantity_prom');
            $table->integer('unit_price_prom')->nullable()->after('unit_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payments', function($table) {
            $table->dropColumn('quantity_prom');
        });
    }
}
