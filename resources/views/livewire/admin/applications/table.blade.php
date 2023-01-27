<div class="grid space-y-2">

    <x-table.main>
        <x-slot name="leftAction">
            <div class="flex space-x-3">
                <x-input wire:model.debounce.500ms="search"
                    placeholder="Search" />
                <x-native-select wire:model="type">
                    <option value="">All</option>
                    <option value="1">Freshmen</option>
                    <option value="2">Transferee</option>
                </x-native-select>

            </div>
        </x-slot>
        <x-slot name="rightAction">
            <x-button wire:click="$set('step',['4','5'])"
                label="All Application"
                class="{{ $step == ['4', '5'] ? 'border-theme' : '' }}" />
            <x-button wire:click="$set('step',['4'])"
                label="Payment Validation"
                class="{{ $step == ['4'] ? 'border-theme' : '' }}" />
            <x-button wire:click="$set('step',['5'])"
                label="Ready for Examination"
                class="{{ $step == ['5'] ? 'border-theme' : '' }}" />
        </x-slot>
        <x-slot name="heading">
            <x-table.head title="Name" />
            <x-table.head title="Program Choice" />
            <x-table.head title="Status" />
            <x-table.head title="" />
        </x-slot>
        <x-slot name="body">
            @forelse ($applications as $application)
                <x-table.row>
                    <x-table.data>
                        {{ $application->user->personal_information->first_name }}
                        {{ $application->user->personal_information->middle_name }}
                        {{ $application->user->personal_information->last_name }}
                        {{ $application->user->personal_information->extension }}
                    </x-table.data>
                    <x-table.data>
                        @foreach ($application->user->program_choices as $program_choice)
                            <span>
                                {{ $program_choice->program->name }}
                                @if ($program_choice->is_priority)
                                    <span class="text-green-600"> (Priority)</span>
                                @endif
                            </span>
                            <br>
                        @endforeach
                    </x-table.data>
                    <x-table.data>
                        @switch($application->user->step)
                            @case('4')
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Payment Validation
                                </span>
                            @break

                            @case('5')
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Ready for Examination
                                </span>
                            @break

                            @default
                        @endswitch
                    </x-table.data>
                    <x-table.data>
                        <div class="flex space-x-3">
                            <x-button flat
                                wire:click="select({{ $application->user->id }})"
                                spinner="select({{ $application->user->id }})">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5"
                                    viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </x-button>
                            <x-button flat
                                wire:click="viewInfo({{ $application->user->id }})"
                                spinner="viewInfo({{ $application->user->id }})"><svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5"
                                    viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd"
                                        d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                        clip-rule="evenodd" />
                                </svg> </x-button>
                        </div>
                    </x-table.data>
                </x-table.row>
                @empty
                    <x-table.row>
                        <x-table.data colspan="4">
                            <h1 class="text-center">
                                No Application Found
                            </h1>
                        </x-table.data>
                    </x-table.row>

                @endforelse

            </x-slot>
            <x-slot name="footer">
                {{ $applications->links() }}
            </x-slot>
        </x-table.main>
    </div>
