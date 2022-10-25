@props(['wallet'])

<?php /** * @var \App\Models\Wallet $wallet */ ?>

<div class="grid max-w-[365px] mx-2">
    <div class="stats bg-primary text-primary-content">

        <div class="stat">
            <div class="stat-title">{{ $wallet->title }}</div>
            <div class="stat-value">${{ $wallet->getBalance() }}</div>
            <div class="mt-4 flex justify-between flex-wrap">
                <a href="{{ route('wallets.transactions.create', $wallet) }}" class="btn btn-sm m-1">
                    {{ __('Add transaction') }}
                </a>
                <a href="{{ route('wallets.transactions.index', $wallet) }}" class="btn btn-sm m-1">
                    {{ __('Transactions') }}
                </a>
            </div>
        </div>

    </div>
    <div class="flex justify-end">
        <a class="px-1 btn btn-link btn-sm text-neutral" href="{{ route('wallets.edit', $wallet) }}">Edit</a>
        <form action="{{ route('wallets.destroy', $wallet) }}" method="POST" class="d-inline-block">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-link btn-sm text-error btn-error px-1">Remove</button>
        </form>
    </div>
</div>
