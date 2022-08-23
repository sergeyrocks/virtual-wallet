<?php

use App\Models\Transaction;
use Database\Factories\UserFactory;
use Database\Factories\WalletFactory;

use function Pest\Faker\faker;

test('user can create transaction', function () {
    /** @var \App\Models\User $user */
    $user = (new UserFactory)->create();

    /** @var \App\Models\Wallet $wallet */
    $wallet = (new WalletFactory())->for($user)
        ->create();

    $payload = [
        'amount' => faker()->randomFloat(2, 10, 9999),
        'reference' => faker()->text,
        'payer' => faker()->iban,
        'beneficiary' => faker()->iban,
    ];

    $this->actingAs($user)
        ->post(route('wallets.transactions.store', $wallet), $payload)
        ->assertSessionHasNoErrors()
        ->assertRedirect();

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
