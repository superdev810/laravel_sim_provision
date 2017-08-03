<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewFieldToReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports',function(Blueprint $table){
            $table->increments('id');
            $table->integer('address_id')->unsigned();
            $table->foreign('address_id')
                    ->references('id')
                    ->on('address_info')
                    ->onDelete('cascade');
            $table->string('network');
            $table->string('existing_new_subscribe');
            $table->string('sim_stater_pack');
            $table->string('last_4_digit_of_sim');
            $table->string('sim_number',255);
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
        Schema::drop('reports');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
