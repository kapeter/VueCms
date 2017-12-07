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
            'info' => '',
            'value' => '',
            'is_public' => true
        ]);
        DB::table('settings')->insert([
            'name' => 'app_description',
            'title' => '网站介绍',
            'type' => 'basic',
            'info' => '',
            'value' => '',
            'is_public' => true
        ]);
        DB::table('settings')->insert([
            'name' => 'app_keyword',
            'title' => '网站关键词',
            'type' => 'basic',
            'info' => '',
            'value' => '',
            'is_public' => true
        ]);
        DB::table('settings')->insert([
            'name' => 'site_url',
            'title' => '前台网址',
            'type' => 'basic',
            'info' => '',
            'value' => '',
            'is_public' => true
        ]);
        DB::table('settings')->insert([
            'name' => 'admin_email',
            'title' => '管理员邮箱',
            'type' => 'basic',
            'info' => '可填写多个邮箱，邮箱之间用英文符号","分隔',
            'value' => '',
            'is_public' => false
        ]);
    }
}
