<?php

use App\Models\Transaction;
use Database\Factories\TransactionFactory;
use Database\Factories\UserFactory;
use Database\Factories\WalletFactory;

use function Pest\Faker\fake;

test('user can index transactions', function () {
    /** @var \App\Models\User $user */
    $user = (new UserFactory())->create();

    /** @var \App\Models\Wallet $wallet */
    $wallet = (new WalletFactory())->for($user)
        ->create();

    $transactions = (new TransactionFactory())->count(20)
        ->for($wallet)
        ->create();

    $this->actingAs($user)
        ->get(route('wallets.transactions.index', $wallet))
        ->assertOk()
        ->assertSee([
            $transactions->first()->amount,
            $transactions->first()->payer,
            $transactions->first()->reference,
            $transactions->get(4)->amount,
            $transactions->get(4)->payer,
            $transactions->get(4)->reference,
            $transactions->random()->amount,
            $transactions->random()->payer,
            $transactions->random()->reference,
        ]);
});

test('user can create transaction', function () {
    /** @var \App\Models\User $user */
    $user = (new UserFactory)->create();

    /** @var \App\Models\Wallet $wallet */
    $wallet = (new WalletFactory())->for($user)
        ->create();

    $payload = [
        'amount' => fake()->randomFloat(2, 10, 9999),
        'reference' => fake()->text,
        'payer' => fake()->iban,
        'beneficiary' => fake()->iban,
    ];

    $this->actingAs($user)
        ->post(route('wallets.transactions.store', $wallet), $payload)
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('wallets.transactions.index', $wallet));

    $this->assertDatabaseHas(
        (new Transaction())->getTable(),
        array_merge($payload, ['wallet_id' => $wallet->id])
    );

    $this->assertTrue($wallet->balance > $wallet->fresh()->balance);
    $this->assertEquals(
        bcadd($wallet->fresh()->balance, $payload['amount'], 2),
        $wallet->balance
    );
});

test('user can delete transaction', function () {
    /** @var \App\Models\User $user */
    $user = (new UserFactory)->create();

    /** @var \App\Models\Wallet $wallet */
    $wallet = (new WalletFactory())->for($user)
        ->create();

    /** @var Transaction $transaction */
    $transaction = (new TransactionFactory())->state([
        'is_incoming' => false,
    ])
        ->for($wallet)
        ->create();

    $this->assertTrue($transaction->deleted_at === null);

    $this->actingAs($user)
        ->delete(route('transactions.destroy', $transaction))
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('wallets.transactions.index', $wallet));

    $this->assertTrue($transaction->fresh()->deleted_at !== null);
    $this->assertTrue($wallet->fresh()->balance > $wallet->balance);
    $this->assertEquals(
        bcsub($wallet->fresh()->balance, $transaction->amount, 2),
        $wallet->balance
    );
});

test('user needs authorization to list transactions', function () {
    /** @var \App\Models\Wallet $wallet */
    $wallet = (new WalletFactory())->for(new UserFactory())
        ->create();

    (new TransactionFactory())->count(20)
        ->for($wallet)
        ->create();

    $this->actingAs((new UserFactory())->create())
        ->get(route('wallets.transactions.index', $wallet))
        ->assertForbidden();
});

test('user needs authorization to create transaction', function () {
    /** @var \App\Models\Wallet $wallet */
    $wallet = (new WalletFactory())->for(new UserFactory())
        ->create();

    $payload = [
        'amount' => fake()->randomFloat(2, 10, 9999),
        'reference' => fake()->text,
        'payer' => fake()->iban,
        'beneficiary' => fake()->iban,
    ];

    $this->actingAs((new UserFactory())->create())
        ->post(route('wallets.transactions.store', $wallet), $payload)
        ->assertForbidden();
});

test('user needs authorization to update transaction', function () {
    /** @var \App\Models\Wallet $wallet */
    $wallet = (new WalletFactory())->for(new UserFactory())
        ->create();

    /** @var Transaction $transaction */
    $transaction = (new TransactionFactory())->state([
        'is_fraudulent' => false,
    ])
        ->for($wallet)
        ->create();

    $payload = [
        'is_fraudulent' => true,
    ];

    $this->actingAs((new UserFactory())->create())
        ->patch(route('transactions.update', $transaction), $payload)
        ->assertForbidden();

    $this->assertEquals($transaction->is_fraudulent, $transaction->fresh()->is_fraudulent);
});

test('user needs authorization to delete transaction', function () {
    /** @var \App\Models\Wallet $wallet */
    $wallet = (new WalletFactory())->for(new UserFactory())
        ->create();

    /** @var Transaction $transaction */
    $transaction = (new TransactionFactory())->state([
        'is_incoming' => false,
    ])
        ->for($wallet)
        ->create();

    $this->assertTrue($transaction->deleted_at === null);

    $this->actingAs((new UserFactory())->create())
        ->delete(route('transactions.destroy', $transaction))
        ->assertForbidden();

    $this->assertTrue($transaction->fresh()->deleted_at === null);
    $this->assertTrue($wallet->fresh()->balance === $wallet->balance);
});
