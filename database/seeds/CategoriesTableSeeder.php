<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'name' => '未分类',
            'parent_id' => 0,
            'model' => 'post',
            'slug' => 'untitled',
            'description' => '未分类',
            'created_at'  => Carbon::now(),
            'updated_at'  => Carbon::now()
        ]);
        DB::table('categories')->insert([
            'name' => '前端开发',
            'parent_id' => 0,
            'model' => 'post',
            'slug' => 'fronted',
            'description' => '永远相信美好的事情即将发生',
            'created_at'  => Carbon::now(),
            'updated_at'  => Carbon::now()
        ]);
        DB::table('categories')->insert([
            'name' => '后端开发',
            'parent_id' => 0,
            'model' => 'post',
            'slug' => 'backend',
            'description' => '永远相信美好的事情即将发生',
            'created_at'  => Carbon::now(),
            'updated_at'  => Carbon::now()
        ]);
    }
}
