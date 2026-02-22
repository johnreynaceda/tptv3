<div>

    <x-layout.ordinary>

        <head>
            <title>Document</title>
            <script src="https://cdn.tailwindcss.com"></script>
        </head>
<div class="bg-white print:p-0 print:m-0">
    <style>
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

        .print-container {
            max-width: 21cm;
            margin: 0 auto;
            padding: 1cm;
        }

        .header img {
            height: 80px;
            margin: 0 15px;
        }

        .print-table-compact {
            width: 100%;
            border-collapse: collapse;
            margin: 0.5rem 0;
            font-size: 10pt;
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

        @media print {
            body { font-size: 11pt; }
            .print-container { padding: 0; }
            .no-print { display: none !important; }
            .page-break { page-break-before: always; }
            table { page-break-inside: auto; }
            tr { page-break-inside: avoid; page-break-after: auto; }
            thead { display: table-header-group; }
            img { max-width: 100%; height: auto; page-break-inside: avoid; }
        }
    </style>
    <div class="pt-2"></div>

<div class="bg-white rounded-lg overflow-hidden print:mt-4 print-section print-keep-together" id="printable">

    <div class="max-w-3xl mx-auto border border-gray-300 bg-white p-6 rounded mt-2 print:p-2 print:border-0 print:rounded-none print:mt-0 print:max-w-full print-compact print:block relative">
        <!-- SKSU Logo Watermark -->
        <div class="absolute inset-0 flex items-center justify-center pointer-events-none" style="z-index: 0;">
            <img src="{{ public_path('images/resultassets/sksu_logo.png') }}" style="width: 320px; height: 320px; opacity: 0.06;">
        </div>
        <div class="relative" style="z-index: 1;">
        <div>

            <div class="flex">
                <div class="flex mr-2">
                    <img src="{{ public_path('images/resultassets/bagong_pilipinas.png') }}" class="w-16 mx-auto h-16" alt="Bagong Pilipinas Logo">
                    <img src="{{ public_path('images/resultassets/sksu_logo.png') }}" class="w-16 mx-auto h-16" alt="SKSU Logo">
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
                    <span class="flex items-center text-xs">
                        <span>https://www.sksu.edu.ph</span>
                    </span>
                    <span class="flex items-center text-xs">
                        <span>guidance@sksu.edu.ph</span>
                    </span>
                    <span class="flex items-center text-xs">
                        <span>0965 917 4078</span>
                    </span>
                </div>
            </div>

        <div class="flex print-compact mt-4">

            <!-- Photo Placeholder -->
            <div class="w-1/4 flex">
                <div class="border border-gray-400 w-[35mm] h-[45mm] flex items-center justify-center overflow-hidden bg-white">
                    <img src="{{ $photo }}" alt="Photo" class="object-cover w-full h-full">
                </div>
            </div>
            <!-- Header & Details -->
            <div class="w-3/4 pl-4">
                <div class="text-sm italic" style="font-family: 'Times New Roman', serif;">Guidance and Testing Center</div>
                <div class="leading-[1.1rem] font-extrabold mt-1 mb-2 print-text-lg">SKSU TERTIARY PLACEMENT<br>TEST RESULT 2026</div>
                <div class="mt-2 text-sm">
                    <div class="mb-1">
                        <span class="font-semibold inline-block w-40 uppercase">NAME OF EXAMINEE</span>
                        <span>: {{ $result->full_name ?? '' }}</span>
                    </div>
                    <div class="mb-1">
                        <span class="font-semibold inline-block w-40">EXAMINEE NUMBER</span>
                        <span>: {{ $result->examinee_number ?? 'N/A' }}</span>
                    </div>
                    <div class="mb-1">
                        <span class="font-semibold inline-block w-40">PREFERRED PROGRAM</span>
                        <span>: {{ $result->preferred_program ?? 'N/A' }}</span>
                    </div>
                    <div class="mb-1">
                        <span class="font-semibold inline-block w-40">DATE OF EXAMINATION</span>
                        <span>: January 11, 2026</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Score Table (inline - no Livewire for Browsershot) -->
        @php
            $stanine = function($score) {
                if ($score == 9) return 'Outstanding';
                if ($score == 8 || $score == 7) return 'Above Average';
                if ($score == 6) return 'High Average';
                if ($score == 5) return 'Middle Average';
                if ($score == 4) return 'Low Average';
                if ($score == 3 || $score == 2) return 'Below Average';
                if ($score == 1) return 'Low';
                return 'Invalid Score';
            };
        @endphp

        <div class="overflow-x-auto -mx-2 sm:mx-0 mt-2">
            <div class="inline-block min-w-full sm:px-0 px-2">
                <table class="w-full text-sm border border-black" style="border-collapse: collapse;">
                    <thead>
                        <tr class="bg-gray-50 text-center">
                            <th class="border border-black px-2 py-2 font-bold text-xs sm:text-sm">SUBJECT</th>
                            <th class="border border-black px-2 py-2 font-bold text-xs sm:text-sm">STANDARD SCORE</th>
                            <th class="border border-black px-2 py-2 font-bold text-xs sm:text-sm">STANINE</th>
                            <th class="border border-black px-2 py-2 font-bold text-xs sm:text-sm">QUALITATIVE INTERPRETATION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border border-black px-2 py-1 text-xs sm:text-sm">ENGLISH</td>
                            <td class="border border-black px-2 py-1 text-center font-bold text-xs sm:text-sm">{{ $result->english_standard_score ?? '' }}</td>
                            <td class="border border-black px-2 py-1 text-center text-xs sm:text-sm">{{ $result->english_raw_score ?? '' }}</td>
                            <td class="border border-black px-2 py-1 text-xs sm:text-sm">{{ $stanine($result->english_raw_score) }}</td>
                        </tr>
                        <tr>
                            <td class="border border-black px-2 py-1 text-xs sm:text-sm">SCIENCE</td>
                            <td class="border border-black px-2 py-1 text-center font-bold text-xs sm:text-sm">{{ $result->science_standard_score ?? '' }}</td>
                            <td class="border border-black px-2 py-1 text-center text-xs sm:text-sm">{{ $result->science_raw_score ?? '' }}</td>
                            <td class="border border-black px-2 py-1 text-xs sm:text-sm">{{ $stanine($result->science_raw_score) }}</td>
                        </tr>
                        <tr>
                            <td class="border border-black px-2 py-1 text-xs sm:text-sm">MATHEMATICS</td>
                            <td class="border border-black px-2 py-1 text-center font-bold text-xs sm:text-sm">{{ $result->math_standard_score ?? '' }}</td>
                            <td class="border border-black px-2 py-1 text-center text-xs sm:text-sm">{{ $result->math_raw_score ?? '' }}</td>
                            <td class="border border-black px-2 py-1 text-xs sm:text-sm">{{ $stanine($result->math_raw_score) }}</td>
                        </tr>
                        <tr>
                            <td class="border border-black px-2 py-1 text-xs sm:text-sm">FILIPINO</td>
                            <td class="border border-black px-2 py-1 text-center font-bold text-xs sm:text-sm">{{ $result->filipino_standard_score ?? '' }}</td>
                            <td class="border border-black px-2 py-1 text-center text-xs sm:text-sm">{{ $result->filipino_raw_score ?? '' }}</td>
                            <td class="border border-black px-2 py-1 text-xs sm:text-sm">{{ $stanine($result->filipino_raw_score) }}</td>
                        </tr>
                        <tr>
                            <td class="border border-black px-2 py-1 text-xs sm:text-sm">SOCIAL STUDIES</td>
                            <td class="border border-black px-2 py-1 text-center font-bold text-xs sm:text-sm">{{ $result->social_studies_standard_score ?? '' }}</td>
                            <td class="border border-black px-2 py-1 text-center text-xs sm:text-sm">{{ $result->social_studies_raw_score ?? '' }}</td>
                            <td class="border border-black px-2 py-1 text-xs sm:text-sm">{{ $stanine($result->social_studies_raw_score) }}</td>
                        </tr>
                        <tr>
                            <td class="border border-black px-2 py-1 font-bold text-xs sm:text-sm">ESM COMPETENCY SCORE</td>
                            <td class="border border-black px-2 py-1 text-center font-bold text-xs sm:text-sm">{{ $result->esm_standard_score ?? '' }}</td>
                            <td class="border border-black px-2 py-1 text-center text-xs sm:text-sm">{{ $result->esm_raw_score ?? '' }}</td>
                            <td class="border border-black px-2 py-1 text-xs sm:text-sm">{{ $stanine($result->esm_raw_score) }}</td>
                        </tr>
                        <tr>
                            <td class="border border-black px-2 py-1 font-bold text-xs sm:text-sm">OVERALL SCORE</td>
                            <td class="border border-black px-2 py-1 text-center font-bold text-xs sm:text-sm">{{ $result->total_standard_score ?? '' }}</td>
                            <td class="border border-black px-2 py-1 text-center text-xs sm:text-sm">{{ $result->total_raw_score ?? '' }}</td>
                            <td class="border border-black px-2 py-1 text-xs sm:text-sm">{{ $stanine($result->total_raw_score) }}</td>
                        </tr>
                        <!-- Score Definitions inside table -->
                        <tr>
                            <td colspan="4" class="border border-black px-2 py-2 text-xs text-justify" style="line-height: 1.4;">
                                <p class="mb-2">
                                    <span class="font-bold italic">OVERALL SCORE</span> – The composite score based on all subjects taken in the SKSU TPT. This score is used for admission to all other college programs not included under the EMS Score.
                                </p>
                                <p>
                                    <span class="font-bold italic">ESM COMPETENCY SCORE</span> - The composite score based only on English, Mathematics, and Science. This score is used for admission to the following college programs: Nursing, Midwifery, Medical Technology, Electronics Engineering, Civil Engineering, Computer Engineering, Computer Science, Fisheries, Biology, Accountancy, Management Accounting, Accounting Information Systems, Mathematics Education, and Science Education.
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        </div>

        <!-- Campus Cutoff Table (inline for Browsershot) -->
        <div>
            <div class="bg-white py-2 print-section">
                <div class="text-center mb-2">
                    <h2 class="font-bold text-lg mb-0">
                        SKSU Tertiary Placement Test Cut-off Scores Per Program
                    </h2>
                    <p class="text-xs italic text-gray-700 mt-1">
                        The cut-off score is the minimum required score to qualify for a specific program and only applicants who meet or
                        exceed the prescribed standard are eligible for selection.
                    </p>
                </div>

                <div class="overflow-x-auto mt-2">
                    <table class="w-full text-xs border border-gray-300" style="page-break-inside: auto;">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="border border-gray-300 px-2 py-1 w-5/12">PROGRAM</th>
                                <th class="border border-gray-300 px-2 py-1 w-1/12">STANDARD SCORE</th>
                                <th class="border border-gray-300 px-2 py-1 w-5/12">PROGRAM</th>
                                <th class="border border-gray-300 px-2 py-1 w-1/12">STANDARD SCORE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="2" class="border border-gray-300 px-2 py-1 font-bold" style="background-color: #808080; color: #FFFFFF;">ACCESS CAMPUS</td>
                                <td colspan="2" class="border border-gray-300 px-2 py-1 font-bold" style="background-color: #808080; color: #FFFFFF;">TACURONG CAMPUS</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-2 py-1">Bachelor in Elementary Education</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">500</td>
                                <td class="border border-gray-300 px-2 py-1">Bachelor of Science in Biology</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">400</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-2 py-1">Bachelor in Secondary Education major in: Filipino</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">500</td>
                                <td class="border border-gray-300 px-2 py-1">Bachelor of Arts in Economics</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">400</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-2 py-1">Bachelor in Secondary Education major in: Science</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">500</td>
                                <td class="border border-gray-300 px-2 py-1">Bachelor of Arts in Political Science</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">400</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-2 py-1">Bachelor in Secondary Education major in: Mathematics</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">500</td>
                                <td class="border border-gray-300 px-2 py-1">Bachelor of Science in Hospitality Management</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">400</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-2 py-1">Bachelor in Secondary Education major in: Social Studies</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">500</td>
                                <td class="border border-gray-300 px-2 py-1">Bachelor of Science in Entrepreneurship</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">400</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-2 py-1">Bachelor in Secondary Education major in: English</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">500</td>
                                <td class="border border-gray-300 px-2 py-1">Bachelor of Science in Accountancy</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">600</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-2 py-1">Bachelor of Physical Education</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">500</td>
                                <td class="border border-gray-300 px-2 py-1">Bachelor of Science in Accounting Information System</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">400</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-2 py-1">Bachelor of Science in Nursing</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">650</td>
                                <td class="border border-gray-300 px-2 py-1">Bachelor of Science in Tourism Management</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">400</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-2 py-1">Bachelor of Science in Midwifery</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">550</td>
                                <td class="border border-gray-300 px-2 py-1">Bachelor of Science in Management Accounting</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">400</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-2 py-1">Bachelor of Science in Medical Technology</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">650</td>
                                <td class="border border-gray-300 px-2 py-1">Bachelor of Science in Environmental Science</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">400</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-2 py-1">Bachelor of Science in Criminal Justice Education</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">450</td>
                                <td colspan="2" class="border border-gray-300"></td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-2 py-1">Bachelor of Science in Industrial Security Management</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">300</td>
                                <td colspan="2" class="border border-gray-300"></td>
                            </tr>

                            <tr>
                                <td colspan="2" class="border border-gray-300 px-2 py-1 font-bold" style="background-color: #808080; color: #FFFFFF;">ISULAN CAMPUS</td>
                                <td colspan="2" class="border border-gray-300 px-2 py-1 font-bold" style="background-color: #808080; color: #FFFFFF;">KALAMANSIG CAMPUS</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-2 py-1">Bachelor of Science in Electronics Engineering</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">500</td>
                                <td class="border border-gray-300 px-2 py-1">Bachelor of Science in Fisheries</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">450</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-2 py-1">Bachelor of Science in Civil Engineering</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">500</td>
                                <td class="border border-gray-300 px-2 py-1">Bachelor in Secondary Education major in: English</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">450</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-2 py-1">Bachelor of Science in Computer Engineering</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">500</td>
                                <td class="border border-gray-300 px-2 py-1">Bachelor in Secondary Education major in: Filipino</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">450</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-2 py-1">Bachelor of Science in Computer Science</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">400</td>
                                <td class="border border-gray-300 px-2 py-1">Bachelor in Secondary Education major in: Science</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">450</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-2 py-1">Bachelor of Science in Information Technology</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">400</td>
                                <td class="border border-gray-300 px-2 py-1">Bachelor in Elementary Education</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">450</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-2 py-1">Bachelor of Science in Information System</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">400</td>
                                <td class="border border-gray-300 px-2 py-1">Bachelor of Science in Information Technology</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">350</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-2 py-1">BIT major in: Architectural Drafting Technology</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">300</td>
                                <td class="border border-gray-300 px-2 py-1">Bachelor of Science in Biology</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">350</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-2 py-1">BIT major in: Food Innovation and Culinary Tech.</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">300</td>
                                <td class="border border-gray-300 px-2 py-1">Bachelor of Science in Criminal Justice Education</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">450</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-2 py-1">BIT major in: Automotive Technology</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">300</td>
                                <td class="border border-gray-300 px-2 py-1">Bachelor in Secondary Education major in: Mathematics</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">450</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-2 py-1">BIT major in: Electrical Technology</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">300</td>
                                <td colspan="2" class="border border-gray-300"></td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-2 py-1">BIT major in: Electronics Technology</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">300</td>
                                <td colspan="2" class="border border-gray-300 px-2 py-1 font-bold" style="background-color: #808080; color: #FFFFFF;">BAGUMBAYAN CAMPUS</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-2 py-1">BIT major in: Civil Technology</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">300</td>
                                <td class="border border-gray-300 px-2 py-1">Bachelor of Science in Agribusiness</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">300</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-2 py-1">BTVTEd major in: Drafting Technology</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">450</td>
                                <td class="border border-gray-300 px-2 py-1">BTLEd major in Agri-fishery</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">400</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-2 py-1">BTVTEd major in: Food Service Management</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">450</td>
                                <td colspan="2" class="border border-gray-300"></td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-2 py-1">BTVTEd major in: Automotive Technology</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">450</td>
                                <td colspan="2" class="border border-gray-300 px-2 py-1 font-bold" style="background-color: #808080; color: #FFFFFF;">PALIMBANG CAMPUS</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-2 py-1">BTVTEd major in: Electrical Technology</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">450</td>
                                <td class="border border-gray-300 px-2 py-1">Bachelor in Elementary Education</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">400</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-2 py-1">BTVTEd major in: Electronics Technology</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">450</td>
                                <td class="border border-gray-300 px-2 py-1">Bachelor of Science in Agribusiness</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">300</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-2 py-1">BTVTEd major in: Civil Technology</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">450</td>
                                <td colspan="2" class="border border-gray-300"></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="border border-gray-300"></td>
                                <td colspan="2" class="border border-gray-300 px-2 py-1 font-bold" style="background-color: #808080; color: #FFFFFF;">LUTAYAN CAMPUS</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="border border-gray-300"></td>
                                <td class="border border-gray-300 px-2 py-1">Bachelor in Elementary Education</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">400</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="border border-gray-300"></td>
                                <td class="border border-gray-300 px-2 py-1">Bachelor of Science in Agriculture</td>
                                <td class="border border-gray-300 px-2 py-1 text-center font-bold">400</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Footer Signature (inline for Browsershot) -->
        <div class="mt-2 pt-1 print:mt-1 print:pt-0 print-keep-together">
            <div class="flex flex-col sm:flex-row justify-between gap-4 print:gap-2">
                <div class="flex-1 text-left">
                    <div class="text-xs text-gray-600 mb-1">Prepared by:</div>
                    <img src="{{ public_path('images/signature/john-michael.png') }}" style="height: 2rem;" alt="Signature">
                    <div class="text-xs font-bold print:text-[9px]">JAN MICHAEL B. SALDICAYA, LPT</div>
                    <div class="text-xs text-gray-700 print:text-[8px]">PRC License No.: 1443740</div>
                    <div class="text-xs text-gray-700 print:text-[8px]">Personnel, Guidance and Testing Center</div>
                </div>

                <div class="flex-1 text-left">
                    <div class="text-xs text-gray-600 mb-1">Interpreted by:</div>
                    <img src="{{ public_path('images/signature/mark.png') }}" style="height: 2rem;" alt="Signature">
                    <div class="text-xs font-bold print:text-[9px]">MARK F. ONIA, RPm, RPsy</div>
                    <div class="text-xs text-gray-700 print:text-[8px]">PRC License No.: 0004578 / 0001990</div>
                    <div class="text-xs text-gray-700 print:text-[8px]">University Psychometrician</div>
                </div>

                <div class="flex-1 text-left">
                    <div class="text-xs text-gray-600 mb-1">Noted:</div>
                    <img src="{{ public_path('images/signature/bacera.png') }}" style="height: 2rem;" alt="Signature">
                    <div class="text-xs font-bold print:text-[9px]">JOSELYN H. BACERA, RGC</div>
                    <div class="text-xs text-gray-700 print:text-[8px]">PRC License No.: 0002274</div>
                    <div class="text-xs text-gray-700 print:text-[8px]">Director, Guidance and Testing Center</div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-4 border-t border-dashed border-gray-400 pt-1">
            <p class="text-center text-gray-500 mb-0" style="font-size: 8px; line-height: 1.3;"><span class="font-bold">VISION:</span> A leading University in advancing scholarly innovation, multi-cultural convergence, and responsive public service in a borderless Region. | <span class="font-bold">MISSION:</span> The University shall primarily provide advanced instruction and professional training in science and technology, agriculture, fisheries, education and other relevant fields of study. It shall also undertake research and extension services, and provide progressive leadership in its areas of specialization. | <span class="font-bold">MAXIM:</span> Generator of Solutions.</p>
            <p class="text-center text-gray-500 mb-0" style="font-size: 8px; line-height: 1.3;">| <span class="font-bold">CORE VALUES:</span> Patriotism, Respect, Integrity, Zeal, Excellence in Public Service.</p>
        </div>

        </div> <!-- end z-index: 1 content wrapper -->
        </div>
    </div>

</div>
    </x-layout.ordinary>
</div>
