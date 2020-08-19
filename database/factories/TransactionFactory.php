<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Transaction;
use Faker\Generator as Faker;

$factory->define(Transaction::class, function (Faker $faker) {
    return [
        'is_incoming'   => $faker->boolean(35),
        'is_fraudulent' => $faker->boolean(20),
        'amount'        => $faker->randomFloat(2, 50, 800),
        'reference'     => $faker->text(150),
        'payer'         => $faker->text(150),
        'beneficiary'   => $faker->text(150),
    ];
});
