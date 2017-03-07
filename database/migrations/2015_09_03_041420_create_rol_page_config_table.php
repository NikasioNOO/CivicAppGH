<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolPageConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_pages_config',function(Blueprint $table){
            $table->unsignedInteger('page_config_id');
            $table->unsignedInteger('role_id');
            $table->primary(['page_config_id','role_id']);
            $table->foreign('page_config_id')
                ->references('id')
                ->on('page_configs');
            $table->foreign('role_id')
                ->references('id')
                ->on('roles');


        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('role_pages_config');
    }
}
