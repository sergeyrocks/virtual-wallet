<?php

use App\Models\User;
use App\Models\Wallet;

use Database\Factories\UserFactory;

use Database\Factories\WalletFactory;

use function Pest\Faker\faker;

test('user can create a wallet', function () {
    /** @var User $user */
    $user = (new UserFactory())->has((new WalletFactory()))->create();

    $payload = [
        'title' => faker()->text(25),
        'balance' => faker()->numberBetween(100, 9999),
    ];

    $this->actingAs($user)
        ->post(route('wallets.store'), $payload)
        ->assertSessionHasNoErrors()
        ->assertRedirect()
        ->assertSessionHas('alert', ['type' => 'success', 'message' => 'Wallet created successfully']);

    $this->assertDatabaseHas((new Wallet())->getTable(), array_merge($payload, ['user_id' => $user->id]));
});

test('user can index wallets', function () {
    /** @var User $user */
    $user = (new UserFactory())->create();
    $wallets = (new WalletFactory())->count(10)->for($user)
        ->create();

    $this->actingAs($user)
        ->get(route('wallets.index'))
        ->assertOk()
        ->assertSee([
            $wallets->first()->title,
            $wallets->get(4)->title,
            $wallets->random()->title,
        ]);
});

test('user can update wallet', function () {
    /** @var User $user */
    $user = (new UserFactory())->create();
    $wallet = (new WalletFactory())->for($user)
        ->create();

    $payload = [
        'title' => faker()->text(15),
    ];

    $this->actingAs($user)
        ->patch(route('wallets.update', $wallet), $payload)
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('wallets.edit', $wallet));

    $this->assertEquals($wallet->fresh()->title, $payload['title']);
    $this->assertDatabaseHas($wallet, ['title' => $payload['title']]);
});

test('user can delete wallet', function () {
    /** @var User $user */
    $user = (new UserFactory())->create();
    $wallet = (new WalletFactory())->for($user)
        ->create();

    $this->actingAs($user)
        ->delete(route('wallets.destroy', $wallet))
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('wallets.index'));
});

test('user needs authorization to delete wallet', function () {
    /** @var User $user */
    $user = (new UserFactory())->create();
    $user2 = (new UserFactory())->create();

    $wallet = (new WalletFactory())->for($user2)
        ->create();

    $this->actingAs($user)
        ->delete(route('wallets.destroy', $wallet))
        ->assertForbidden();

    $this->actingAs($user2)
        ->delete(route('wallets.destroy', $wallet))
        ->assertRedirect(route('wallets.index'))
        ->assertDontSee($wallet->title);

    $this->assertTrue($wallet->fresh()->deleted_at !== null);
});

test('user needs authorization to update wallet', function () {
    /** @var User $user */
    $user = (new UserFactory())->create();
    $user2 = (new UserFactory())->create();

    $wallet = (new WalletFactory())->for($user2)
        ->create();

    $payload = [
        'title' => faker()->text(15),
    ];

    $this->actingAs($user)
        ->patch(route('wallets.update', $wallet), $payload)
        ->assertForbidden();

    $this->assertDatabaseMissing($wallet, ['title' => $payload['title']]);

    $this->actingAs($user2)
        ->patch(route('wallets.update', $wallet), $payload)
        ->assertRedirect(route('wallets.edit', $wallet));

    $this->assertDatabaseHas($wallet, ['title' => $payload['title']]);
});
