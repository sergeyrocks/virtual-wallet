<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class WalletFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => 'Sample wallet',
            'balance' => $this->faker->randomFloat(2, 10000, 3000),
        ];
    }
}
