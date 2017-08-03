<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewFieldMessage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sim_info',function(Blueprint $table){
            $table->text('message')->default('');
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
            $table->dropColumn(['message']);
        });

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
