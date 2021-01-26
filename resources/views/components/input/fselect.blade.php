@props([
    'multi' => false,
    'options' => []
])
<div
                x-data="select({
                    data: {{ $options }},
                    emptyOptionsMessage: 'No match for your search.',
                    name: '', placeholder: 'Select an item',
                    value: @entangle($attributes->wire('model')),
                    multi: {{ $multi ? 'true' : 'false' }}
                })"
                wire:ignore
                x-init="init();"
                @click.prevent.away="closeListbox()"
                @keydown.escape="closeListbox()"
                class="relative"
        >

                <span class="inline-block w-full rounded-md shadow-sm">
                      <button
                              x-ref="button"
                              @click.prevent="toggleListboxVisibility()"
                              :aria-expanded="open"
                              aria-haspopup="listbox"
                              class="relative z-0 w-full py-2 pl-3 pr-10 text-left transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md cursor-default focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5"
                      >
                            <span
                                    {{-- x-show="! open" --}}
                                    {{-- :class="{ 'text-gray-500': ! options.some(x => x.key == value) }" --}}
                                    class="inline-flex truncate space-y-1 flex-wrap"
                            >
                                <template x-for="(option, index) in getSelectedOptions()" :key="option.key" >
                                    <span class="inline-flex space-x-1 bg-gray-100 border rounded items-center px-2 mr-1">
                                        <span x-text="option.label"></span>
                                        <x-box::icon.x height="4" width="4" @click.prevent.stop="removeOption(option.key)"></x-box::icon.x>
                                    </span>

                                </template>
                            </span>

                            <input
                                    x-ref="search"
                                    x-show="open"
                                    x-model="search"
                                    @keydown.enter.stop.prevent="selectOption()"
                                    @keydown.arrow-up.prevent="focusPreviousOption()"
                                    @keydown.arrow-down.prevent="focusNextOption()"
                                    @keydown.backspace="removeLastSelected()"
                                    type="text"
                                    {{ $attributes }}
                                    class="inline-flex  h-full form-control focus:outline-none border-0 focus:border-0 focus:ring-0 p-0"
                            />

                            <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                                    <path d="M7 7l3-3 3 3m0 6l-3 3-3-3" stroke-width="1.5" stroke-linecap="round"
                                          stroke-linejoin="round"></path>
                                </svg>
                            </span>
                      </button>
                </span>

            <div
                    x-show="open"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    x-cloak
                    class="absolute z-10 w-full mt-1 bg-white rounded-md shadow-lg"
            >
                <ul
                        x-ref="listbox"
                        @keydown.enter.stop.prevent="selectOption()"
                        @keydown.arrow-up.prevent="focusPreviousOption()"
                        @keydown.arrow-down.prevent="focusNextOption()"
                        role="listbox"
                        :aria-activedescendant="focusedOptionIndex ? name + 'Option' + focusedOptionIndex : null"
                        tabindex="-1"
                        class="py-1 overflow-auto text-base leading-6 rounded-md shadow-xs max-h-32 focus:outline-none sm:text-sm sm:leading-5"
                >
                    <template x-for="(item, index) in options" :key="index">
                        <li
                                :id="name + 'Option' + focusedOptionIndex"
                                @click.prevent="selectOption()"
                                @mouseenter="focusedOptionIndex = index"
                                @mouseleave="focusedOptionIndex = null"
                                role="option"
                                :aria-selected="focusedOptionIndex === index"
                                :class="{ 'text-white bg-indigo-600': index === focusedOptionIndex, 'text-gray-900': index !== focusedOptionIndex }"
                                class="relative py-2 pl-3 text-gray-900 cursor-default select-none pr-9"
                        >
                                <span x-text="options[index].label"
                                      :class="{ 'font-semibold': index === focusedOptionIndex, 'font-normal': index !== focusedOptionIndex }"
                                      class="block font-normal truncate"
                                ></span>

                            <span
                                    x-show="item.key === value"
                                    :class="{ 'text-white': index === focusedOptionIndex, 'text-indigo-600': index !== focusedOptionIndex }"
                                    class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600"
                            >
                                    <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                              d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                </span>
                        </li>
                    </template>

                    <div
                            x-show="! Object.keys(options).length"
                            x-text="emptyOptionsMessage"
                            class="px-3 py-2 text-gray-900 cursor-default select-none"></div>
                </ul>
            </div>
        </div>

        <script>
            function select(config) {
                return {
                    data: config.data,
                    emptyOptionsMessage: config.emptyOptionsMessage ?? 'No results match your search.',
                    focusedOptionIndex: null,
                    name: config.name,
                    open: false,
                    options: {},
                    placeholder: config.placeholder ?? 'Select an option',
                    search: '',
                    multi: !!config.multi,
                    value: config.value,
                    selectedOptions: [],
                    render: 0,
                    closeListbox: function () {
                        this.open = false
                        this.focusedOptionIndex = null
                        this.search = ''
                    },
                    focusNextOption: function () {
                        if (this.focusedObjectIndex === null) return this.focusedObjectIndex = this.options.length - 1
                        if (this.focusedOptionIndex + 1 >= this.options.length) return
                        this.focusedOptionIndex++
                        this.$refs.listbox.children[this.focusedOptionIndex].scrollIntoView({
                            block: "center",
                        })
                    },
                    focusPreviousOption: function () {
                        if (this.focusedObjectIndex === null) return this.focusedObjectIndex = 0
                        if (this.focusedOptionIndex <= 0) return
                        this.focusedOptionIndex--
                        this.$refs.listbox.children[this.focusedOptionIndex].scrollIntoView({
                            block: "center",
                        })
                    },
                    init: function () {
                        console.log(this.render)
                        // // debugger
                        this.options = this.getOptions()
                        this.render = this.render + 1
                        // if (!(this.value in this.options)) this.value = null

                        this.$watch('search', ((value) => {
                            if (!this.open || !value) return this.options = this.getOptions()
                            this.options = this.getOptions()
                                .filter((item) => item.label.toLowerCase().includes(value.toLowerCase()))
                        }))
                    },
                    getOptions: function() {
                        return this.data
                            // .filter(x => !(this.multi && this.value && this.value.indexOf(x.key) > 0 || x.key === this.value))
                    },
                    selectOption: function () {
                        if (!this.open) return this.toggleListboxVisibility()
                        if (this.multi) {
                            if (!this.value) {
                                this.value = []
                            }
                            this.value.push(this.options[this.focusedOptionIndex].key)
                        } else {
                            this.value = this.options[this.focusedOptionIndex].key
                        }
                        this.closeListbox()
                    },
                    removeOption: function(key) {
                        if (this.multi) {
                            this.value.splice(this.value.indexOf(key), 1);
                        } else {
                            this.value = null
                        }
                    },
                    removeLastSelected: function() {
                        if (this.search == '') {
                            if (this.multi) {
                                this.removeOption(this.value[this.value.length - 1])
                            }
                        }
                    },
                    getSelectedOptions: function() {
                        // console.log(this.value)
                        if (this.multi) {
                            return this.options.filter(x => Array.isArray(this.value) && this.value.indexOf(x.key) >= 0)
                        }

                        return this.options.find(x => x.key === this.value) ? [this.options.find(x => x.key === this.value)] : []
                    },
                    selectedOptionsText: function() {
                        return this.selectedOptions().map(x => `<span>${x.label}</span>`)
                    },
                    toggleListboxVisibility: function () {
                        if (this.open) return this.closeListbox()
                        this.focusedOptionIndex = this.options ? this.options.map(x => x.key).indexOf(this.value) : -1
                        if (this.focusedOptionIndex < 0) this.focusedOptionIndex = 0
                        this.open = true
                        this.$nextTick(() => {
                            this.$refs.search.focus()
                            this.$refs.listbox.children[this.focusedOptionIndex].scrollIntoView({
                                block: "nearest"
                            })
                        })
                    },
                }
            }
        </script>
