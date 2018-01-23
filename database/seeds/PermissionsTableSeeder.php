<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            'route'       => 'post',
            'title'       => '文章管理',
            'description' => '撰写文章并发布。',
            'icon'        => 'book',
            'created_at'  => Carbon::now(),
            'updated_at'  => Carbon::now()
        ]);

        DB::table('permissions')->insert([
            'route'       => 'media',
            'title'       => '媒体库',
            'description' => '多媒体资源管理。',
            'icon'        => 'camera',
            'created_at'  => Carbon::now(),
            'updated_at'  => Carbon::now()
        ]);
    }
}
