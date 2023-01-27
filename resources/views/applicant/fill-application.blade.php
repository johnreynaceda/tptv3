<x-layout.applicant>
    <template x-teleport="#menuContainer">
        <a type="button"
            class="flex items-center space-x-3"
            href="{{ route('applicant.home') }}">
            <svg xmlns="http://www.w3.org/2000/svg"
                class="w-8 h-8"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2">
                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span class="ml-3 text-lg text-gray-700">Back</span>
        </a>
    </template>
    <div x-data="{ current: 1 }"
        class="my-5 space-y-4"
        x-on:done-pi.window="current++"
        x-on:done-si.window="current++">
        <div class="flex justify-around">

            <nav x-data="{
                has_personal_information: {{ $has_personal_information }},
                has_school_information: {{ $has_school_information }},
                has_program_choice: {{ $has_program_choice }},
            }"
                class="flex items-center justify-center"
                x-on:done-pi.window="has_personal_information = 1"
                x-on:done-si.window="has_school_information = 1"
                x-on:done-pc.window="has_program_choice = 1"
                aria-label="Progress">
                <p class="text-sm font-medium">Form <span x-text="current"></span> of 3</p>
                <ol role="list"
                    class="flex items-center ml-8 space-x-5">
                    <li x-on:click="current=1">
                        <button class="block rounded-full"
                            x-bind:class="has_personal_information ? 'bg-theme w-4 h-4 ' : 'bg-gray-200 w-2.5 h-2.5'">
                            <span class="sr-only">Step 1</span>
                        </button>
                    </li>
                    <li x-on:click="has_personal_information ? current=2 : ''">
                        <button class="block rounded-full"
                            x-bind:class="has_school_information ? 'bg-theme w-4 h-4' : 'bg-gray-200 w-2.5 h-2.5'"
                            aria-current="step">
                            <span class="sr-only">Step 2</span>
                        </button>
                    </li>

                    <li x-on:click="has_school_information ? current=3 :''">
                        <button class="block rounded-full"
                            x-bind:class="has_program_choice ? 'bg-theme w-4 h-4' : 'bg-gray-200 w-2.5 h-2.5'"
                            aria-current="step">
                            <span class="sr-only">Step 2</span>
                        </button>
                    </li>
                </ol>
            </nav>

        </div>

        <div x-cloak
            x-show="current==1"
            x-collapse>
            <livewire:applicant.personal-info />
        </div>
        <div x-cloak
            x-show="current==2"
            x-collapse>
            <livewire:applicant.school-info :haspersonalinformation="$has_personal_information" />
        </div>
        <div x-cloak
            x-show="current==3"
            x-collapse>
            <livewire:applicant.program-info />
        </div>

        <div class="flex justify-around">
            <nav x-data="{
                has_personal_information: {{ $has_personal_information }},
                has_school_information: {{ $has_school_information }},
                has_program_choice: {{ $has_program_choice }},
            }"
                class="flex items-center justify-center"
                x-on:done-pi.window="has_personal_information = 1"
                x-on:done-si.window="has_school_information = 1"
                x-on:done-pc.window="has_program_choice = 1"
                aria-label="Progress">
                <p class="text-sm font-medium">Form <span x-text="current"></span> of 3</p>
                <ol role="list"
                    class="flex items-center ml-8 space-x-5">
                    <li x-on:click="current=1">
                        <button class="block rounded-full"
                            x-bind:class="has_personal_information ? 'bg-theme w-4 h-4 ' : 'bg-gray-200 w-2.5 h-2.5'">
                            <span class="sr-only">Step 1</span>
                        </button>
                    </li>
                    <li x-on:click="has_personal_information ? current=2 : ''">
                        <button class="block rounded-full"
                            x-bind:class="has_school_information ? 'bg-theme w-4 h-4' : 'bg-gray-200 w-2.5 h-2.5'"
                            aria-current="step">
                            <span class="sr-only">Step 2</span>
                        </button>
                    </li>

                    <li x-on:click="has_school_information ? current=3 :''">
                        <button class="block rounded-full"
                            x-bind:class="has_program_choice ? 'bg-theme w-4 h-4' : 'bg-gray-200 w-2.5 h-2.5'"
                            aria-current="step">
                            <span class="sr-only">Step 2</span>
                        </button>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</x-layout.applicant>
