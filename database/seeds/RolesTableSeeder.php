<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
        	'name'        => 'administrator',
            'title'       => '超级管理员',
            'description' => '拥有后台管理全部权限。',
            'is_admin'    => true,
            'created_at'  => Carbon::now(),
            'updated_at'  => Carbon::now()
        ]);

        DB::table('roles')->insert([
            'name'        => 'editor',
            'title'       => '编辑者',
            'description' => '拥有后台编辑权限。',
            'is_admin'    => false,
            'created_at'  => Carbon::now(),
            'updated_at'  => Carbon::now()
        ]);
    }
}
