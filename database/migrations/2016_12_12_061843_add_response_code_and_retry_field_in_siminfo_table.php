<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddResponseCodeAndRetryFieldInSiminfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sim_info',function(Blueprint $table){
            $table->string('response_code')->default('');
            $table->tinyInteger('retry')->default(0);
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
            $table->dropColumn(['response_code', 'retry']);
        });
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
