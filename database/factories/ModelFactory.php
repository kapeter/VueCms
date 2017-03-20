<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Post::class, function (Faker\Generator $faker) {
    $user_ids = App\User::pluck('id')->random();
    $title = $faker->sentence(mt_rand(3,10));
    return [
        'category_id'  => 0,
        'user_id'      => $user_ids,
        'last_user_id' => $user_ids,
        'slug'     => str_slug($title),
        'title'    => $title,
        'content'  => $faker->paragraph,
        'cover_img'   => $faker->imageUrl(),
        'description' => $faker->sentence,
        'is_draft'         => false,
        'published_at'     => $faker->dateTimeBetween($startDate = '-2 months', $endDate = 'now')
    ];
});
