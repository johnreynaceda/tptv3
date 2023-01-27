<div>
    <x-table.main>
        <x-slot name="leftAction">
            <div class="flex">
                <x-input wire:model.debounce.500ms="search"
                    placeholder="Search" />
            </div>
        </x-slot>
        <x-slot name="rightAction">
            <x-button positive
                icon="plus"
                x-on:click="$dispatch('create');">
                Create Program
            </x-button>
        </x-slot>
        <x-slot name="heading">
            <x-table.head title="Name" />
            <x-table.head title="Campus" />
            <x-table.head title="Abbreviation" />
            <x-table.head title="" />
        </x-slot>
        <x-slot name="body">
            @forelse ($programs as $program)
                <x-table.row>
                    <x-table.data>
                        {{ $program->name }}
                    </x-table.data>
                    <x-table.data>
                        {{ $program->campus->name }}
                    </x-table.data>
                    <x-table.data>
                        {{ $program->abbreviation }}
                    </x-table.data>
                    <x-table.data>
                        <div class="flex justify-end space-x-3">
                            @if ($program->is_offered)
                                <x-button outline
                                    wire:click="remove({{ $program->id }})"
                                    negative
                                    label="REMOVE" />
                            @else
                                <x-button wire:click="add({{ $program->id }})"
                                    outline
                                    positive
                                    label="ADD" />
                            @endif
                            <x-button flat
                                x-on:click="$wire.edit({{ $program->id }})"
                                icon="pencil" />
                            <x-button flat
                                x-on:click="$wire.delete({{ $program->id }})"
                                icon="trash" />
                        </div>
                    </x-table.data>
                </x-table.row>
            @empty
                <x-table.row>
                    <x-table.data colspan="4">
                        <h1 class="text-center">
                            No examinations found.
                        </h1>
                    </x-table.data>
                </x-table.row>
            @endforelse
        </x-slot>
        <x-slot name="footer">
            {{ $programs->links() }}
        </x-slot>
    </x-table.main>
</div>
