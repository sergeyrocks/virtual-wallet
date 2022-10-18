@extends('layouts.app')

<?php
    /**
     * @var \App\Models\Transaction $transaction
     * @var \App\Models\Wallet $wallet
     */
?>

@section('content')

    <x-page-title>Wallet "{{ $wallet->title }}" transactions</x-page-title>

    <div class="flex justify-center pt-4">
        <a href="{{ route('wallets.transactions.create', $wallet) }}" class="btn btn-primary btn-sm">Add transaction</a>
        <a href="{{ route('wallets.index') }}" class="btn btn-link btn-sm">Back to wallets list</a>
    </div>

    <div class="flex flex-col py-2 my-5">
        <h5 class="text-center font-bold text-lg">Total incoming: ${{ number_format($totalIncoming) }}</h5>
        <h5 class="text-center font-bold text-lg">Total outgoing: -${{ number_format($totalOutgoing) }}</h5>
    </div>

    @include('partials.alert')

    <div class="overflow-x-auto my-5">
        <table class="table w-full">
            <thead>
            <tr>
                <th>id</th>
                <th>Payer</th>
                <th>Beneficiary</th>
                <th>Reference</th>
                <th>Amount</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($transactions as $transaction)
                <tr class="@if($transaction->is_fraudulent) active @endif">
                    <td>{{ $transaction->id }}</td>
                    <td>{{ $transaction->payer }}</td>
                    <td>{{ $transaction->beneficiary }}</td>
                    <td>{{ $transaction->reference }}</td>
                    <td class="@if($transaction->is_incoming) text-success @else text-error @endif">{{ $transaction->getFormattedAmount() }}</td>
                    <td>
                        <form action="{{ route('transactions.update', $transaction) }}"
                              class="inline-block"
                              method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden"
                                   name="is_fraudulent"
                                   value="{{ $transaction->is_fraudulent ? 'false' : 'true' }}">
                            <button type="submit"
                                    class="btn btn-link btn-xs py-0">
                                {{ $transaction->is_fraudulent ? 'Unmark fraudulent' : 'Mark fraudulent' }}
                            </button>
                        </form>
                        <form action="{{ route('transactions.destroy', $transaction) }}"
                              method="POST"
                              class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="btn btn-link btn-xs text-error py-0">
                                Remove
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection
