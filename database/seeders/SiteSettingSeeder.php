<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\SiteSetting::insert([
            ['name' => 'site_name', 'value' => ''],
            ['name' => 'telephone', 'value' => ''],
            ['name' => 'mobile1', 'value' => ''],
            ['name' => 'mobile2', 'value' => ''],
            ['name' => 'email', 'value' => ''],
            ['name' => 'facebook', 'value' => ''],
            ['name' => 'instagram', 'value' => ''],
        ]);

    }
}
