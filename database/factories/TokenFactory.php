<?php

use App\Models\Token;
use App\Models\User;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Token::class, function (Faker $faker) {
    return [
        'expires_at' => Carbon::now()->addDays(2),
        'password'   => $faker->unique()->uuid,
        'user_id'    => function () {
            return factory(User::class)->create()->id;
        },
    ];
});
