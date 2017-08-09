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
            'parent_id'     => 0,
            'url'           => '/dashboard',
            'title'         => '仪表盘',
	        'type'          => 'page',
            'description'   => '后台首页',
	        'is_menu'       => true,
            'icon'          => 'speedometer',
            'order'         => 1,
            'created_at'  => Carbon::now(),
            'updated_at'  => Carbon::now()
        ]);
    }
}
