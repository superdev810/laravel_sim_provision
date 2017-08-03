<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserfileIdFkInsimAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('address_info',function(Blueprint $table){
            $table->integer('file_id')->unsigned();
            $table->foreign('file_id')
                ->references('id')
                ->on('user_files')
                ->onDelete('cascade');

        });


        Schema::table('sim_info',function(Blueprint $table){
            $table->integer('file_id')->unsigned();
            $table->foreign('file_id')
                ->references('id')
                ->on('user_files')
                ->onDelete('cascade');

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
            $table->dropForeign('address_info_file_id_foreign');
        });
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::table('sim_info', function ($table) {
            $table->dropForeign('sim_info_file_id_foreign');
        });
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
