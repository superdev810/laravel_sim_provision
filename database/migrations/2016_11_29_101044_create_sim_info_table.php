<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSimInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sim_info',function(Blueprint $table){
            $table->increments('id');
            $table->string('network');
            $table->string('existing_new_subscribe');
            $table->string('sim_stater_pack');
            $table->string('last_4_digit_of_sim');
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::drop('sim_info');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
