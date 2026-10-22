<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('scockpit_user_id');
            $table->string('name');
            $table->string('job_title');
            $table->string('sex')->nullable();
            $table->string('salutation')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->date('verified_at')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobil_phone')->nullable();
            $table->bigInteger('categorie_id')->nullable();
            $table->string('api_token')->nullable();
            $table->integer('customer_id')->nullable();
            $table->timestamp('lastlogon_at')->nullable();
            $table->rememberToken();
            $table->string('password')->nullable();
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
        Schema::dropIfExists('users');
    }
}
