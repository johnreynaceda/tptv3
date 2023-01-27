<div>
    <div class="border border-gray-300 rounded-md">
        <x-card shadow="shadow-none"
            title="Program Choice">
            <form class="space-y-5">
                @csrf
                <div x-data="{ expanded: false }"
                    id="first_choice"
                    class="space-y-3">
                    <div class="flex items-center space-x-3">
                        <x-button x-on:click="expanded=!expanded"
                            sm>
                            <svg x-bind:class="expanded ? 'rotate-90 ease-in-out duration-150' : 'ease-in-out duration-150'"
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5"
                                viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10.293 15.707a1 1 0 010-1.414L14.586 10l-4.293-4.293a1 1 0 111.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                                <path fill-rule="evenodd"
                                    d="M4.293 15.707a1 1 0 010-1.414L8.586 10 4.293 5.707a1 1 0 011.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </x-button>
                        <h1 class="font-semibold "> First Priority Program : {{ $f_program_name }}
                        </h1>
                    </div>
                    <div x-cloak
                        x-show="expanded"
                        x-collapse
                        class="space-y-3">
                        @foreach ($campuses as $campus)
                            <fieldset>
                                <legend class="text-lg font-medium text-gray-900">{{ $campus->name }}</legend>
                                <div class="mt-4 space-y-2 border-t border-b border-gray-200 divide-y divide-gray-200">
                                    @foreach ($campus->programs->where('is_offered', 1) as $key => $program)
                                        <div wire:key="{{ $key }}"
                                            class="flex items-center">
                                            @if (auth()->user()->step == '2')
                                                <input id="input-{{ $key }}"
                                                    wire:model="first_priority_program"
                                                    name="input-{{ $key }}"
                                                    value="{{ $program->id }}"
                                                    @checked($program->id == $first_priority_program)
                                                    type="radio"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                            @endif
                                            <label for="push"
                                                class="block ml-3 text-sm font-medium text-gray-700">
                                                {{ $program->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </fieldset>
                        @endforeach
                    </div>
                </div>
                @if (auth()->user()->type_id == 1)
                    <div x-data="{ expanded: false }"
                        id="second_choice"
                        class="space-y-3">
                        <div class="flex items-center space-x-3">
                            <x-button x-on:click="expanded=!expanded"
                                sm>
                                <svg x-bind:class="expanded ? 'rotate-90 ease-in-out duration-150' : 'ease-in-out duration-150'"
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5"
                                    viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10.293 15.707a1 1 0 010-1.414L14.586 10l-4.293-4.293a1 1 0 111.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                    <path fill-rule="evenodd"
                                        d="M4.293 15.707a1 1 0 010-1.414L8.586 10 4.293 5.707a1 1 0 011.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </x-button>
                            <h1 class="font-semibold "> Second Priority Program : {{ $s_program_name }}
                            </h1>
                        </div>
                        <div x-cloak
                            x-show="expanded"
                            x-collapse
                            class="space-y-3">
                            @foreach ($campuses as $campus)
                                <fieldset>
                                    <legend class="text-lg font-medium text-gray-900">{{ $campus->name }}</legend>
                                    <div
                                        class="mt-4 space-y-2 border-t border-b border-gray-200 divide-y divide-gray-200">
                                        @foreach ($campus->programs->where('is_offered', 1) as $key => $program)
                                            <div wire:key="{{ $key }}"
                                                class="flex items-center">
                                                @if (auth()->user()->step == '2')
                                                    <input id="input-{{ $key }}"
                                                        wire:model="second_priority_program"
                                                        name="input-{{ $key }}"
                                                        value="{{ $program->id }}"
                                                        type="radio"
                                                        @checked($program->id == $second_priority_program)
                                                        class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                                @endif
                                                <label for="push"
                                                    class="block ml-3 text-sm font-medium text-gray-700">
                                                    {{ $program->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </fieldset>
                            @endforeach
                        </div>
                    </div>
                @endif
            </form>
            <x-slot name="footer">
                <div class="flex justify-end">
                    @if (auth()->user()->step == '2')
                        <x-button positive
                            wire:click="submutApplication">
                            Submit application
                        </x-button>
                    @endif
                </div>
            </x-slot>
        </x-card>
    </div>
</div>
