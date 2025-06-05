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
                    <td class="border border-gray-300 px-2 py-1 text-xs sm:text-sm">{{ $this->stanineInterpretation($result->english_raw_score) }}</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 px-2 py-1 text-xs sm:text-sm">FILIPINO</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold text-xs sm:text-sm">{{ $result->filipino_standard_score ?? '' }}</td>
                    <td class="border border-gray-300 px-2 py-1 text-center text-xs sm:text-sm">{{ $result->filipino_raw_score ?? '' }}</td>
                    <td class="border border-gray-300 px-2 py-1 text-xs sm:text-sm">{{ $this->stanineInterpretation($result->filipino_raw_score) }}</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 px-2 py-1 text-xs sm:text-sm">MATHEMATICS</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold text-xs sm:text-sm">{{ $result->math_standard_score ?? '' }}</td>
                    <td class="border border-gray-300 px-2 py-1 text-center text-xs sm:text-sm">{{ $result->math_raw_score ?? '' }}</td>
                    <td class="border border-gray-300 px-2 py-1 text-xs sm:text-sm">{{ $this->stanineInterpretation($result->math_raw_score) }}</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 px-2 py-1 text-xs sm:text-sm">SCIENCE</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold text-xs sm:text-sm">{{ $result->science_standard_score ?? '' }}</td>
                    <td class="border border-gray-300 px-2 py-1 text-center text-xs sm:text-sm">{{ $result->science_raw_score ?? '' }}</td>
                    <td class="border border-gray-300 px-2 py-1 text-xs sm:text-sm">{{ $this->stanineInterpretation($result->science_raw_score) }}</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 px-2 py-1 text-xs sm:text-sm">SOCIAL STUDIES</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold text-xs sm:text-sm">{{ $result->social_studies_standard_score ?? '' }}</td>
                    <td class="border border-gray-300 px-2 py-1 text-center text-xs sm:text-sm">{{ $result->social_studies_raw_score ?? '' }}</td>
                    <td class="border border-gray-300 px-2 py-1 text-xs sm:text-sm">{{ $this->stanineInterpretation($result->social_studies_raw_score) }}</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 px-2 py-1 font-bold text-xs sm:text-sm">OVERALL</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold text-xs sm:text-sm">{{ $result->total_standard_score ?? '' }}</td>
                    <td class="border border-gray-300 px-2 py-1 text-center text-xs sm:text-sm">{{ $result->total_raw_score ?? '' }}</td>
                    <td class="border border-gray-300 px-2 py-1 text-xs sm:text-sm">{{ $this->stanineInterpretation($result->total_raw_score) }}</td>
                </tr>
                <tr>
                    <td colspan="4" class="border border-gray-300 px-2 py-1 text-xs sm:text-sm">
                        <div class="">
                            <span class="font-bold">Remarks:</span>
                            @php
                                $passedExam = isset($result->total_standard_score) && $result->total_standard_score >= 400;
                            @endphp

                            @if($result->total_standard_score >= 400)
                            <div class="text-xs italic text-justify text-gray-600 mt-1" style="text-indent:50px;">
                                Congratulations! You have passed the SKSU Tertiary Placement Test. Please refer to the table below and choose a degree program where you may qualify based on your score and submit yourself for an interview on a set schedule. Please bring the printed copy of the SKSU-TPT result, Grade 12 report card or transcript of record and any valid ID.
                            </div>
                            @else
                            <div class="text-xs italic text-justify text-gray-600 mt-1" style="text-indent:50px;">
                                Thank you for considering SKSU as your preferred institution but you are recommended to enroll in other institution of your choice.
                            </div>
                            @endif
                        </div>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</div>


