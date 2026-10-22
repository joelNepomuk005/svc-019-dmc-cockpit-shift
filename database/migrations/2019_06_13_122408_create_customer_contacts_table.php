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
        Schema::create('customer_contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->integer('customer_id');
            $table->integer('contact_type_id');
            $table->integer('contact_person_id');
            $table->integer('user_id');
            $table->integer('user_id_log');
            $table->date('date');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_contacts');
    }
};
