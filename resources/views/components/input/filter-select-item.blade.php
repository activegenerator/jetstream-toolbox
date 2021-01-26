@props([
    'key' => null,
    'label' => null,
    'wireModel' => '',
    'multiple' => false
])

@php
$id = str_replace(" ", "", $label) . $key;
@endphp

<div class="flex items-center content-center" x-show="search.length === 0 || visible.indexOf('{{ ($key) }}') >= 0">
    @if($multiple)
        <x-box::input.checkbox class="mr-3" id="{{ $id }}" wire:model="{{ $wireModel }}" value="{{ $key }}" />
    @else
        <x-box::input.radio class="mr-3" id="{{ $id }}" wire:model="{{ $wireModel }}" value="{{ $key }}" />
    @endif

    <label for="{{ $id }}">{{ __($label) }}</label>
</div>
