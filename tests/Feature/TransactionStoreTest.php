<?php

use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;

use function Pest\Faker\faker;

it('stores transaction', function () {
    /** @var User $user */
    $user = User::factory()
        ->create();

    /** @var Wallet $wallet */
    $wallet = Wallet::factory()
        ->for($user)
        ->create();

    $balanceBeforeTransaction = $wallet->balance;

    /** @var Transaction $transaction */
    $transaction = Transaction::factory()
        ->for($wallet)
        ->state(function (array $attributes) use ($user) {
            $attributes['payer'] = $attributes['is_incoming']
                ? faker()->name . ' ' . faker()->iban
                : $user->email;

            $attributes['beneficiary'] = $attributes['is_incoming']
                ? $user->email
                : faker()->name . ' ' . faker()->iban;

            return $attributes;
        })
        ->afterCreating(function (Transaction $transaction) use ($wallet) {
            $wallet->balance = $transaction->is_incoming
                ? bcadd($wallet->balance, $transaction->amount)
                : bcsub($wallet->balance, $transaction->amount);
            $wallet->save();
        })
        ->create();

    if ($transaction->is_incoming) {
        $this->assertTrue($wallet->balance > $balanceBeforeTransaction);
    } else {
        $this->assertTrue($balanceBeforeTransaction > $wallet->balance);
    }

    $this->assertDatabaseHas('transactions', $transaction->toArray());
});
