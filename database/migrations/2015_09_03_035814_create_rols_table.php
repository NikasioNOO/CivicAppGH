<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use CivicApp\Models\Auth\Role;

class CreateRolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('role_name',255);
            $table->timestamps();
        });

        Role::create(['role_name'=>'Admin']);
        Role::create(['role_name'=>'Viewer']);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('roles');
    }
}
