@props([
    'size' => 'md',
    'textColor' => 'white',
    'bgColor' => 'gray-700',
    'hoverColor' => 'gray-600',
    'tag' => 'button'
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

<{{ $tag }}
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-' . $bgColor . ' border border-transparent rounded-md font-semibold text-xs text-' . $textColor . ' uppercase tracking-wide  hover:bg-' . $hoverColor .' active:bg-' . $hoverColor .' focus:outline-none focus:border-' . $bgColor . ' focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 ' . $size]) }}>
    {{ $slot }}
</{{ $tag }}>
