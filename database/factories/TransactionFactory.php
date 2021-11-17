<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'is_incoming'   => $this->faker->boolean(35),
            'is_fraudulent' => $this->faker->boolean(20),
            'amount'        => $this->faker->randomFloat(2, 50, 800),
            'reference'     => $this->faker->text(150),
            'payer'         => $this->faker->text(150),
            'beneficiary'   => $this->faker->text(150),
        ];
    }
}
