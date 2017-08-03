<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddResponseCodeAndRetryFieldInReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reports',function(Blueprint $table){
            $table->string('response_code')->default('');
            $table->tinyInteger('retry')->default(0);
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
        Schema::table('reports', function ($table) {
            $table->dropColumn(['process_flag', 'process_date','response_code', 'retry']);
        });
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
