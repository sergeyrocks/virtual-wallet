@props(['type'])
<?php
    $type = $type === 'error' ? 'alert-error' : 'alert-success';
?>
<div {{ $attributes->merge(['class' => 'shadow-lg max-w-sm mx-auto alert ' . $type]) }}>

    <div>
        @switch($type)
            @case('alert-success')
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                @break
            @case('alert-error')
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                @break
            @default
                @break
        @endswitch
        <span>{{ $slot }}</span>
    </div>
</div>
