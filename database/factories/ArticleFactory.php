<?php

use App\Models\Article;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'abstract'     => $faker->paragraph(),
        'byline'       => 'By ' . $faker->name(),
        'external_id'  => $faker->unique()->uuid,
        'period'       => $faker->randomElement([1, 7]),
        'popularity'   => (int) $faker->biasedNumberBetween(1, 100),
        'retrieved_at' => Carbon::now(),
        'title'        => $faker->sentence(),
        'url'          => $faker->url,
    ];
});
