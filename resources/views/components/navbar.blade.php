
<div class="navbar bg-base-100 max-w-screen-xl mx-auto" x-data="{open: false}">
    <div class="flex-1">
        <a href="{{ url('/') }}" class="btn btn-ghost normal-case text-xl">{{ config('app.name') }}</a>
    </div>
    <div class="md:hidden">
        <button
            type="button"
            class="mr-2"
            @click="open = true">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
            </svg>
        </button>
    </div>
    <div class="hidden flex flex-col fixed bg-white z-10 w-80 right-0 top-0 h-[100vh] drop-shadow-2xl md:block md:static md:bg-none md:w-auto md:right-auto md:top-auto md:h-auto md:z-auto md:menu md:drop-shadow-none"
         :class="{ 'hidden': !open }"
    >
        <button
            type="button"
            @click="open = false"
            class="mt-4 ml-auto mr-4 md:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
            </svg>
        </button>
        <ul class="flex flex-col overflow-y-auto h-full w-full p-4 pt-20 md:h-auto md:w-auto md:p-0 md:flex-none md:menu-horizontal">
            @guest
                <li class="px-2 py-6 text-center text-xl uppercase md:p-0 md:text-right md:text-base md:normal-case">
                    <a href="{{ route('login') }}"
                       class="border-b border-black md:border-none">
                        {{ __('Login') }}
                    </a>
                </li>
                <li class="px-2 py-6 text-center text-xl uppercase md:p-0 md:text-right md:text-base md:normal-case">
                    <a href="{{ route('register') }}"
                       class="border-b border-black md:border-none">
                        {{ __('Register') }}
                    </a>
                </li>
            @else
                <li class="px-2 py-6 text-center text-xl uppercase md:p-0 md:text-right md:text-base md:normal-case">
                    <a href="{{ route('home') }}"
                       class="border-b border-black md:border-none">
                        Wallets
                    </a>
                </li>
                <li class="px-2 py-6 text-center text-xl uppercase md:p-0 md:text-right md:text-base md:normal-case">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="border-b border-black text-center text-xl uppercase md:border-none md:text-right md:text-base md:normal-case">
                            {{ __('Logout') }}
                        </button>
                    </form>
                </li>
            @endguest
        </ul>
    </div>
</div>
