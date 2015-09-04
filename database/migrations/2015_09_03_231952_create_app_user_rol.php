<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppUserRol extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('app_user_role',function(Blueprint $table){
            $table->unsignedBigInteger('app_user_id');
            $table->unsignedInteger('role_id');
            $table->primary(['app_user_id','role_id']);
            $table->foreign('app_user_id')->references('id')->on('app_users');
            $table->foreign('role_id')->references('id')->on('roles');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('app_user_role');
    }
}
