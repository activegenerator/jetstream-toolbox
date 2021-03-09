@props([
    'showSearch' => true
])

<div wire:ignore.self x-data="selectBox({
    selected: @entangle($attributes->wire('model'))
})" x-init="init()" class="relative flex flex-col border border-gray-300 shadow-sm p-2 rounded-md">
    @if($showSearch)
    <x-box::input.text x-ref="search" x-model="search" type="text" class="block w-full mb-2" placeholder="{{ __('Search..') }}" />
    @endif

    <template x-if="Array.isArray(selected)">
        <div class="flex px-1">
        	<button x-on:click.prevent="selectAll">{{ __('Select all') }}</button>
        	<button class="ml-auto" x-on:click.prevent="unselectAll">{{ __('Unselect all') }}</button>
        </div>
    </template>

    <div x-ref="slot" class="max-h-28 overflow-y-auto w-full p-1.5 rounded">
        {{ $slot }}
    </div>
{{--
    <div x-text="JSON.stringify(selected)">

    </div> --}}
</div>

<script>
    function selectBox(options) {
        return {
            search: '',
            visible: [],
            selected: options.selected,
            selectAll() { this.selected = this.getItems() },
            unselectAll() { this.selected = []},
            init() {
                this.$watch('search', search => {
                    this.filter()
                })
            },
            filter() {
                this.visible = this.getItems()
            },
            getItems() {
                return Array.from(this.$refs.slot.children)
                    .filter(x => x.textContent.toLowerCase().indexOf(this.search.toLowerCase()) >= 0)
                    // .map(x => {console.log(x.textContent.trim(), x.querySelector('[value]').value); return x})
                    .map(x => x.querySelector('[value]').value)
            }
        }
    }
</script>
