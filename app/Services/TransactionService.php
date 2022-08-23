<?php

namespace App\Services;

use App\Dto\TransactionCreate;
use App\Models\Transaction;
use App\Models\Wallet;

class TransactionService
{
    public function create(Wallet $wallet, TransactionCreate $data): Transaction
    {
        $wallet->balance = $data->is_incoming
            ? bcadd($wallet->balance, $data->amount, 2)
            : bcsub($wallet->balance, $data->amount, 2);

        $transaction = Transaction::create(array_merge(
            (array) $data,
            ['wallet_id' => $wallet->id]
        ));

        $wallet->save();

        return $transaction;
    }
}
