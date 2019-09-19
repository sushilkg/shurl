<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Link;
use Faker\Generator as Faker;

$factory->define(Link::class, function (Faker $faker) {
    return [
        'long_url' => $faker->name,
        'short_tag' => $faker->slug,
        'expiration_date' => $faker->dateTimeThisMonth('+1 month')->format('Y-m-d H:i:s'),
        'hits' => $faker->randomNumber(3)
    ];
});
