<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocialUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('social_users',function(Blueprint $table){
            $table->bigIncrements('id');
            $table->string('username',255);
            $table->string('first_name',150);
            $table->string('last_name',150);
            $table->string('email')->unique();
            $table->string('avatar');
            $table->string('provider');
            $table->string('provider_id')->unique();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('social_users');
    }
}
