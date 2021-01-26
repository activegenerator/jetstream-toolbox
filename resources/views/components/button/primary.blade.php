@props([
    'size' => 'md',
])

@php
    $size = [
        'xs' => "text-xs px-2.5 py-1.5",
        'sm' => "text-sm px-3 py-2 leading-4",
        'md' => "text-sm px-4 py-2",
        'lg' => "text-base px-4 py-2",
        'xl' => "text-base px-6 py-3"
    ][$size];
@endphp

<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-wide hover:bg-indigo-500 active:bg-indigo-500 focus:outline-none focus:border-indigo-600 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 ' . $size]) }}>
    {{ $slot }}
</button>
