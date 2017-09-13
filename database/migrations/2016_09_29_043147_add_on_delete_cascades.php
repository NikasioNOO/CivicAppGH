<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOnDeleteCascades extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('posts',function(Blueprint $table){
            $table->dropForeign('posts_map_item_id_foreign');
            $table->foreign('map_item_id')->references('id')->on('map_items')->onDelete('cascade');
        });

        Schema::table('post_markers',function(Blueprint $table){
            $table->dropForeign('post_markers_post_id_foreign');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');

        });

        Schema::table('post_complaints',function(Blueprint $table){
            $table->dropForeign('post_complaints_post_id_foreign');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');

        });

        Schema::table('photos',function(Blueprint $table){
            $table->dropForeign('photos_post_id_foreign');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
