<div>
    <x-layout.admin>
    <div class="grid grid-cols-3 gap-4 p-6 ">

        
        <div class=" col-span-2 p-6 bg-white rounded-lg">

            <h1 class="text-xl font-bold mb-4">Results for: {{ $examination->title }}</h1>
            <div class="mb-4 flex flex-col sm:flex-row gap-2 sm:gap-4 items-center">
                <div class="relative w-full sm:w-80">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <!-- Search Icon: Heroicons (outline) -->
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103.5 10.5a7.5 7.5 0 0013.65 6.15z" />
                        </svg>
                    </span>
                    <input
                        wire:model.debounce.500ms="search"
                        type="text"
                        placeholder="Search by Full Name or Examinee Number"
                        class="pl-10 pr-4 py-3 border border-gray-300 rounded-lg shadow-sm w-full focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-base"
                    />
                </div>
               
            </div>
            
            <div class="flex flex-wrap gap-2 mb-4">
                <!-- Total Results -->
                <div class="flex-1 min-w-[120px] max-w-xs bg-white rounded-lg shadow px-4 py-3 flex flex-col justify-between">
                    <span class="text-gray-500 text-xs mb-0.5">Total Results</span>
                    <div class="flex items-end gap-1">
                        <span class="text-xl font-bold text-gray-800">{{ $stats['count'] }}</span>
                        <span class="text-xs text-green-600 font-medium flex items-center">
                            <svg class="w-3 h-3 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                            </svg>
                            +3.0%
                        </span>
                    </div>
                    <div class="text-[10px] text-gray-400 mt-1">vs last month</div>
                </div>
                <!-- Min Score -->
                <div class="flex-1 min-w-[120px] max-w-xs bg-white rounded-lg shadow px-4 py-3 flex flex-col justify-between">
                    <span class="text-gray-500 text-xs mb-0.5">Min Score</span>
                    <span class="text-xl font-bold text-gray-800">{{ $stats['min'] ?? 'N/A' }}</span>
                </div>
                <!-- Max Score -->
                <div class="flex-1 min-w-[120px] max-w-xs bg-white rounded-lg shadow px-4 py-3 flex flex-col justify-between">
                    <span class="text-gray-500 text-xs mb-0.5">Max Score</span>
                    <span class="text-xl font-bold text-gray-800">{{ $stats['max'] ?? 'N/A' }}</span>
                </div>
                <!-- Average -->
                <div class="flex-1 min-w-[120px] max-w-xs bg-white rounded-lg shadow px-4 py-3 flex flex-col justify-between">
                    <span class="text-gray-500 text-xs mb-0.5">Average</span>
                    <span class="text-xl font-bold text-gray-800">{{ $stats['average'] ?? 'N/A' }}</span>
                </div>
                <!-- Passers -->
                <div class="flex-1 min-w-[120px] max-w-xs bg-white rounded-lg shadow px-4 py-3 flex flex-col justify-between">
                    <span class="text-gray-500 text-xs mb-0.5">Passers</span>
                    <span class="text-xl font-bold text-teal-700">{{ $stats['passers'] }}</span>
                </div>
            </div>
            
            
            <div class="overflow-x-auto">
                <table class="min-w-full text-xs">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border px-2 py-1">#</th>
                            <th class="border px-2 py-1">Examinee #</th>
                            <th class="border px-2 py-1">Full Name</th>
                            <th class="border px-2 py-1">Total Score</th>
                            <th class="border px-2 py-1">Interpretation</th>
                        <th class="border px-2 py-1">Math</th>
                            <th class="border px-2 py-1">English</th>
                            <th class="border px-2 py-1">Filipino</th>
                            <th class="border px-2 py-1">Science</th>
                            <th class="border px-2 py-1">Soc. Stud.</th>
                            <th class="border px-2 py-1">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($results as $i => $result)
                        <tr class="even:bg-gray-50">
                            <td class="border px-2 py-1 text-center">{{ $results->firstItem() + $i }}</td>
                            <td class="border px-2 py-1">{{ $result->examinee_number }}</td>
                            <td class="border px-2 py-1">{{ $result->full_name }}</td>
                            <td class="border px-2 py-1 text-center font-bold">{{ $result->total_standard_score }}</td>
                            <td class="border px-2 py-1 text-center">{{ $this->scoreInterpretation($result->total_standard_score) }}</td>
                            <td class="border px-2 py-1 text-center">{{ $result->math_standard_score }}</td>
                            <td class="border px-2 py-1 text-center">{{ $result->english_standard_score }}</td>
                            <td class="border px-2 py-1 text-center">{{ $result->filipino_standard_score }}</td>
                            <td class="border px-2 py-1 text-center">{{ $result->science_standard_score }}</td>
                            <td class="border px-2 py-1 text-center">{{ $result->social_studies_standard_score }}</td>
                            <td class="border px-2 py-2 text-center ">
                                <a href="{{ route('admin.examinee-result-details', $result->id) }}" target="_blank" class="bg-gray-500 hover:bg-gray-600 text-white px-2 py-1  rounded hover:text-gray-200 hover:bg-gray-600 transition-all hover:scale-105 ">
                                    View Details
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="border px-2 py-4 text-center text-gray-500">No results found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                    </table>
                    </div>
                    
                    <!-- Pagination Links -->
                    <div class="mt-4">
                        {{ $results->links() }}
                    </div>
                    
                </table>
            </div>
            <div class="col-span-1">
                <livewire:result.single-score-guide />
            </div>
        </div>
    </div>
    </x-layout.admin>
</div>
