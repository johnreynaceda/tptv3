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
                            <th class="px-4 py-2 border-b">Show Results</th>
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
                                    <button
                                        wire:click="toggleShowResults({{ $exam->id }})"
                                        class="px-3 py-1 rounded-full {{ $exam->show_results ? 'bg-green-500 text-white' : 'bg-gray-300 text-gray-700' }}">
                                        {{ $exam->show_results ? 'Visible' : 'Hidden' }}
                                    </button>
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
