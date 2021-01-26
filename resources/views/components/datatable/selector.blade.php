@props([
    'selected' => [],
    'rows' => null,
    'name' => 'rows',
    'onSelectAll' => 'selectAll',
    'onDeselectAll' => 'deselectAll'
])

@if(count($selected) > 0 && $rows)
<x-box::table.row wire:loading.class.delay="opacity-50" class="bg-gray-100 text-sm" wire-key="row-msg">
    <x-box::table.cell colspan="100%">
        <div class="relative">
            <span>You selected
                <strong>{{ count($selected) }}</strong>
                <span> of </span>
                <strong>{{ $rows->total() }}</strong>
                <span>{{ $name }}.</span>
            </span>

            <x-box::button.link wire:click="{{ $onSelectAll }}" class="text-blue-700 pl-1">Add all to selection</x-box::button>
            <x-box::button.link wire:click="{{ $onDeselectAll }}" class="text-gray-700 absolute right-1">
                <x-box::icon.x></x-box::icon.x>
            </x-box::button>
        </div>
    </x-box::table.cell>
</x-box::table.row>
@endif

