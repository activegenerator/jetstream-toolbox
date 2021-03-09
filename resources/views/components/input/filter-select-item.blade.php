@props([
    'key' => '',
    'label' => ''
])

@php
$id = str_replace(" ", "", $label) . $key;
@endphp

<div class="flex items-center content-center" x-show="search.length === 0 || visible.indexOf('{{ ($key) }}') >= 0">
    <span wire:key="c{{ $id }}" x-show="Array.isArray(selected)">
        <div class="flex">
            <input id="c{{ $id }}" class="mr-3" value="{{ $key }}" x-model="selected" class="text-indigo-600 focus:ring-indigo-600 border-gray-300 rounded shadow-sm focus:ring focus:ring-opacity-30" type="checkbox">
        </div>
    </span>
    <span wire:key="r{{ $id }}" x-show="!Array.isArray(selected)">
        <div class="flex">
            <input class="mr-3" id="r{{ $id }}" value="{{ $key }}" x-model="selected" class="text-indigo-600 focus:ring-indigo-600 border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-opacity-30" type="radio">
        </div>
    </span>
    <label x-bind:for="Array.isArray(selected) ? 'c{{ $id }}' : 'r{{ $id }}'">{{ __($label) }}</label>
</div>
