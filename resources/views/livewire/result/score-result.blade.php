<div class="overflow-x-auto -mx-2 sm:mx-0">
    <div class="inline-block min-w-full sm:px-0 px-2">
        <table class="w-full text-sm print-table-compact">
            <thead>
                <tr class="bg-gray-50 text-center">
                    <th class="border border-gray-300 px-2 py-2 font-bold text-xs sm:text-sm">SUBJECT</th>
                    <th class="border border-gray-300 px-2 py-2 font-bold text-xs sm:text-sm">STANDARD SCORE</th>
                    <th class="border border-gray-300 px-2 py-2 font-bold text-xs sm:text-sm">STANINE</th>
                    <th class="border border-gray-300 px-2 py-2 font-bold text-xs sm:text-sm">QUALITATIVE INTERPRETATION</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border border-gray-300 px-2 py-1 text-xs sm:text-sm">ENGLISH</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold text-xs sm:text-sm">{{ $result->english_standard_score ?? '' }}</td>
                    <td class="border border-gray-300 px-2 py-1 text-center text-xs sm:text-sm">{{ $result->english_raw_score ?? '' }}</td>
                    <td class="border border-gray-300 px-2 py-1 text-xs sm:text-sm">{{ $this->scoreInterpretation($result->english_standard_score) }}</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 px-2 py-1 text-xs sm:text-sm">FILIPINO</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold text-xs sm:text-sm">{{ $result->filipino_standard_score ?? '' }}</td>
                    <td class="border border-gray-300 px-2 py-1 text-center text-xs sm:text-sm">{{ $result->filipino_raw_score ?? '' }}</td>
                    <td class="border border-gray-300 px-2 py-1 text-xs sm:text-sm">{{ $this->scoreInterpretation($result->filipino_standard_score) }}</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 px-2 py-1 text-xs sm:text-sm">MATHEMATICS</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold text-xs sm:text-sm">{{ $result->math_standard_score ?? '' }}</td>
                    <td class="border border-gray-300 px-2 py-1 text-center text-xs sm:text-sm">{{ $result->math_raw_score ?? '' }}</td>
                    <td class="border border-gray-300 px-2 py-1 text-xs sm:text-sm">{{ $this->scoreInterpretation($result->math_standard_score) }}</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 px-2 py-1 text-xs sm:text-sm">SCIENCE</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold text-xs sm:text-sm">{{ $result->science_standard_score ?? '' }}</td>
                    <td class="border border-gray-300 px-2 py-1 text-center text-xs sm:text-sm">{{ $result->science_raw_score ?? '' }}</td>
                    <td class="border border-gray-300 px-2 py-1 text-xs sm:text-sm">{{ $this->scoreInterpretation($result->science_standard_score) }}</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 px-2 py-1 text-xs sm:text-sm">SOCIAL STUDIES</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold text-xs sm:text-sm">{{ $result->social_studies_standard_score ?? '' }}</td>
                    <td class="border border-gray-300 px-2 py-1 text-center text-xs sm:text-sm">{{ $result->social_studies_raw_score ?? '' }}</td>
                    <td class="border border-gray-300 px-2 py-1 text-xs sm:text-sm">{{ $this->scoreInterpretation($result->social_studies_standard_score) }}</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 px-2 py-1 font-bold text-xs sm:text-sm">OVERALL</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold text-xs sm:text-sm">{{ $result->total_standard_score ?? '' }}</td>
                    <td class="border border-gray-300 px-2 py-1 text-center text-xs sm:text-sm">{{ $result->total_raw_score ?? '' }}</td>
                    <td class="border border-gray-300 px-2 py-1 text-xs sm:text-sm">{{ $this->scoreInterpretation($result->total_standard_score) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


