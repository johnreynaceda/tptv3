<div>
    <x-button wire:click="$set('download_modal',true)">
        <svg xmlns="http://www.w3.org/2000/svg"
            class="h-5 text-green-600"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2">
            <path stroke-linecap="round"
                stroke-linejoin="round"
                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
        </svg>
        Download Result
    </x-button>

    <div id="download_result"
        x-data="{ download: '' }">
        <x-modal.card wire:model.defer="download_modal"
            title="Download Examination Result">
            <div class="grid space-y-3">
                <x-button wire:click="downloadAll"
                    spinner="downloadAll"
                    icon="download">
                    All result
                </x-button>
                <x-button x-on:click="download='p'"
                    icon="download"
                    x-bind:class="download == 'p' ? 'border-green-600' : ''">
                    All result per program
                </x-button>
                <div x-show="download=='p'"
                    x-cloak
                    x-collapse
                    id="program_list">
                    <x-card shadow="shadow-none"
                        class="border rounded-md">
                        <form class="grid pb-2 space-y-2">
                            @csrf
                            <x-native-select label="Select Program"
                                wire:model="selected_program">
                                <option value="">Select</option>
                                @foreach ($programs as $program)
                                    <option value="{{ $program->id }}">{{ $program->name }}</option>
                                @endforeach
                            </x-native-select>
                            <x-input label="File name"
                                wire:model.defer="file_name"
                                placeholder="Create file name" />
                        </form>
                        <div class="flex justify-end pt-2">
                            <x-button wire:click="downloadPerProgram"
                                spinner="downloadPerProgram"
                                positive>
                                Download
                            </x-button>
                        </div>
                    </x-card>
                </div>
                <x-button wire:click="downloadPerCampus"
                    icon="download">
                    All result per campus
                </x-button>
            </div>
        </x-modal.card>
    </div>
</div>
