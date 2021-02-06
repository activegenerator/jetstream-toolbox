@props([
    'active',
    'borderColor' => 'blue-500'
])

<div x-data="{
        activeTab: '{{ $active }}',
        tabs: [],
        tabHeadings: [],
        toggleTabs() {
            this.tabs.forEach(
                tab => tab.__x.$data.showIfActive(this.activeTab)
            );
        }
     }"
     x-init="() => {
        tabs = [...$refs.tabs.children];
        tabHeadings = tabs.map((tab, index) => {
            tab.__x.$data.id = (index + 1);
            return tab.__x.$data.name;
        });
        toggleTabs();
     }"
>
    <div class="mb-3 border-b"
         role="tablist"
    >
        <template x-for="(tab, index) in tabHeadings"
                  :key="index"
        >
            <button x-text="tab"
                    type="button"
                    @click="console.log(tab);activeTab = tab; toggleTabs();"
                    {{ $attributes->merge(['class' => '-mb-px px-4 rounded-none py-2 text-sm focus:border-none focus:outline-none'])}}
                    :class="tab === activeTab ? 'border-b-2 border-{{ $borderColor }}' : 'text-gray-800'"
                    :id="`tab-${index + 1}`"
                    role="tab"
                    :aria-selected="(tab === activeTab).toString()"
                    :aria-controls="`tab-panel-${index + 1}`"
            ></button>
        </template>
    </div>

    <div x-ref="tabs">
        {{ $slot }}
    </div>
</div>
