@extends('layouts.app')

<?php
    /**
     * @var \App\Models\Wallet $wallet
     */
?>

@section('content')
    <div class="container pt-5">
        <div class="row">
            <div class="col">
                <h1 class="text-center">Wallets</h1>
            </div>
        </div>
        <div class="row justify-content-center my-4">
            <a href="{{ route('wallets.create') }}" class="btn btn-primary">Add wallet</a>
        </div>
        <div class="row justify-content-center">
            <div class="col-8">
                @if(session('alert'))
                    <div class="row no-gutters">
                        <div class="col">
                            @include('components.alert', ['type' => session('alert')['type'], 'slot' => session('alert')['message']])
                        </div>
                    </div>
                @endif
                <ul>
                    @foreach($wallets as $wallet)
                        <li class="card px-3 py-4 mb-4">
                            <div class="row no-gutters justify-content-around align-items-center">
                                <div class="col-8">
                                    <h4 class="mb-1">{{ $wallet->title }}</h4>
                                    <h5 class="mb-1">${{ $wallet->getBalance() }}</h5>
                                    <div>
                                        <a href="{{ route('wallets.transactions.create', $wallet) }}">
                                            Add transaction
                                        </a>
                                    </div>
                                    <div>
                                        <a href="{{ route('wallets.transactions.index', $wallet) }}">
                                            Transactions list
                                        </a>
                                    </div>
                                </div>
                                <div class="col-4 text-right">
                                    <a class="px-1 btn btn-link" href="{{ route('wallets.edit', $wallet) }}">Edit</a>
                                    <form action="{{ route('wallets.destroy', $wallet) }}" method="POST" class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link px-1 text-danger py-0 d-inline-block">Remove</button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
