<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCashbackFieldsToCustomerMeasuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_measures', function (Blueprint $table) {
            $table->integer('cashback')->nullable()->after('incentivization');
            $table->boolean('cashback_unlimited')->nullable()->after('incentivization');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('measures', function (Blueprint $table) {
            //
        });
    }
}
