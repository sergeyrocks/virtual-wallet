<?php

use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use function Pest\Faker\faker;

it('stores transaction', function () {
    /** @var User $user */
    $user = User::factory()
        ->has(Wallet::factory())
        ->create();

    $wallet = $user->wallets->first();

    $balanceBeforeTransaction = $wallet->balance;

    /** @var Transaction $transaction */
    $transaction = Transaction::factory()->for($wallet)->create();

    $transaction->payer = $transaction->is_incoming ?
        faker()->name . ' ' . faker()->iban() :
        $user->email;

    $transaction->beneficiary = !$transaction->is_incoming ?
        faker()->name . ' ' . faker()->iban() :
        $user->email;

    $wallet->balance = $transaction->is_incoming ?
        bcadd($wallet->balance, $transaction->amount) :
        bcsub($wallet->balance, $transaction->amount);

    $transaction->save();
    $wallet->save();

    if ($transaction->is_incoming) {
        $this->assertTrue($wallet->balance > $balanceBeforeTransaction);
    } else {
        $this->assertTrue($balanceBeforeTransaction > $wallet->balance);
    }

    $this->assertDatabaseHas('transactions', $transaction->toArray());
});
