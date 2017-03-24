<?php

use Illuminate\Database\Seeder;
use App\User;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'kapeter',
            'email' => 'hfxsky@hotmail.com',
            'password' => bcrypt('123456'),
            'avatar' => '/img/avatar.jpg',
            'bio' => '永远相信美好的事情即将发生',
            'status' => true,
            'is_admin' => true,
            'created_at'  => Carbon::now(),
            'updated_at'  => Carbon::now()
        ]);

        factory(User::class, 10)->create();
    }
}
