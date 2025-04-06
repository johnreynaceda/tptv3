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
                        {{ optional($application->user->personal_information)->first_name ?? 'N/A' }}
                        {{ optional($application->user->personal_information)->middle_name ?? '' }}
                        {{ optional($application->user->personal_information)->last_name ?? '' }}
                        {{ optional($application->user->personal_information)->extension ?? '' }}
                    </x-table.data>
                    <x-table.data>
                        @forelse (optional($application->user)->program_choices ?? [] as $program_choice)
                            <span>
                                {{ optional($program_choice->program)->name ?? 'Unknown Program' }}
                                @if (optional($program_choice)->is_priority)
                                    <span class="text-green-600"> (Priority)</span>
                                @endif
                            </span>
                            <br>
                        @empty
                            <span class="text-gray-500">No programs selected</span>
                        @endforelse
                    </x-table.data>
                    <x-table.data>
                        @switch(optional($application->user)->step ?? '')
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
                            @if ($application->user->permit)
                            <x-button flat
                                wire:click="select({{ optional($application->user)->id ?? 0 }})"
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
                            @endif
                            <x-button flat
                                wire:click="viewInfo({{ optional($application->user)->id ?? 0 }})"
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


                                {{-- @if ($application->user->permit)

                                <a href="{{route('admin.generate-pdf-permit', ['permit' => $application->user->permit])}}" target="_blank"
                                   class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white rounded-md shadow-sm hover:bg-gray-100 hover:text-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="h-6 w-6"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor"
                                         stroke-width="2">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                    </svg>
                                    <span class="ml-2">Permit</span>
                                </a>


                            @endif --}}

                            @if ($application->user->permit)
                            <!-- Modal Trigger -->
                            <div x-data="{ isOpen: false }">
                                <x-button flat @click="isOpen = true" spinner>
                                    Permit
                                </x-button>

                                <!-- Modal -->
                                <template x-if="isOpen">
                                    <div>
                                        <!-- Background -->
                                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="isOpen = false" aria-hidden="true"></div>

                                        <!-- Modal Content -->
                                        <div class="fixed inset-0 z-10 flex items-center justify-center overflow-y-auto">
                                            <div x-show="isOpen"
                                                 x-transition
                                                 class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md mx-4 sm:mx-auto">
                                                <h3 class="text-lg font-semibold text-gray-800 mb-4 text-center">Permit Options</h3>
                                                <div class="flex gap-4">
                                                    <!-- View Button -->
                                                    <a href="{{ route('admin.permit.view', ['permit' => $application->user->permit]) }}"
                                                       target="_blank"
                                                       @click="isOpen = false"
                                                       class="flex items-center justify-center gap-2 flex-1 px-4 py-2 text-center bg-white text-green-600 border border-green-500 rounded-md hover:bg-green-100 transition">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12h3m-3 0h-3m-3 0h-3M9 12H6m9-9v3m0 3V6m0 6V9M3 21h18M3 15v6M3 21l3-6m15 6l-3-6" />
                                                        </svg>
                                                        View
                                                    </a>

                                                    <!-- Download Button -->
                                                    <a href="{{ route('admin.generate-pdf-permit', ['permit' => $application->user->permit]) }}"
                                                       target="_blank"
                                                       @click="isOpen = false"
                                                       class="flex items-center justify-center gap-2 flex-1 px-4 py-2 text-center bg-green-500 text-white rounded-md hover:bg-green-600 transition">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 21v-2m4 2v-4m4 4v-2M3 15h18M9 11V4a1 1 0 011-1h4a1 1 0 011 1v7m-6 0h6" />
                                                        </svg>
                                                        Download
                                                    </a>
                                                </div>


                                                <button @click="isOpen = false"
                                                        class="mt-6 w-full px-4 py-2 border bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400">
                                                    Close
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        @endif



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
