<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            'name' => 'app_name',
            'title' => '网站标题',
            'type' => 'basic',
            'value' => '',
            'is_public' => true
        ]);
        DB::table('settings')->insert([
            'name' => 'app_description',
            'title' => '网站介绍',
            'type' => 'basic',
            'value' => '',
            'is_public' => true
        ]);
        DB::table('settings')->insert([
            'name' => 'app_keyword',
            'title' => '网站关键词',
            'type' => 'basic',
            'value' => '',
            'is_public' => true
        ]);
        DB::table('settings')->insert([
            'name' => 'site_url',
            'title' => '前台网址',
            'type' => 'basic',
            'value' => '',
            'is_public' => true
        ]);
    }
}
