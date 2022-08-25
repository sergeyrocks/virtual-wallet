<?php

namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Wallet $wallet): bool
    {
        return $user->id === $wallet->user_id;
    }

    public function create(User $user, Wallet $wallet): bool
    {
        return $user->id === $wallet->user_id;
    }

    public function update(User $user, Transaction $transaction, Wallet $wallet): bool
    {
        return $user->id === $wallet->user_id && $transaction->wallet_id === $wallet->id;
    }

    public function delete(User $user, Transaction $transaction, Wallet $wallet): bool
    {
        return $user->id === $wallet->user_id && $transaction->wallet_id === $wallet->id;
    }
}
