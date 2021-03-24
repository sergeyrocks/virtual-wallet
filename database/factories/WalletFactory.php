<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Wallet;
use Faker\Generator as Faker;

$factory->define(Wallet::class, function (Faker $faker) {
    return [
        'title'   => 'Sample wallet',
        'balance' => $faker->randomFloat(2, 10000, 30000),
    ];
});
