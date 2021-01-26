@props([
    'label',
    'labelClass' => false,
    'labelWidth' => '1/4',
    'for',
    'error' => false,
    'helpText' => false,
    'vertical' => false
])

@php
    $breuk = explode("/", $labelWidth);
    $labelWidthOpposite = $breuk[1] - $breuk[0] . "/" . $breuk[1];
@endphp


<div {{ $attributes->merge(['class' => ($vertical ? 'w-full flex-col md:flex-row flex items-center' : 'flex flex-col')]) }}>
    @if($label)
        <label for="{{ $for }}" class="mb-1 block text-sm font-medium text-gray-700 {{ $labelClass }} {{ $vertical ? 'w-full md:w-' . $labelWidth : '' }}">{{ $label }}</label>
    @endif
    <div class="{{ $vertical ? 'w-full md:w-' . $labelWidthOpposite : 'w-full' }}">
    {{ $slot }}
    </div>
    @if ($error)
        <div class="mt-1 text-red-500 text-sm">{{ $error }}</div>
    @endif

    @if ($helpText)
        <p class="mt-2 text-sm text-gray-500">{{ $helpText }}</p>
    @endif
</div>
