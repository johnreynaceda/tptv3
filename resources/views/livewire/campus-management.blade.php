<div class="max-w-7xl mx-auto">
    <div class="mt-8">

    </div>
    <x-table.main>
        <!-- Search Input -->
        <x-slot name="leftAction">
            <div class="flex">
                <x-input wire:model.debounce.500ms="search"
                    placeholder="Search campuses..." />
            </div>
        </x-slot>
        <!-- Create Button -->
        <x-slot name="rightAction">
            <x-button positive
                icon="plus"
                wire:click="openAddModal">
                Add Campus
            </x-button>
        </x-slot>
        <!-- Table Headings -->
        <x-slot name="heading">
            <x-table.head title="Actions" />
            <x-table.head title="Campus Name" />
        </x-slot>
        <!-- Table Body -->
        <x-slot name="body">
            @forelse ($campuses as $campus)
                <x-table.row>
                    <!-- Actions -->
                    <x-table.data>
                        <div class="flex space-x-3">
                            <x-button flat
                                wire:click="openEditModal({{ $campus->id }})"
                                icon="pencil"
                                label="Edit" />
                            {{-- <x-button flat
                                wire:click="deleteCampus({{ $campus->id }})"
                                icon="trash"
                                label="Delete" /> --}}
                        </div>
                    </x-table.data>
                    <!-- Campus Name -->
                    <x-table.data>
                        {{ $campus->name }}
                    </x-table.data>
                </x-table.row>
            @empty
                <!-- Empty State -->
                <x-table.row>
                    <x-table.data colspan="2">
                        <h1 class="text-center">
                            No campuses found.
                        </h1>
                    </x-table.data>
                </x-table.row>
            @endforelse
        </x-slot>
        <!-- Pagination -->
        <x-slot name="footer">
            {{ $campuses->links() }}
        </x-slot>
    </x-table.main>

    <!-- Manage Modal -->
    <x-modal wire:model.defer="manage_modal">
        <x-card title="{{ $isEditMode ? 'Edit Campus' : 'Add Campus' }}">
            <div>
                <x-input wire:model="name" label="Campus Name" placeholder="Enter campus name" />
                @error('name') <x-error :message="$message" /> @enderror
            </div>

            <x-slot name="footer">
                <div class="flex justify-end gap-x-4">
                    <x-button flat label="Close" wire:click="$set('manage_modal', false)" />
                    @if ($isEditMode)
                        <x-button positive wire:click="updateCampus" label="Update" />
                    @else
                        <x-button positive wire:click="createCampus" label="Save" />
                    @endif
                </div>
            </x-slot>
        </x-card>
    </x-modal>
</div>
