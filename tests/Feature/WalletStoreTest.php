<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Wallet;
use Tests\TestCase;

class WalletStoreTest extends TestCase
{

    use WithFaker, RefreshDatabase;

    /**
     * @return void
     */
    public function testWalletStore()
    {
        $user = factory(User::class)->create();
        $wallet = $user->wallets()->save(factory(Wallet::class)->make());
        $wallet->save();

        $this->assertDatabaseHas('wallets', $wallet->toArray());
    }
}
