<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_budgets', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->float('amount');
            $table->string('note');
            $table->integer('user_id');
            $table->integer('measure_id')->nullable();
            $table->string('budget_type');
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
        Schema::dropIfExists('customer_budgets');
    }
}
