<?php

use App\Constants\EmailSchedule;
use App\Constants\NewsSource;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    return [
        'email'       => $faker->unique()->safeEmail,
        'news_source' => $faker->randomElement(NewsSource::all()),
        'schedule'    => $faker->randomElement(EmailSchedule::all()),
    ];
});
