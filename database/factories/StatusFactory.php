<?php

use Chriscreates\Projects\Models\Status;
use Faker\Generator as Faker;

$factory->define(Status::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});
