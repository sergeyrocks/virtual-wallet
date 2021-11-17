<?php

use App\Models\User;
use App\Models\Wallet;

use function Pest\Laravel\assertDatabaseHas;

it('creates wallet', function () {
    $user = User::factory()->has(Wallet::factory())->create();

    assertDatabaseHas('wallets', $user->wallets->first()->toArray());
});
