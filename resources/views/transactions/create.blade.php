@extends('layouts.app')

<?php
    /**
     * @var \App\Models\Wallet $wallet
     */
?>

@section('content')

    <x-page-title>{{ __('Create transaction') }}</x-page-title>

    @include('partials.alert')

    <livewire:transactions.create :wallet="$wallet"/>
@endsection
