@extends('layouts.app')

<?php
    /**
     * @var \App\Models\Wallet $wallet
     */
?>

@section('content')
    <x-page-title>{{ __('Wallets') }}</x-page-title>

    <div class="flex justify-center pt-4">
        <a href="{{ route('wallets.create') }}" class="btn btn-link btn-sm">Add wallet</a>
    </div>

    @include('partials.alert')

    <div class="flex justify-center flex-wrap pt-5">
        @forelse($wallets as $wallet)
            <x-wallet-card :wallet="$wallet"/>
            @empty
        @endforelse
    </div>
@endsection
