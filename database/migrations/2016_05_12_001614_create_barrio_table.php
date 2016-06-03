<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBarrioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barrios',function(Blueprint $table){
            $table->increments('id');
            $table->string('name',300);
            $table->unsignedBigInteger('geo_point_id')->nullable();
            $table->foreign('geo_point_id')->references('id')->on('geo_points');
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
        Schema::drop('barrios');
    }
}
