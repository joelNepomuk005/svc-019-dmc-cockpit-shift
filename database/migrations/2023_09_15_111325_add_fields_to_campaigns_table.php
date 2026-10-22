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
        Schema::table('campaigns', function (Blueprint $table) {
            $table->string('title', 55)->nullable()->after('name');
            $table->string('subheadline', 110)->nullable()->after('title');
            $table->text('link')->nullable()->after('subheadline');
            $table->string('prefix')->nullable()->unique()->after('link');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('subheadline');
            $table->dropColumn('link');
        });
    }
};
