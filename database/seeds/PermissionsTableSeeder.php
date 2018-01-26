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
            'created_at'  => Carbon::now(),
            'updated_at'  => Carbon::now()
        ]);

        DB::table('permissions')->insert([
            'route'       => 'media',
            'title'       => '媒体库',
            'description' => '多媒体资源管理。',
            'created_at'  => Carbon::now(),
            'updated_at'  => Carbon::now()
        ]);

        DB::table('permissions')->insert([
            'route'       => 'profile',
            'title'       => '个人中心',
            'description' => '个人信息修改',
            'is_except'   => true,
            'created_at'  => Carbon::now(),
            'updated_at'  => Carbon::now()
        ]);

        DB::table('permissions')->insert([
            'route'       => 'category',
            'title'       => '分类目录',
            'description' => '文章栏目管理',
            'created_at'  => Carbon::now(),
            'updated_at'  => Carbon::now()
        ]);

        DB::table('permissions')->insert([
            'route'       => 'system',
            'title'       => '系统设置',
            'description' => '系统相关参数设置',
            'created_at'  => Carbon::now(),
            'updated_at'  => Carbon::now()
        ]);

        DB::table('permissions')->insert([
            'route'       => 'mail',
            'title'       => '邮件管理',
            'description' => '管理用户提交的联系邮件',
            'created_at'  => Carbon::now(),
            'updated_at'  => Carbon::now()
        ]);

        DB::table('permissions')->insert([
            'route'       => 'user',
            'title'       => '用户管理',
            'description' => '管理系统用户',
            'created_at'  => Carbon::now(),
            'updated_at'  => Carbon::now()
        ]);

        DB::table('permissions')->insert([
            'route'       => 'role',
            'title'       => '角色管理',
            'description' => '管理系统角色',
            'created_at'  => Carbon::now(),
            'updated_at'  => Carbon::now()
        ]);

        DB::table('permissions')->insert([
            'route'       => 'permission',
            'title'       => '权限管理',
            'description' => '管理系统权限',
            'created_at'  => Carbon::now(),
            'updated_at'  => Carbon::now()
        ]);

        DB::table('permissions')->insert([
            'route'       => 'log',
            'title'       => '接口日志',
            'description' => '接口调用日志列表',
            'created_at'  => Carbon::now(),
            'updated_at'  => Carbon::now()
        ]);
    }
}
