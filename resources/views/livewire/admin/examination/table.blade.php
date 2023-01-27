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
                Create Examination
            </x-button>
        </x-slot>
        <x-slot name="heading">
            <x-table.head title="Manage" />
            <x-table.head title="Title" />
            <x-table.head title="School Year" />
            <x-table.head title="start at" />
            <x-table.head title="end at" />
            <x-table.head title="Status" />
            <x-table.head title="" />
        </x-slot>
        <x-slot name="body">
            @forelse ($examinations as $examination)
                <x-table.row>
                    <x-table.data>
                        <x-button positive
                            href="{{ route('admin.manage-examination.applications', ['id' => $examination->id]) }}"
                            label="Manage" />
                    </x-table.data>
                    <x-table.data>
                        {{ $examination->title }}
                    </x-table.data>
                    <x-table.data>
                        {{ $examination->school_year }}
                    </x-table.data>
                    <x-table.data>
                        {{ $examination->date_start }}
                    </x-table.data>
                    <x-table.data>
                        {{ $examination->date_end }}
                    </x-table.data>
                    <x-table.data>
                        @if ($examination->is_active)
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                ACTIVE </span>
                        @else
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                INACTIVE </span>
                        @endif
                    </x-table.data>
                    <x-table.data>
                        <div class="flex justify-end space-x-3">
                            <x-button flat
                                x-on:click="$wire.edit({{ $examination->id }})"
                                icon="pencil" />
                            <x-button flat
                                x-on:click="$wire.delete({{ $examination->id }})"
                                icon="trash" />
                            @if (!$examination->is_active)
                                <x-button positive
                                    outline
                                    x-on:click="$wire.activate({{ $examination->id }})"
                                    label="ACTIVATE" />
                            @else
                                <x-button negative
                                    outline
                                    x-on:click="$wire.deactivate({{ $examination->id }})"
                                    label="DEACTIVATE" />
                            @endif
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
            {{ $examinations->links() }}
        </x-slot>
    </x-table.main>
</div>
