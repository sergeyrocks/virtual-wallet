<div class="navbar bg-base-100">
    <div class="flex-1">
        <a href="{{ url('/') }}" class="btn btn-ghost normal-case text-xl">{{ config('app.name') }}</a>
    </div>
    <div class="hidden fixed bg-white z-10 w-60 right-0 top-0 h-[100vh] md:block md:static md:bg-none md:w-auto md:right-auto md:top-auto md:h-auto md:z-auto md:menu">
        <ul class="h-full w-full p-4 md:h-auto md:w-auto md:p-0 md:flex-none md:menu-horizontal">
            @guest
                <li>
                    <a href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                <li>
                    <a href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
            @else
                <li>
                    <a href="{{ route('home') }}">Wallets</a>
                </li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-link">
                        {{ __('Logout') }}
                    </button>
                </form>
            @endguest
        </ul>
    </div>
</div>
