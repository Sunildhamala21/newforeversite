<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@test.com',
            'role_id' => '1',
            'password' => bcrypt('test123'),
        ]);
    }
}
