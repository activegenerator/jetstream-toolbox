@props([
    'show' =>  false,
    'onResetFilters' => 'resetFilters'
])

@php
    $colSize = "w-1/2";
    if (isset($col1) && isset($col2) && isset($col3)) {
        $colSize = "w-1/3";
    }
@endphp

<div>
    @if($show)
        <div class="bg-gray-100 p-4 rounded border shadow-sm flex relative space-x-6">
            @if (isset($col1))
                <div class="{{ $colSize }} pr-2 space-y-4">
                    {{ $col1 }}

                    <x-box::button.link wire:click="{{ $onResetFilters }}" class="">Reset Filters</x-box::button.link>
                </div>
            @endif

            @if (isset($col2))
                <div class="{{ $colSize }} pr-2 space-y-4">
                    {{ $col2 }}
                </div>
            @endif

            @if (isset($col3))
                <div class="{{ $colSize }} pr-2 space-y-4">
                    {{ $col3 }}
                </div>
            @endif


        </div>
    @endif
</div>
