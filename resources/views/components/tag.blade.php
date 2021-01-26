
@props([
    'maxWidth' => null,
    'color' => 'indigo'
])

<span @if($maxWidth)style="max-width: {{ $maxWidth }}"@endif class="truncate x-2 inline-block text-xs font-semibold p-0.5 px-2.5 rounded-full bg-{{ $color }}-100 text-{{ $color }}-800 leading-5">
    {{ $slot }}
</span>
