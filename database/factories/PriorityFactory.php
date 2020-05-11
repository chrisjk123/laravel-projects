<?php

use Chriscreates\Projects\Models\Priority;
use Faker\Generator as Faker;

$factory->define(Priority::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});
