@extends('layouts.app')

<?php
/**
 * @var \App\Models\Wallet $wallet
 */
?>

@section('content')
    <x-page-title>{{ __('Create wallet') }}</x-page-title>

    @if(session('alert'))
        <x-alert :type="session('alert')['type']">
            {{ session('alert')['message'] }}
        </x-alert>
    @endif

    <form method="POST" action="{{ route('wallets.store') }}" class="grid grid-cols-1 gap-4 py-6">
        @csrf
        <div class="form-control w-full max-w-xs mx-auto">
            <x-label for="title">{{ __('Title') }}</x-label>
            <input class="input-md"
                   id="title"
                   type="text"
                   name="title"
                   value="{{ old('title') }}"
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
            <x-label for="balance">{{ __('Balance') }}</x-label>
            <input class="input-md"
                   id="balance"
                   type="text"
                   name="balance"
                   value="{{ old('balance') }}"
                   required
                   autofocus/>

            @error('balance')
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
            <a href="{{ route('wallets.index') }}" class="btn btn-link">{{ __('Cancel') }}</a>
        </div>
    </form>
@endsection
