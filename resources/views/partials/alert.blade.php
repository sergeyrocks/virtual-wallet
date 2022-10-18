@if(session('alert'))
    <div class="px-5 my-4">
        <x-alert :type="session('alert')['type']">
            {{ session('alert')['message'] }}
        </x-alert>
    </div>
@endif
