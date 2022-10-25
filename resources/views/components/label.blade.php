@props(['for' => ''])

<label for="{{ $for }}"
       class="label cursor-pointer">
    <span class="label-text">{{ $slot }}</span>
</label>
