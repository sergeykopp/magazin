<?php

use Illuminate\Database\Seeder;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $prefix = config('database.connections.' . config('database.default') . '.prefix');

        DB::insert("insert into " . $prefix . "role_user (user_id, role_id) values (1, 1)");
    }
}
