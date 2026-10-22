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
        Schema::create('measures', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('from');
            $table->date('to');
            $table->boolean('incentivization')->default(0);
            $table->json('customer_ids')->nullable();
            $table->boolean('coupons')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('measures');
    }
};
