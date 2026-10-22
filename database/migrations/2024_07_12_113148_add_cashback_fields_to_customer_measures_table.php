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
        Schema::table('customer_measures', function (Blueprint $table) {
            $table->integer('cashback')->nullable()->after('incentivization');
            $table->boolean('cashback_unlimited')->nullable()->after('incentivization');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('measures', function (Blueprint $table) {
            //
        });
    }
};
