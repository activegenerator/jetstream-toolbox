@props(['label' => ''])

<div x-data="{ open: false }" class="relative inline-block text-left z-10 text-sm">
    <button @click="open = true"
        style="min-width: 150px;"
        class="flex p-2.5 bg-white border-gray-300 border focus:outline-none focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full"
        aria-haspopup="true" x-bind:aria-expanded="open" aria-expanded="true">
        {{ $label }}
        <x-box::icon.dropdown class="mr-auto" />
    </button>

    <div x-show="open"
        style="display: none;"
        class="absolute w-full bg-white border border-gray-200 rounded-md shadow-lg"
        @click.away="open = false"
        @click="open = false"
        @keydown.window.escape="open = false"
        @click.away="open = false"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0 transform scale-90"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-90"
        >
        {{ $slot }}
    </div>
</div>
