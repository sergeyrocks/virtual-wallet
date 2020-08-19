<?php

use App\Models\Transaction;
use Illuminate\Database\Seeder;
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
        factory(User::class)->create()->each(function ($user) {
            $wallet = $user->wallets()->save(factory(Wallet::class)->make());
            $wallet->save();
            factory(Transaction::class, 15)
                ->make()
                ->each(function ($transaction) use ($user, $wallet) {
                    $wallet->transactions()->save($transaction);
                    $transaction->payer = $transaction->is_incoming ?: $user->email;
                    $transaction->beneficiary = !$transaction->is_incoming ?: $user->email;
                    $transaction->save();
                });
        });
    }
}
