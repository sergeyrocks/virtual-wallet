<?php

namespace Tests\Feature;

use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Wallet;
use Tests\TestCase;

class TransactionStoreTest extends TestCase
{

    use WithFaker, RefreshDatabase;

    /**
     * @return void
     */
    public function testTransactionStore()
    {
        $user = factory(User::class)->create();
        $wallet = $user->wallets()->save(factory(Wallet::class)->make());
        $wallet->save();
        $balanceBeforeTransaction = $wallet->balance;
        $transaction = factory(Transaction::class)->make();
        $wallet->transactions()->save($transaction);
        $transaction->payer = $transaction->is_incoming ?
            $this->faker->name . ' ' . $this->faker->iban() :
            $user->email;
        $transaction->beneficiary = !$transaction->is_incoming ?
            $this->faker->name . ' ' . $this->faker->iban() :
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
    }
}
