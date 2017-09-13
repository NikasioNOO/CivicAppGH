<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyIndexesSocialUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('social_users',function(Blueprint $table)
        {
            $table->dropUnique('social_users_email_unique');
            $table->dropUnique('social_users_provider_id_unique');
            $table->index('email');
            $table->index(['provider_id','provider']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('social_users',function(Blueprint $table)
        {
            $table->dropIndex('social_users_email_index');
            $table->dropIndex('social_users_provider_id_provider_index');
            $table->unique('email');
            $table->unique('provider_id');
        });
    }
}
