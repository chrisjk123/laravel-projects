<?php

use Chriscreates\Projects\Models\Project;
use Chriscreates\Projects\Models\Status;
use Chriscreates\Projects\Models\User;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'author_id' => factory(User::class)->create()->id,
        'owner_id' => factory(User::class)->create()->id,
        'title' => $faker->name,
        'description' => $faker->paragraph,
        'notes' => $faker->paragraph,
        'visible' => true,
        'started_at' => now(),
        'delivered_at' => now(),
        'expected_at' => now(),
        'status_id' => factory(Status::class)->create()->id,
    ];
});
