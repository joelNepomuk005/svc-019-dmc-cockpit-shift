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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->json('images')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->timestamps();
        });

        Schema::create('campaign_participants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('campaign_id');
            $table->unsignedBigInteger('customer_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('campaign_id')->references('id')->on('campaigns');
            $table->foreign('customer_id')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaign_participants');
        Schema::dropIfExists('campaigns');
    }
};
