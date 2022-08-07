<?php

$factory->define(App\Test::class, function (Faker\Generator $faker) {
    return [
        "title" => $faker->name,
        "description" => $faker->name,
        "time" => 1,
        "instruction" => $faker->name
    ];
});
