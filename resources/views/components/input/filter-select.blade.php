@props([
    'placeholder' => null,
    'trailingAddOn' => null
])

<div x-data="picker()" x-init="init()" class="relative flex flex-col border border-gray-300 shadow-sm p-2 rounded-md">
  <div class="absolute top-4 right-4 z-10 cursor-pointer" wire:click="$refresh">
      <x-box::icon.refresh />
  </div>
  <x-box::input.text x-ref="search" x-model="search" type="text" class="block w-full mb-2" placeholder="{{ __('Search..') }}" />
  <div x-ref="slot" class="max-h-32 overflow-y-auto w-full p-1.5 rounded">
    {{ $slot }}
  </div>
</div>

<script>

function picker() {
    return {
        search: '',
        visible: [],
        init() {
            // this.filter()
            this.$watch('search', search => {
                this.filter()
                // console.log(JSON.stringify(this.visible))
            })
        },
        filter() {
            this.visible = Array.from(this.$refs.slot.children)
                .filter(x => x.textContent.toLowerCase().indexOf(this.search.toLowerCase()) >= 0)
                // .map(x => {console.log(x.textContent.trim(), x.querySelector('[value]').value); return x})
                .map(x => x.querySelector('[value]').value)
        }
    }
}

</script>
