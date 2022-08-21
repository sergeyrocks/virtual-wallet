<?php

use Database\Factories\UserFactory;
use Database\Factories\WalletFactory;
use Tests\TestCase;

uses(TestCase::class);

test('wallet routes have auth middleware', function () {
    $wallet = (new WalletFactory())->for((new UserFactory()))
        ->create();

    $this->get(route('wallets.index'))
        ->assertRedirect(route('login'));

    $this->get(route('wallets.create'))
        ->assertRedirect(route('login'));

    $this->post(route('wallets.store'))
        ->assertRedirect(route('login'));

    $this->get(route('wallets.edit', $wallet))
        ->assertRedirect(route('login'));

    $this->patch(route('wallets.update', $wallet))
        ->assertRedirect(route('login'));
});
