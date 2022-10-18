@extends('layouts.app')

<?php
/**
 * @var \App\Models\Wallet $wallet
 */
?>

@section('content')
    <x-page-title>Wallet "{{ $wallet->title }}" edit</x-page-title>

    @include('partials.alert')

    <form method="POST" action="{{ route('wallets.update', $wallet) }}" class="grid grid-cols-1 gap-4 py-6">
        @csrf
        @method('PATCH')
        <div class="form-control w-full max-w-xs mx-auto">
            <x-label for="title">{{ __('Title') }}</x-label>
            <input class="input-md"
                   id="title"
                   type="text"
                   name="title"
                   value="{{ old('title') ?? $wallet->title }}"
                   required
                   autofocus/>

            @error('title')
            <span class="text-sm text-error"
                  role="alert">
                    *{{ $message }}
                 </span>
            @enderror
        </div>

        <div class="form-control w-full max-w-xs mx-auto">
            <button type="submit"
                    class="btn btn-primary">
                {{ __('Save') }}
            </button>
            <a href="{{ route('wallets.index') }}" class="btn btn-link">{{ __('Back') }}</a>
        </div>
    </form>
@endsection
