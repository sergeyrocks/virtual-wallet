@extends('layouts.app')

@section('content')
    <x-page-title>{{ __('Login') }}</x-page-title>
    <form method="POST" action="{{ route('login') }}" class="grid grid-cols-1 gap-4 py-6">
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
            <x-label for="remember" class="cursor-pointer select-none text-sm">
                <input type="checkbox"
                       name="remember"
                       class="checkbox checkbox-primary checkbox-xs"
                       id="remember" {{ old('remember') ? 'checked' : '' }}/>
                {{ __('Remember me') }}
            </x-label>
        </div>

        <div class="form-control w-full max-w-xs mx-auto">
            <button type="submit"
                    class="btn btn-primary">
                {{ __('Login') }}
            </button>
        </div>
    </form>
@endsection
