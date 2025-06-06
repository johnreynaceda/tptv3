<div>

    <x-layout.ordinary>

        <head>
            <title>Document</title>
            <script src="https://cdn.tailwindcss.com"></script>
        </head>
<div class="bg-white print:p-0 print:m-0">
    <style>
        /* Base styles */
        @page {
            margin: 1cm;
            size: A4;
        }

        body {
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            line-height: 1.4;
            color: #333;
            background: #fff;
            margin: 0;
            padding: 0;
        }

        /* Print container */
        .print-container {
            max-width: 21cm;
            margin: 0 auto;
            padding: 1cm;
        }

        /* Header styles */
        .header {
            text-align: center;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid #1a5f23;
            padding-bottom: 0.5rem;
        }

        .header img {
            height: 80px;
            margin: 0 15px;
        }

        .header h1 {
            margin: 0.5rem 0;
            letter-spacing: 1px;
        }

        /* Student info section */
        .student-info {
            display: flex;
            margin: 1.5rem 0;
            gap: 2rem;
        }

        .photo-container {
            width: 35mm;
            height: 45mm;
            border: 1px solid #ddd;
            overflow: hidden;
            flex-shrink: 0;
        }

        .student-details {
            flex-grow: 1;
        }

        .student-details h2 {
            color: #1a5f23;
            border-bottom: 2px solid #1a5f23;
            padding-bottom: 0.5rem;
            margin-bottom: 1rem;
        }

        /* Table styles */
        .print-table-compact {
            width: 100%;
            border-collapse: collapse;
            margin: 1.5rem 0;
            font-size: 11pt;
        }

        .print-table-compact th,
        .print-table-compact td {
            border: 1px solid #000;
            padding: 0.5rem;
            text-align: left;
            vertical-align: top;
        }

        .print-table-compact th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }

        .print-table-compact tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Signature section */
        .signature-section {
            margin: 2rem 0;
            padding-top: 1rem;
        }

        /* Footer styles */
        footer {
            margin-top: 3rem;
            padding-top: 1rem;
            border-top: 1px solid #ddd;
            font-size: 10pt;
            color: #666;
        }

        /* Print-specific styles */
        @media print {
            body {
                font-size: 11pt;
            }

            .print-container {
                padding: 0;
            }

            .no-print {
                display: none !important;
            }

            .page-break {
                page-break-before: always;
            }

            /* Ensure tables don't break across pages */
            table {
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }

            thead {
                display: table-header-group;
            }

            tfoot {
                display: table-footer-group;
            }

            /* Ensure images don't break across pages */
            img {
                max-width: 100%;
                height: auto;
                page-break-inside: avoid;
            }

            /* Adjust margins for printing */
            @page :first {
                margin-top: 1cm;
            }
        }
    </style>
    <div class="pt-2">


    </div>

<div class="bg-white rounded-lg overflow-hidden print:mt-4 print-section print-keep-together" id="printable">
    <!-- Print Button -->

   <!-- Print Button -->

    <div class="max-w-3xl mx-auto border border-gray-300 bg-white p-6 rounded mt-2 print:p-2 print:border-0 print:rounded-none print:mt-0 print:max-w-full print-compact print:block">
        <div>

            <div class="flex">
                <div class="flex mr-2">
                    <img src="{{ asset('images/bagong_pilipinas.png') }}" class="w-16 mx-auto h-16" alt="University Logo">
                    <img src="{{ asset('images/sksu1.png') }}" class="w-16 mx-auto h-16" alt="Header Logo">
                </div>
                <div>
                    <p class="leading-[1.1rem] text-gray-600 text-sm font-bold uppercase">Republic of the Philippines</p>
                    <p class="leading-[1.1rem] text-lg text-green-800 font-bold">SULTAN KUDARAT STATE UNIVERSITY</p>
                    <p class="leading-[1.1rem] text-gray-600 text-sm">EJC Montilla, City of Tacurong, 9800</p>
                    <p class="leading-[1.1rem] text-gray-600 text-sm mb-4">Province of Sultan Kudarat</p>
                </div>
            </div>
            <div class="border-b-2 border-gray-600 pt-1 pb-3 text-gray-700 text-sm">
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="https://www.sksu.edu.ph" target="_blank" class="flex items-center text-xs hover:underline">
                        <i class="text-green-600 fas fa-globe mr-2"></i>
                        <span>https://www.sksu.edu.ph</span>
                    </a>

                    <a href="mailto:officeofthepresident@sksu.edu.ph" class="flex items-center text-xs hover:underline">
                        <i class="text-green-600 fas fa-envelope mr-2"></i>
                        <span class="truncate max-w-[180px] md:max-w-none">officeofthepresident@sksu.edu.ph</span>
                    </a>

                    <a href="tel:(064)200-7338" class="flex items-center text-xs hover:underline">
                        <i class="text-green-600 fas fa-phone-alt mr-2"></i>
                        <span>(064) 200-7338</span>
                    </a>
            </div>

        </div>

        <div class="flex print-compact  mt-4">

            <!-- Photo Placeholder - Standard Passport Size -->
            <div class="w-1/4 flex">
                <div class="border border-gray-400 w-[35mm] h-[45mm] flex items-center justify-center overflow-hidden bg-white">
                    <img src="{{ $photo }}" alt="{{ $photo }}" class="object-cover w-full h-full">
                </div>
            </div>
            <!-- Header & Details -->
            <div class="w-3/4 pl-4">
                <div class="text-sm font-medium">Guidance and Testing Center</div>
                <div class="leading-[1.1rem] font-extrabold mt-1 mb-2 print-text-lg">SKSU TERTIARY PLACEMENT<br>TEST RESULT 2025</div>
                <div class="mt-2 text-sm">
                    <div class="mb-1">
                        <span class="font-semibold inline-block w-40 uppercase">NAME OF EXAMINEE</span>
                        <span>: {{ $result->full_name ??''}}</span>
                    </div>
                    <div class="mb-1">
                        <span class="font-semibold inline-block w-40">EXAMINEE NUMBER</span>
                        <span>: {{ $result->examinee_number ?? 'N/A' }}</span>
                    </div>
                    <div class="mb-1">
                        <span class="font-semibold inline-block w-40">DATE OF EXAMINATION</span>
                        <span>: April 6, 2025</span>
                    </div>
                </div>
            </div>
        </div>



        <div class="overflow-x-auto -mx-2 sm:mx-0 mt-2">
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
                            <td class="border border-gray-300 px-2 py-1 text-xs sm:text-sm">{{ $result->stanineInterpretation($result->english_raw_score) }}</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 px-2 py-1 text-xs sm:text-sm">FILIPINO</td>
                            <td class="border border-gray-300 px-2 py-1 text-center font-bold text-xs sm:text-sm">{{ $result->filipino_standard_score ?? '' }}</td>
                            <td class="border border-gray-300 px-2 py-1 text-center text-xs sm:text-sm">{{ $result->filipino_raw_score ?? '' }}</td>
                            <td class="border border-gray-300 px-2 py-1 text-xs sm:text-sm">{{ $result->stanineInterpretation($result->filipino_raw_score) }}</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 px-2 py-1 text-xs sm:text-sm">MATHEMATICS</td>
                            <td class="border border-gray-300 px-2 py-1 text-center font-bold text-xs sm:text-sm">{{ $result->math_standard_score ?? '' }}</td>
                            <td class="border border-gray-300 px-2 py-1 text-center text-xs sm:text-sm">{{ $result->math_raw_score ?? '' }}</td>
                            <td class="border border-gray-300 px-2 py-1 text-xs sm:text-sm">{{ $result->stanineInterpretation($result->math_raw_score) }}</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 px-2 py-1 text-xs sm:text-sm">SCIENCE</td>
                            <td class="border border-gray-300 px-2 py-1 text-center font-bold text-xs sm:text-sm">{{ $result->science_standard_score ?? '' }}</td>
                            <td class="border border-gray-300 px-2 py-1 text-center text-xs sm:text-sm">{{ $result->science_raw_score ?? '' }}</td>
                            <td class="border border-gray-300 px-2 py-1 text-xs sm:text-sm">{{ $result->stanineInterpretation($result->science_raw_score) }}</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 px-2 py-1 text-xs sm:text-sm">SOCIAL STUDIES</td>
                            <td class="border border-gray-300 px-2 py-1 text-center font-bold text-xs sm:text-sm">{{ $result->social_studies_standard_score ?? '' }}</td>
                            <td class="border border-gray-300 px-2 py-1 text-center text-xs sm:text-sm">{{ $result->social_studies_raw_score ?? '' }}</td>
                            <td class="border border-gray-300 px-2 py-1 text-xs sm:text-sm">{{ $result->stanineInterpretation($result->social_studies_raw_score) }}</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 px-2 py-1 font-bold text-xs sm:text-sm">OVERALL</td>
                            <td class="border border-gray-300 px-2 py-1 text-center font-bold text-xs sm:text-sm">{{ $result->total_standard_score ?? '' }}</td>
                            <td class="border border-gray-300 px-2 py-1 text-center text-xs sm:text-sm">{{ $result->total_raw_score ?? '' }}</td>
                            <td class="border border-gray-300 px-2 py-1 text-xs sm:text-sm">{{ $result->stanineInterpretation($result->total_raw_score) }}</td>
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

        </div>

        <!-- Score Guide -->
        {{-- <livewire:result.score-guide /> --}}
        <div class="">
            <livewire:footer-signature/>
        </div>
        <livewire:result.score-guide />


        <!-- Footer -->
        <footer class="print-text-xs mt-2">
            <div class="text-center text-xs text-gray-600 mb-1 print:mb-0 print:text-[5px] print:leading-none">
                <p class="mb-0">Republic of the Philippines | SULTAN KUDARAT STATE UNIVERSITY | EJC Montilla, City of Tacurong</p>
                <p class="mb-0"><span class="font-bold">VISION:</span> A leading University in advancing scholarly innovation, multi-cultural convergence, and responsive public service.</p>
                <p class="mb-0"><span class="font-bold">CORE VALUES:</span> Patriotism, Respect, Integrity, Zeal, Excellence in Public Service.</p>
            </div>
        </footer>


        </div>
    </div>

</div>
    </x-layout.ordinary>
</div>
