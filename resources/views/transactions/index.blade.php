@extends('layouts.app')

<?php
    /**
     * @var \App\Models\Transaction $transaction
     * @var \App\Models\Wallet $wallet
     */
?>

@section('content')
    <div class="container pt-5">
        <div class="row">
            <div class="col">
                <h1 class="text-center">Wallet "{{ $wallet->title }}" transactions</h1>
            </div>
        </div>
        <div class="row justify-content-center my-4">
            <a href="{{ route('wallets.transactions.create', $wallet) }}" class="btn btn-primary">Add transaction</a>
            <a href="{{ route('wallets.index') }}" class="btn btn-link">Back to wallets list</a>
        </div>
        <div class="row justify-content-center">
            <div class="col">
                @if(session('alert'))
                    <div class="row no-gutters">
                        <div class="col">
                            @include('components.alert', ['type' => session('alert')['type'], 'slot' => session('alert')['message']])
                        </div>
                    </div>
                @endif
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped">
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
                                    <tr class="@if($transaction->is_fraudulent) bg-warning @endif">
                                        <td>{{ $transaction->id }}</td>
                                        <td>{{ $transaction->payer }}</td>
                                        <td>{{ $transaction->beneficiary }}</td>
                                        <td>{{ $transaction->reference }}</td>
                                        <td class="@if($transaction->is_incoming) text-success @else text-danger @endif">{{ $transaction->getFormattedAmount() }}</td>
                                        <td>
                                            <form action="{{ route('wallets.transactions.update', ['wallet' => $wallet, 'transaction' => $transaction]) }}"
                                                  method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden"
                                                       name="is_fraudulent"
                                                       value="{{ $transaction->is_fraudulent ? 'false' : 'true' }}">
                                                <button type="submit"
                                                        class="btn btn-link">
                                                    {{ $transaction->is_fraudulent ? 'Unmark fraudulent' : 'Mark fraudulent' }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
