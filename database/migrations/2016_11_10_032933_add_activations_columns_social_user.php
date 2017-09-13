<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddActivationsColumnsSocialUser extends Migration
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
            $table->string('activation_code')->nullable()->after('password');
            $table->boolean('activated')->default(0)->after('password');
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
            $table->dropColumn('activation_code');
            $table->dropColumn('activated');
        });
    }
}
