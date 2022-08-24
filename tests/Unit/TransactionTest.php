<?php

use Database\Factories\TransactionFactory;
use Database\Factories\UserFactory;
use Database\Factories\WalletFactory;
use Tests\TestCase;

uses(TestCase::class);

test('transaction routes have auth middleware', function () {
    /** @var \App\Models\Transaction $transaction */
    $transaction = (new TransactionFactory())->for(
        (new WalletFactory())->for((new UserFactory()))
    )
        ->create();

    $this->get(route('wallets.transactions.index', $transaction->wallet))
        ->assertRedirect(route('login'));

    $this->get(route('wallets.transactions.create', $transaction->wallet))
        ->assertRedirect(route('login'));

    $this->post(route('wallets.transactions.store', $transaction->wallet))
        ->assertRedirect(route('login'));

    $this->patch(route('transactions.update', $transaction))
        ->assertRedirect(route('login'));

    $this->delete(route('transactions.destroy', $transaction))
        ->assertRedirect(route('login'));
});
