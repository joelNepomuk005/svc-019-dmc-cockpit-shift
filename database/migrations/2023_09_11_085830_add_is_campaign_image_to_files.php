<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('files', function (Blueprint $table) {
            $table->integer('measure_id')->nullable()->change();
            $table->boolean('is_promotion_package')->nullable()->change();
            $table->boolean('is_measure_image')->nullable()->change();
            $table->boolean('is_campaign_image')->default(false)->after('is_measure_image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('files', function (Blueprint $table) {
            $table->dropColumn('is_campaign_image');
        });
    }
};
