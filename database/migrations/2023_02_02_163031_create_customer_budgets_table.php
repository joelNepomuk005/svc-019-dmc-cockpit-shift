<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
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
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_budgets');
    }
};
