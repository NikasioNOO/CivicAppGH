<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts',function(Blueprint $table){
            $table->bigIncrements('id');
            $table->string('comment');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('map_item_id');
            $table->unsignedSmallInteger('status_id')->nullable();
            $table->unsignedSmallInteger('post_type_id');
            $table->foreign('user_id')->references('id')->on('social_users');
            $table->foreign('map_item_id')->references('id')->on('map_items');
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->foreign('post_type_id')->references('id')->on('post_types');
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
        Schema::drop('posts');
    }
}
