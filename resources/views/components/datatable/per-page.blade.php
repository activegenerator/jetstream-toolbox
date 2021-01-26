@props([
    'pageProp' => 'perPage',
    'label' => 'Page size'
])

<x-box::dropdown label="{{ $label }}">
    <x-box::dropdown.item type="button" wire:click="$set('{{ $pageProp }}', 10)" class="flex items-center space-x-2">
        10
    </x-box::dropdown.item>
    <x-box::dropdown.item type="button" wire:click="$set('{{ $pageProp }}', 25)" class="flex items-center space-x-2">
        25
    </x-box::dropdown.item>
    <x-box::dropdown.item type="button" wire:click="$set('{{ $pageProp }}', 50)" class="flex items-center space-x-2">
        50
    </x-box::dropdown.item>
    <x-box::dropdown.item type="button" wire:click="$set('{{ $pageProp }}', 100)" class="flex items-center space-x-2">
        100
    </x-box::dropdown.item>
</x-box::dropdown>
