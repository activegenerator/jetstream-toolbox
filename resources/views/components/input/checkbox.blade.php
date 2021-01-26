@props([
    'color' => 'indigo-600',
])

<div class="flex">
    <input {{ $attributes->merge(['class' => 'text-' . $color .' focus:ring-' . $color .' border-gray-300 rounded shadow-sm focus:ring focus:ring-opacity-30    ']) }} type="checkbox">
</div>
