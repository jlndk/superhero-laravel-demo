<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Superhero;
use Faker\Generator as Faker;

$factory->define(Superhero::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'alter_ego' => $faker->name,
        'first_appeared' => $faker->year,
    ];
});
