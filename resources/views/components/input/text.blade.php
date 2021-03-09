@props([
    'prefix' => null,
    'suffix' => null,
    'type' => 'text',
    'full' => '',
])

<div {{ $attributes->merge(['class' => 'relative border border-gray-300  rounded-md shadow-sm block'])->only('class') }}>
    @if($prefix)
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <span class="text-gray-600 sm:text-sm">
                {{ $prefix }}
            </span>
        </div>
    @endif
    <input type="{{ $type }}" {{ $attributes->except('class') }} class="w-full rounded-md border-0 focus:outline-none focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 {{ $prefix ? 'pl-8' : '' }} {{ $suffix ? 'pr-8' : '' }}" >
    @if($suffix)
    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
        <span class="text-gray-600 sm:text-sm">
            {{ $suffix }}
        </span>
    </div>
    @endif
</div>
