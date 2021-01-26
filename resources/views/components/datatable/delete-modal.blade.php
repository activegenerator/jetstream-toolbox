@props([
    'selected' => [],
    'rows' => null,
    'name' => 'rows',
    'nameSingular' => 'row',
    'toggleProp' => 'showDeleteModal',
    'onSubmit' => 'deleteSelected'
])

<form wire:submit.prevent="deleteSelected">
    <x-jet-confirmation-modal wire:model.defer="{{ $toggleProp }}">
        <x-slot name="title">
            Delete {{ count($selected) }} {{ count($selected) === 1 ? $nameSingular : $name }}
        </x-slot>

        <x-slot name="content">
            Are you sure you want to delete the selected {{ $name }}?
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('{{ $toggleProp }}')" wire:loading.attr="disabled">
                Cancel
            </x-jet-secondary-button>

            <x-jet-danger-button type="submit" class="ml-2">
                Yes
            </x-jet-danger-button>
        </x-slot>

    </x-jet-confirmation-modal>
</form>
