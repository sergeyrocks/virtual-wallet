@extends('layouts.app')

@section('content')
    <x-page-title>{{ __('Register') }}</x-page-title>
    <form method="POST" action="{{ route('register') }}" class="grid grid-cols-1 gap-4 py-6">
        @csrf

        <div class="form-control w-full max-w-xs mx-auto">
            <x-label for="email">{{ __('E-Mail Address') }}</x-label>
            <input class="input-md"
                   id="email"
                   type="email"
                   name="email"
                   value="{{ old('email') }}"
                   required
                   autocomplete="email"
                   autofocus/>

            @error('email')
            <span class="text-sm text-error"
                  role="alert">
                    *{{ $message }}
                 </span>
            @enderror
        </div>

        <div class="form-control w-full max-w-xs mx-auto">
            <x-label for="password">{{ __('Password') }}</x-label>
            <input class="input-md"
                   id="password"
                   type="password"
                   name="password"
                   required
                   autocomplete="current-password"/>

            @error('password')
            <span class="text-sm text-error"
                  role="alert">
                    *{{ $message }}
                 </span>
            @enderror
        </div>

        <div class="form-control w-full max-w-xs mx-auto">
            <x-label for="password-confirm">
                {{ __('Confirm Password') }}
            </x-label>
            <input class="input-md"
                   id="password-confirm"
                   type="password"
                   name="password_confirmation"
                   required
                   autocomplete="new-password"/>
        </div>

        <div class="form-control w-full max-w-xs mx-auto">
            <button type="submit"
                    class="btn btn-primary">
                {{ __('Register') }}
            </button>
        </div>

    </form>
@endsection
