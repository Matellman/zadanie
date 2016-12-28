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

$factory->define(App\Hotel::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
    ];
});

$factory->define(App\Comment::class, function (Faker\Generator $faker) {
    return [
        'comment' => $faker->text,
        'rating' => rand(1,5)
    ];
});

$factory->define(App\SubComment::class, function (Faker\Generator $faker) {
    return [
        'comment' => $faker->text
    ];
});