<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Wallet;
use Faker\Generator as Faker;

$factory->define(Wallet::class, function (Faker $faker) {
    return [
        'title'   => $faker->text('50'),
        'balance' => $faker->randomFloat(2, 10000, 30000),
    ];
});
