<?php

use Faker\Generator as Faker;

$factory->define(App\Services\Image::class, function ($faker) {
    return [
        'description' => $faker->title,
        'image' => $faker->title,
        'id_user' => function () {
        return App\User::all()->random()->id;
        }
    ];
});
