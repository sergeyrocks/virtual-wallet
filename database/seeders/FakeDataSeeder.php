<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\Hash;

class FakeDataSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create();
        /** @var User $user */
        $user = User::factory()->state([
            'email' => 'user@example.org',
            'password' => Hash::make('password'),
        ])->create();

        /** @var Wallet $wallet */
        $wallet = Wallet::factory()
            ->for($user)
            ->create();

        Transaction::factory()
            ->count(15)
            ->for($wallet)
            ->state(function (array $attributes) use ($user, $faker) {
                $attributes['payer'] = $attributes['is_incoming']
                    ? $faker->name . ' ' . $faker->iban
                    : $user->email;

                $attributes['beneficiary'] = $attributes['is_incoming']
                    ? $user->email
                    : $faker->name . ' ' . $faker->iban;

                return $attributes;
            })
            ->afterCreating(function (Transaction $transaction) use ($wallet) {
                $wallet->balance = $transaction->is_incoming
                    ? bcadd($wallet->balance, $transaction->amount)
                    : bcsub($wallet->balance, $transaction->amount);
                $wallet->save();
            })
            ->create();
    }
}
