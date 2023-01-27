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
    <div class="my-10">
        <livewire:applicant.payment-section />
    </div>
</x-layout.applicant>
