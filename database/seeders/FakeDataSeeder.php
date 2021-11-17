<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;

class FakeDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        factory(User::class)->create()->each(function ($user) use ($faker) {
            $wallet = $user->wallets()->save(factory(Wallet::class)->make());
            $wallet->save();
            factory(Transaction::class, 15)
                ->make()
                ->each(function ($transaction) use ($user, $wallet, $faker) {
                    $wallet->transactions()->save($transaction);
                    $transaction->payer = $transaction->is_incoming ?
                        $faker->name . ' ' . $faker->iban() :
                        $user->email;
                    $transaction->beneficiary = !$transaction->is_incoming ?
                        $faker->name . ' ' . $faker->iban() :
                        $user->email;
                    $wallet->balance = $transaction->is_incoming ?
                        bcadd($wallet->balance, $transaction->amount) :
                        bcsub($wallet->balance, $transaction->amount);
                    $transaction->save();
                    $wallet->save();
                });
        });
    }
}
