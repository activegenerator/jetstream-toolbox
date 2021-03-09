
@props([
    'maxWidth' => null,
    'bgColor' => 'gray-100',
    'textColor' => 'gray-800'
])

<span @if($maxWidth)style="max-width: {{ $maxWidth }}"@endif class="truncate x-2 inline-block text-xs font-semibold p-0.5 px-2.5 rounded-full bg-{{ $bgColor }} text-{{ $textColor }} leading-5">
    {{ $slot }}
</span>
