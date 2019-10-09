<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use App\User;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'user_id' => auth()->user() ?: factory(User::class),
        'name' => $faker->sentence,
        'schedule' => 0
    ];
});

$factory->state(Task::class, 'today', function () {
    return [
        'schedule' => 1 << Carbon::now()->dayOfWeek
    ];
});
