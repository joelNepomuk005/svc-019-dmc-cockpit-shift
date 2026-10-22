<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerMeasuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_measures', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id');
            $table->string('measure_id');
            $table->string('state');
            $table->date('from');
            $table->date('to');
            $table->boolean('incentivization');
            $table->boolean('coupon');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_measures');
    }
}
