<?php

use App\Admin;
use App\Models\GlobalSettings;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();
        if (App::environment() !== 'local') {
            die("In production environment you can not seed the database");
        }



        $truncate = [
            'admin',
        ];
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        foreach ($truncate as $table) {
            DB::table($table)->truncate();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        Admin::create([
            'username' => 'admin',
            'password' => bcrypt('secret')
        ]);
    }
}
