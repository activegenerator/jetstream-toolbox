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
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center border border-gray-300 shadow-sm font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 ' . $size]) }}>
    {{ $slot }}
</button>
