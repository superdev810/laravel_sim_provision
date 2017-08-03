<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('address_info',function(Blueprint $table){
            $table->increments('id');
            $table->string('full_name');
            $table->string('sumame');
            $table->string('indentification_type');
            $table->string('id_nationality');
            $table->string('id_number');
            $table->string('password_number');
            $table->string('address_1');
            $table->string('city_town');
            $table->string('country');
            $table->string('suburb');
            $table->string('postal_code');
            $table->string('proof_of_address');
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
        Schema::drop('address_info');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
