<?php

use Chriscreates\Projects\Models\Priority;
use Chriscreates\Projects\Models\Task;
use Chriscreates\Projects\Models\User;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class)->create()->id,
        'priority_id' => factory(Priority::class)->create()->id,
        'title' => $faker->name,
        'description' => $faker->paragraph,
        'notes' => $faker->paragraph,
        'complete' => true,
    ];
});
