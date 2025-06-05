<div>
    <x-layout.admin>
        <div class="p-6">

            <div class="p-6">
                <h1 class="text-lg font-bold mb-4">List of Examinations With Results</h1>
                @if (session()->has('success'))
                    <div class="mb-2 text-green-600">{{ session('success') }}</div>
                @endif
                <table class="min-w-full bg-white border">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 border-b">Title</th>
                            <th class="px-4 py-2 border-b">School Year</th>
                            <th class="px-4 py-2 border-b">Date Start</th>
                            <th class="px-4 py-2 border-b">Date End</th>
                            <th class="px-4 py-2 border-b">Visibility Status</th>
                            <th class="px-4 py-2 border-b">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($examinations as $exam)
                            <tr>
                                <td class="px-4 py-2 border-b">{{ $exam->title }}</td>
                                <td class="px-4 py-2 border-b">{{ $exam->school_year }}</td>
                                <td class="px-4 py-2 border-b">{{ $exam->date_start }}</td>
                                <td class="px-4 py-2 border-b">{{ $exam->date_end }}</td>
                                <td class="px-4 py-2 border-b text-center">
                                    @if($exam->show_results)
                                    <span class="px-3 py-1 rounded-full  text-green-600">Public</span>
                                    @else
                                    <span class="px-3 py-1 rounded-full  text-red-600">Private</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 border-b text-center align-middle">
                                    <div class="flex  sm:flex-row sm:justify-center items-center gap-2">
                                        <!-- Toggle Visibility Button -->
                                        <button
                                            wire:click="confirmToggleResults({{ $exam->id }})"
                                            type="button"
                                            class="inline-flex items-center gap-x-1.5 rounded-md px-3 py-2 text-sm font-semibold text-white shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 {{ $exam->show_results ? 'bg-green-600 hover:bg-green-500 focus-visible:outline-green-600' : 'bg-red-600 hover:bg-red-500 focus-visible:outline-red-600' }}">
                                            <svg class="-ml-0.5 w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="ml-2">
                                                {{ $exam->show_results ? 'Hide from Public' : 'Show to Public' }}
                                            </span>
                                        </button>

                                        <!-- View Results Button -->
                                        <a href="{{ route('admin.examination-results', $exam->id) }}"
                                            class="inline-flex items-center gap-x-1.5 rounded-md bg-gray-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600"
                                            title="View Results">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-0.5 w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>
                                            <span class="ml-2">
                                                View Results
                                            </span>
                                        </a>
                                    </div>
                                </td>
                                
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-2 text-center">No examinations with results found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
        </div>
    </x-layout.admin>
</div>
