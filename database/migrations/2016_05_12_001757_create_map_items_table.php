<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMapItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('map_items',function(Blueprint $table){
            $table->bigIncrements('id');
            $table->smallInteger('year',false,true);
            $table->string('description',1000);
            $table->string('address',1000)->nullable();
            $table->float('budget');
            $table->unsignedInteger('cpc_id')->nullable();
            $table->unsignedInteger('barrio_id')->nullable();
            $table->unsignedSmallInteger('category_id')->nullable();
            $table->unsignedSmallInteger('status_id')->nullable();
            $table->unsignedSmallInteger('map_item_type_id');
            $table->unsignedBigInteger('geo_point_id')->nullable();
            $table->timestamps();
            $table->foreign('cpc_id')->references('id')->on('cpc');
            $table->foreign('barrio_id')->references('id')->on('barrios');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->foreign('map_item_type_id')->references('id')->on('map_item_types');
            $table->foreign('geo_point_id')->references('id')->on('geo_points');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('map_items');
    }
}
