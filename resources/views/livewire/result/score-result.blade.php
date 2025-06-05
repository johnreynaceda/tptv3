<div class="overflow-x-auto -mx-2 sm:mx-0">
    <div class="inline-block min-w-full sm:px-0 px-2">
        <table class="min-w-full divide-y divide-gray-200 print-table-compact" style="page-break-inside: avoid;">
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
                @php
                  $allPrograms = [
    // Board Programs
    'Bachelor of Science in Medical Technology' => 650,
    'Bachelor of Science in Nursing' => 600,
    'Bachelor of Science in Accountancy' => 600,
    'Bachelor of Elementary Education' => 530,
    'Bachelor of Physical Education' => 530,
    'Bachelor of Secondary Education major in: English' => 530,
    'Bachelor of Secondary Education major in: Filipino' => 530,
    'Bachelor of Secondary Education major in: Mathematics' => 530,
    'Bachelor of Secondary Education major in: Science' => 530,
    'Bachelor of Secondary Education major in: Social Studies' => 530,
    'Bachelor of Science in Criminology' => 530,
    'Bachelor of Science in Civil Engineering' => 530,
    'Bachelor of Science in Computer Engineering' => 530,
    'Bachelor of Science in Electronics Engineering' => 530,
    'Bachelor of Science in Midwifery' => 530,

    // Non-Board Programs
    'Bachelor of Technology and Livelihood Education major in: Agri-fishery' => 500,
    'Bachelor of Science in Agriculture' => 500,
    'Bachelor of Science in Fisheries' => 500,
    'Bachelor of Technical Teacher Education major in: Automotive Technology' => 500,
    'Bachelor of Technical-Vocational Teacher Education major in: Civil Technology' => 500,
    'Bachelor of Technical-Vocational Teacher Education major in: Drafting Technology' => 500,
    'Bachelor of Technical-Vocational Teacher Education major in: Electrical Technology' => 500,
    'Bachelor of Technical-Vocational Teacher Education major in: Electronics Technology' => 500,
    'Bachelor of Technical-Vocational Teacher Education major in: Food and Service Management' => 500,
    'Bachelor of Science in Accounting Information System' => 475,
    'Bachelor of Science in Management Accounting' => 475,
    'Bachelor of Arts in Political Science' => 475,
    'Bachelor of Science in Hospitality Management' => 475,
    'Bachelor of Science in Tourism Management' => 475,
    'Bachelor of Science in Biology' => 450,
    'Bachelor of Arts in Economics' => 450,
    'Bachelor of Science in Entrepreneurship' => 450,
    'Bachelor of Science in Industrial Security Management' => 450,
    'Bachelor of Science in Environmental Science' => 400,
    'Bachelor of Science in Agribusiness' => 400,
    'Bachelor of Science in Computer Science' => 400,
    'Bachelor of Science in Information System' => 400,
    'Bachelor of Science in Information Technology' => 400,
    'Bachelor of Industrial Technology major in: Automotive Technology' => 400,
    'Bachelor of Industrial Technology major in: Civil and Construction Technology' => 400,
    'Bachelor of Industrial Technology major in: Architectural Drafting Technology' => 400,
    'Bachelor of Industrial Technology major in: Electrical Technology' => 400,
    'Bachelor of Industrial Technology major in: Electronics Technology' => 400,
    'Bachelor of Industrial Technology major in: Food Innovation and Culinary Technology' => 400,
];

$boardProgramsList = [
    'Bachelor of Science in Medical Technology',
    'Bachelor of Science in Nursing',
    'Bachelor of Science in Accountancy',
    'Bachelor of Elementary Education',
    'Bachelor of Physical Education',
    'Bachelor of Secondary Education major in: English',
    'Bachelor of Secondary Education major in: Filipino',
    'Bachelor of Secondary Education major in: Mathematics',
    'Bachelor of Secondary Education major in: Science',
    'Bachelor of Secondary Education major in: Social Studies',
    'Bachelor of Science in Criminology',
    'Bachelor of Science in Civil Engineering',
    'Bachelor of Science in Computer Engineering',
    'Bachelor of Science in Electronics Engineering',
    'Bachelor of Science in Midwifery',
];
                
                    $examineeScore = $result->total_standard_score ?? 0;
                
                    // Check if qualified for any board/non-board program
                    $qualifiedBoard = false;
                    $qualifiedNonBoard = false;
                    foreach ($allPrograms as $program => $cutoff) {
                        if ($examineeScore >= $cutoff) {
                            if (in_array($program, $boardProgramsList)) {
                                $qualifiedBoard = true;
                            } else {
                                $qualifiedNonBoard = true;
                            }
                        }
                    }
                @endphp
                
                <tr>
                    <td colspan="4" class="border border-gray-300 px-2 py-1 text-xs sm:text-sm">
                        <div class="flex items-start mb-1 flex">
                            <span class="font-bold">Remarks:</span>
                            <div class="ml-2 flex">
                                @if($qualifiedBoard && $qualifiedNonBoard)
                                    <div class="text-green-600 block ml-2">✓ Qualified for Board Program</div>
                                    <div class="text-green-600 block ml-2">✓ Qualified for Non-Board Program</div>
                                @elseif($qualifiedBoard)
                                    <div class="text-green-600 block ml-2">✓ Qualified for Board Program</div>
                                @elseif($qualifiedNonBoard)
                                    <div class="text-green-600 block ml-2">✓ Qualified for Non-Board Program</div>
                                @else
                                    <div class="text-red-600 ml-2">✗ Not qualified for any program</div>
                                @endif
                            </div>
                        </div>
                        <div class="text-xs italic text-justify text-gray-600 mt-1" style="text-indent:50px;">
                            @if($qualifiedBoard && $qualifiedNonBoard)
                            Congratulations! You have passed the SKSU Tertiary Placement Test. Please refer to the table below and choose
                            a degree program where you may qualify based on your score and submit yourself for an interview on a set schedule.
                            Please bring the printed copy of the SKSU-TPT result, Grade 12 report card or transcript of record and any valid ID. 
                            @elseif($qualifiedBoard)
                            Congratulations! You have passed the SKSU Tertiary Placement Test. Please refer to the table below and choose
                            a degree program where you may qualify based on your score and submit yourself for an interview on a set schedule.
                            Please bring the printed copy of the SKSU-TPT result, Grade 12 report card or transcript of record and any valid ID. 
                            @elseif($qualifiedNonBoard)
                            Congratulations! You have passed the SKSU Tertiary Placement Test. Please refer to the table below and choose
                            a degree program where you may qualify based on your score and submit yourself for an interview on a set schedule.
                            Please bring the printed copy of the SKSU-TPT result, Grade 12 report card or transcript of record and any valid ID. 
                            @else
                            Thank you for considering SKSU as your preferred institution,
                            but you are recommended to enroll in another institution of your choice.
                            @endif
                        </div>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</div>


