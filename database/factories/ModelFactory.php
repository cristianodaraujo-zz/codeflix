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
$factory->define(\App\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->state(\App\Models\User::class, 'admin',  function (Faker\Generator $faker) {
    return [
        'role' => \App\Models\User::ROLE_ADMIN
    ];
});

$factory->define(\App\Models\Category::class, function (Faker\Generator $faker) {
    return [
        'name' => ucfirst($faker->unique()->word)
    ];
});

$factory->define(\App\Models\Playlist::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->unique()->sentence(3),
        'description' => $faker->sentence(10),
        'thumbnail' => 'image.jpg'
    ];
});

$factory->define(\App\Models\Video::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->unique()->sentence(3),
        'description' => $faker->sentence(10),
        'duration' => rand(1, 25),
        'archive' => 'video.mp4',
        'thumbnail' => 'image.jpg',
        'published' => rand(0, 1),
        'completed' => 1
    ];
});

$factory->define(\App\Models\Plan::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->sentence(10),
        'value' => $faker->randomFloat(2, 50, 100)
    ];
});

$factory->state(\App\Models\Plan::class, \App\Models\Plan::DURATION_MONTHLY, function () {
    return [
        'duration' => \App\Models\Plan::DURATION_MONTHLY,
    ];
});

$factory->state(\App\Models\Plan::class, \App\Models\Plan::DURATION_YEARLY, function () {
    return [
        'duration' => \App\Models\Plan::DURATION_YEARLY,
    ];
});

$factory->define(\App\Models\Order::class,  function (Faker\Generator $faker) {
    return [
        'code' => str_random(),
        'value' => $faker->randomFloat(2, 50, 100),
    ];
});

$factory->define(\App\Models\WebProfile::class, function(\Faker\Generator $faker){
    return [
        'name' => $faker->name,
        'logo_url' => $faker->imageUrl(50, 50),
        'code' => str_random()
    ];
});