<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'email' => $this->faker->safeEmail,
            'password' => Hash::make('password'),
        ];
    }
}
