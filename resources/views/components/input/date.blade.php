@props([
    'prefix' => null,
    'suffix' => null,
    'type' => 'text'
])

<div class="mt-1 relative rounded-md shadow-sm">
    <div class="absolute pt-0.5 inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
        <span class="text-gray-500 sm:text-sm">
            <x-box::icon.date/>
        </span>
    </div>
    <input type="{{ $type }}" {{ $attributes->merge(['class' => 'pl-9 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full']) }}>
    @if($suffix)
    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
        <span class="text-gray-500 sm:text-sm">
            {{ $suffix }}
        </span>
    </div>
    @endif
</div>
