@extends('layouts.app')

<?php
    /**
     * @var \App\Models\Wallet $wallet
     */
?>

@section('content')

    <x-page-title>{{ __('Create transaction') }}</x-page-title>

    @include('partials.alert')

    <form method="POST"
          action="{{ route('wallets.transactions.store', $wallet) }}"
          class="grid grid-cols-1 gap-4 py-6">
        @csrf

        <div class="form-control w-full max-w-xs mx-auto">
            <x-label for="is_incoming" class="cursor-pointer select-none text-sm">
                <input type="checkbox"
                       name="is_incoming"
                       class="checkbox checkbox-primary checkbox-xs"
                       @if(old('transaction.is_incoming') === '1')
                           checked
                       @endif
                       id="is_incoming"/>
                {{ __('Incoming') }}
            </x-label>
        </div>

        <div class="form-control w-full max-w-xs mx-auto">
            <x-label for="amount">{{ __('Amount') }}</x-label>
            <input class="input-md"
                   id="amount"
                   type="text"
                   name="amount"
                   value="{{ old('amount') }}"
                   required
                   autofocus/>

            @error('amount')
            <span class="text-sm text-error"
                  role="alert">
                    *{{ $message }}
                 </span>
            @enderror
        </div>

        <div class="form-control w-full max-w-xs mx-auto">
            <x-label for="reference">{{ __('Reference') }}</x-label>
            <input class="input-md"
                   id="reference"
                   type="text"
                   name="reference"
                   value="{{ old('reference') }}"
                   required
                   autofocus/>

            @error('reference')
            <span class="text-sm text-error"
                  role="alert">
                    *{{ $message }}
                 </span>
            @enderror
        </div>

        <div class="form-control w-full max-w-xs mx-auto">
            <x-label for="payer">{{ __('Payer') }}</x-label>
            <input class="input-md"
                   id="payer"
                   type="text"
                   name="payer"
                   value="{{ old('payer') }}"
                   autofocus/>

            @error('payer')
            <span class="text-sm text-error"
                  role="alert">
                    *{{ $message }}
                 </span>
            @enderror
        </div>

        <div class="form-control w-full max-w-xs mx-auto">
            <x-label for="beneficiary">{{ __('Beneficiary') }}</x-label>
            <input class="input-md"
                   id="beneficiary"
                   type="text"
                   name="beneficiary"
                   value="{{ old('beneficiary') }}"
                   autofocus/>

            @error('beneficiary')
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
