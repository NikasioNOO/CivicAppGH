<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnNroExpedienteMapItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('map_items',function(Blueprint $table)
        {
            $table->string('nro_expediente',50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('map_items',function(Blueprint $table)
        {
            $table->dropColumn('nro_expediente');
        });
    }
}
