<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewFieldInSiminfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sim_info',function(Blueprint $table){
            $table->tinyInteger('process_flag');
            $table->dateTime('process_date');
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
            $table->dropColumn(['process_flag', 'process_date']);
        });
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
