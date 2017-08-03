<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewFieldToAddressInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('address_info',function(Blueprint $table){
            $table->string('contact_no',255);
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
        Schema::table('address_info', function ($table) {
            $table->dropColumn(['contact_no']);
        });
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
