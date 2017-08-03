<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewFieldToSiminfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sim_info',function(Blueprint $table){
            $table->string('sim_number',255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::table('sim_info', function ($table) {
            $table->dropColumn(['sim_number']);
        });
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
