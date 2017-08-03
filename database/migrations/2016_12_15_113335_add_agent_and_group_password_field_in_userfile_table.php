<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAgentAndGroupPasswordFieldInUserfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_files',function(Blueprint $table){
            $table->string('agent',50)->default('');
            $table->string('group',50)->default('');
            $table->string('password',50)->default('');
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
        Schema::table('user_files', function ($table) {
            $table->dropColumn(['agent', 'group', 'password']);
        });
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
