<div>

    <x-layout.ordinary>

        <head>
            <title>Document</title>
            <script src="https://cdn.tailwindcss.com"></script>
        </head>
<div class="print:p-0 print:m-0" style="position: relative; min-height: 100vh; overflow: hidden; background-color: white;">
    <style>
        /* Side pattern styling for PDF - matching preview */
        .side-pattern-pdf {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 0;
            pointer-events: none;
        }
        .side-pattern-pdf img {
            height: 100%;
            width: 100%;
            object-fit: fill;
            object-position: left top;
        }
        @page {
            margin: 0;
            margin-right: 1cm;
            margin-top: 0;
            margin-bottom: 0.5cm;
            size: A4;
        }

        *, *::before, *::after {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
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
            padding-left: 50px;
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
            background-color: transparent;
        }

        /* All backgrounds transparent - except campus headers */
        table td:not([style*="background-color"]) {
            background-color: transparent !important;
        }

        table th {
            background-color: #e5e5e5 !important;
        }

        /* Main container transparent */
        .bg-white {
            background-color: transparent !important;
        }

        /* Keep only specific elements white */
        #printable {
            background-color: transparent !important;
        }

        .max-w-3xl {
            background-color: transparent !important;
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

    <!-- Side Pattern - at page level, positioned to show header stripe at top -->
    <div style="position: absolute; top: -80px; left: 0; width: 100%; height: calc(100% + 80px); z-index: 0; pointer-events: none;">
        <img src="{{ public_path('images/resultassets/side_pattern_header.png') }}" style="width: 100%; height: 100%; object-fit: fill;" alt="">
    </div>

<div class="rounded-lg print:mt-4 print-section print-keep-together" id="printable" style="position: relative; z-index: 1; font-family: 'Times New Roman', serif; background-color: transparent;">

    <div class="max-w-3xl mx-auto p-6 rounded mt-2 print:p-2 print:border-0 print:rounded-none print:mt-0 print:max-w-full print-compact print:block" style="position: relative; margin-left: 50px; overflow: visible; background-color: transparent;">
        <!-- SKSU Logo Watermark - centered -->
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); pointer-events: none; z-index: 0;">
            <img src="{{ public_path('images/resultassets/sksu_logo.png') }}" style="width: 700px; height: auto; opacity: 0.05;">
        </div>
        <div style="position: relative; z-index: 1;">
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
            <!-- Contact Info -->
            <div class="flex items-center gap-4 text-xs text-gray-700 mt-2 mb-4">
                <span class="flex items-center">
                    <span style="width: 16px; height: 16px; border-radius: 50%; background-color: #16a34a; display: flex; align-items: center; justify-content: center; margin-right: 4px;">
                        <svg style="width: 10px; height: 10px; color: white;" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM4.332 8.027a6.012 6.012 0 011.912-2.706C6.512 5.73 6.974 6 7.5 6A1.5 1.5 0 019 7.5V8a2 2 0 004 0 2 2 0 011.523-1.943A5.977 5.977 0 0116 10c0 .34-.028.675-.083 1H15a2 2 0 00-2 2v2.197A5.973 5.973 0 0110 16v-2a2 2 0 00-2-2 2 2 0 01-2-2 2 2 0 00-1.668-1.973z" clip-rule="evenodd"></path>
                        </svg>
                    </span>
                    https://www.sksu.edu.ph
                </span>
                <span class="flex items-center">
                    <span style="width: 16px; height: 16px; border-radius: 50%; background-color: #16a34a; display: flex; align-items: center; justify-content: center; margin-right: 4px;">
                        <svg style="width: 10px; height: 10px; color: white;" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                        </svg>
                    </span>
                    guidance@sksu.edu.ph
                </span>
                <span class="flex items-center">
                    <span style="width: 16px; height: 16px; border-radius: 50%; background-color: #16a34a; display: flex; align-items: center; justify-content: center; margin-right: 4px;">
                        <svg style="width: 10px; height: 10px; color: white;" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                        </svg>
                    </span>
                    0965 917 4078
                </span>
            </div>
            <div class="flex print-compact mt-10 mb-2">

            <!-- Photo Placeholder -->
            <div class="w-1/4 flex" style="margin-left: 5rem; margin-top: 2rem;">
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
                        <tr class="text-center">
                            <th class="border border-black px-2 py-2 font-bold text-xs sm:text-sm" style="background-color: transparent;">SUBJECT</th>
                            <th class="border border-black px-2 py-2 font-bold text-xs sm:text-sm" style="background-color: transparent;">STANDARD SCORE</th>
                            <th class="border border-black px-2 py-2 font-bold text-xs sm:text-sm" style="background-color: transparent;">STANINE</th>
                            <th class="border border-black px-2 py-2 font-bold text-xs sm:text-sm" style="background-color: transparent;">QUALITATIVE INTERPRETATION</th>
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
                            <td class="border border-black px-2 py-1 font-bold text-xs sm:text-sm" style="background-color: transparent;">OVERALL SCORE</td>
                            <td class="border border-black px-2 py-1 text-center font-bold text-xs sm:text-sm" style="background-color: transparent;">{{ $result->total_standard_score ?? '' }}</td>
                            <td class="border border-black px-2 py-1 text-center text-xs sm:text-sm" style="background-color: transparent;">{{ $result->total_raw_score ?? '' }}</td>
                            <td class="border border-black px-2 py-1 text-xs sm:text-sm font-bold" style="background-color: transparent;">{{ $stanine($result->total_raw_score) }}</td>
                        </tr>
                        <!-- Score Definitions inside table -->
                        <tr>
                            <td colspan="4" class="border border-black px-2 py-2 text-xs text-justify" style="line-height: 1.4; background-color: transparent;">
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

        <!-- Campus Cutoff Table - Exact copy from preview -->
        <div class="py-2 print:mt-2 print-section" style="background-color: transparent;">
            <!-- Title & Subtitle -->
            <div class="text-center mb-2">
                <h2 class="font-bold text-lg mb-0">
                    SKSU Tertiary Placement Test Cut-off Scores Per Program
                </h2>
                <p class="text-xs italic text-gray-700 mt-1">
                    The cut-off score is the minimum required score to qualify for a specific program and only applicants who meet or
                    exceed the prescribed standard are eligible for selection.
                </p>
            </div>

            <style>
                .cutoff-table { border-collapse: collapse; font-size: 8pt; width: 100%; line-height: 1.35; table-layout: fixed; }
                .cutoff-table th { background-color: #e5e5e5 !important; border: 1px solid #000; padding: 3px 4px; font-weight: bold; }
                .cutoff-table td { border: 1px solid #000; padding: 2px 4px; background-color: transparent; overflow: hidden; text-overflow: ellipsis; }
                .cutoff-table .campus-header { background-color: #808080 !important; color: #fff; font-weight: bold; }
                .cutoff-table .score { text-align: center; font-weight: bold; width: 60px; }
                .cutoff-table .program-col { width: calc(50% - 60px); }
            </style>

            <!-- Single Table with 4 Columns -->
            <table class="cutoff-table">
                <thead>
                    <tr>
                        <th class="text-left" style="width: 38%;">PROGRAM</th>
                        <th class="text-center" style="width: 12%; white-space: nowrap;">STANDARD SCORE</th>
                        <th class="text-left" style="width: 38%;">PROGRAM</th>
                        <th class="text-center" style="width: 12%; white-space: nowrap;">STANDARD SCORE</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="2" class="campus-header">ACCESS CAMPUS</td>
                        <td colspan="2" class="campus-header">TACURONG CAMPUS</td>
                    </tr>
                    <tr class="row-odd">
                        <td>Bachelor in Elementary Education</td>
                        <td class="score">500</td>
                        <td>Bachelor of Science in Biology</td>
                        <td class="score">450</td>
                    </tr>
                    <tr class="row-even">
                        <td>Bachelor in Secondary Education major in: Filipino</td>
                        <td class="score">500</td>
                        <td>Bachelor of Arts in Economics</td>
                        <td class="score">400</td>
                    </tr>
                    <tr class="row-odd">
                        <td>Bachelor in Secondary Education major in: Science</td>
                        <td class="score">500</td>
                        <td>Bachelor of Arts in Political Science</td>
                        <td class="score">450</td>
                    </tr>
                    <tr class="row-even">
                        <td>Bachelor in Secondary Education major in: Mathematics</td>
                        <td class="score">500</td>
                        <td>Bachelor of Science in Hospitality Management</td>
                        <td class="score">450</td>
                    </tr>
                    <tr class="row-odd">
                        <td>Bachelor in Secondary Education major in: Social Studies</td>
                        <td class="score">500</td>
                        <td>Bachelor of Science in Entrepreneurship</td>
                        <td class="score">400</td>
                    </tr>
                    <tr class="row-even">
                        <td>Bachelor in Secondary Education major in: English</td>
                        <td class="score">500</td>
                        <td>Bachelor of Science in Accountancy</td>
                        <td class="score">600</td>
                    </tr>
                    <tr class="row-odd">
                        <td>Bachelor of Physical Education</td>
                        <td class="score">500</td>
                        <td>Bachelor of Science in Accounting Information System</td>
                        <td class="score">450</td>
                    </tr>
                    <tr class="row-even">
                        <td>Bachelor of Science in Nursing</td>
                        <td class="score">650</td>
                        <td>Bachelor of Science in Tourism Management</td>
                        <td class="score">450</td>
                    </tr>
                    <tr class="row-odd">
                        <td>Bachelor of Science in Midwifery</td>
                        <td class="score">550</td>
                        <td>Bachelor of Science in Management Accounting</td>
                        <td class="score">450</td>
                    </tr>
                    <tr class="row-even">
                        <td>Bachelor of Science in Medical Technology</td>
                        <td class="score">650</td>
                        <td>Bachelor of Science in Environmental Science</td>
                        <td class="score">400</td>
                    </tr>
                    <tr class="row-odd">
                        <td>Bachelor of Science in Criminal Justice Education</td>
                        <td class="score">450</td>
                        <td colspan="2" class="campus-header">KALAMANSIG CAMPUS</td>
                    </tr>
                    <tr class="row-even">
                        <td>Bachelor of Science in Industrial Security Management</td>
                        <td class="score">300</td>
                        <td>Bachelor of Science in Fisheries</td>
                        <td class="score">425</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="campus-header">ISULAN CAMPUS</td>
                        <td class="row-odd">Bachelor in Secondary Education major in: English</td>
                        <td class="row-odd score">425</td>
                    </tr>
                    <tr class="row-even">
                        <td>Bachelor of Science in Electronics Engineering</td>
                        <td class="score">500</td>
                        <td>Bachelor in Secondary Education major in: Filipino</td>
                        <td class="score">425</td>
                    </tr>
                    <tr class="row-odd">
                        <td>Bachelor of Science in Civil Engineering</td>
                        <td class="score">500</td>
                        <td>Bachelor in Secondary Education major in: Science</td>
                        <td class="score">425</td>
                    </tr>
                    <tr class="row-even">
                        <td>Bachelor of Science in Computer Engineering</td>
                        <td class="score">500</td>
                        <td>Bachelor in Elementary Education</td>
                        <td class="score">425</td>
                    </tr>
                    <tr class="row-odd">
                        <td>Bachelor of Science in Computer Science</td>
                        <td class="score">400</td>
                        <td>Bachelor of Science in Information Technology</td>
                        <td class="score">350</td>
                    </tr>
                    <tr class="row-even">
                        <td>Bachelor of Science in Information Technology</td>
                        <td class="score">400</td>
                        <td>Bachelor of Science in Biology</td>
                        <td class="score">350</td>
                    </tr>
                    <tr class="row-odd">
                        <td>Bachelor of Science in Information System</td>
                        <td class="score">400</td>
                        <td>Bachelor of Science in Criminal Justice Education</td>
                        <td class="score">425</td>
                    </tr>
                    <tr class="row-even">
                        <td>BIT major in: Architectural Drafting Technology</td>
                        <td class="score">300</td>
                        <td>Bachelor in Secondary Education major in: Mathematics</td>
                        <td class="score">425</td>
                    </tr>
                    <tr class="row-odd">
                        <td>BIT major in: Food Innovation and Culinary Tech.</td>
                        <td class="score">300</td>
                        <td colspan="2" class="campus-header">BAGUMBAYAN CAMPUS</td>
                    </tr>
                    <tr class="row-even">
                        <td>BIT major in: Automotive Technology</td>
                        <td class="score">300</td>
                        <td>Bachelor of Science in Agribusiness</td>
                        <td class="score">300</td>
                    </tr>
                    <tr class="row-odd">
                        <td>BIT major in: Electrical Technology</td>
                        <td class="score">300</td>
                        <td>BTLEd major in Agri-fishery</td>
                        <td class="score">400</td>
                    </tr>
                    <tr class="row-even">
                        <td>BIT major in: Electronics Technology</td>
                        <td class="score">300</td>
                        <td colspan="2" class="campus-header">PALIMBANG CAMPUS</td>
                    </tr>
                    <tr class="row-odd">
                        <td>BIT major in: Civil Technology</td>
                        <td class="score">300</td>
                        <td>Bachelor in Elementary Education</td>
                        <td class="score">400</td>
                    </tr>
                    <tr class="row-even">
                        <td>BTVTEd major in: Drafting Technology</td>
                        <td class="score">450</td>
                        <td>Bachelor of Science in Agribusiness</td>
                        <td class="score">300</td>
                    </tr>
                    <tr class="row-odd">
                        <td>BTVTEd major in: Food Service Management</td>
                        <td class="score">450</td>
                        <td colspan="2" class="campus-header">LUTAYAN CAMPUS</td>
                    </tr>
                    <tr class="row-even">
                        <td>BTVTEd major in: Automotive Technology</td>
                        <td class="score">450</td>
                        <td>Bachelor in Elementary Education</td>
                        <td class="score">400</td>
                    </tr>
                    <tr class="row-odd">
                        <td>BTVTEd major in: Electrical Technology</td>
                        <td class="score">450</td>
                        <td>Bachelor of Science in Agriculture</td>
                        <td class="score">400</td>
                    </tr>
                    <tr class="row-even">
                        <td>BTVTEd major in: Electronics Technology</td>
                        <td class="score">450</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="row-odd">
                        <td>BTVTEd major in: Civil Technology</td>
                        <td class="score">450</td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Footer Signature (inline for Browsershot) -->
        <div class="mt-2 pt-1 print:mt-1 print:pt-0 print-keep-together">
            <div class="flex flex-col sm:flex-row justify-between gap-4 print:gap-2">
                <div class="flex-1 text-left">
                    <div class="text-xs text-gray-600 mb-1">Prepared by:</div>
                    <img src="{{ public_path('images/signature/john-michael.png') }}" style="height: 3rem; margin-bottom: -1rem;" alt="Signature">
                    <div class="text-xs font-bold print:text-[9px]">JAN MICHAEL B. SALDICAYA, LPT</div>
                    <div class="text-xs text-gray-700 print:text-[8px]">PRC License No.: 1443740</div>
                    <div class="text-xs text-gray-700 print:text-[8px]">Personnel, Guidance and Testing Center</div>
                </div>

                <div class="flex-1 text-left">
                    <div class="text-xs text-gray-600 mb-1">Interpreted by:</div>
                    <img src="{{ public_path('images/signature/mark.png') }}" style="height: 3rem; margin-bottom: -1rem;" alt="Signature">
                    <div class="text-xs font-bold print:text-[9px]">MARK F. ONIA, RPm, RPsy</div>
                    <div class="text-xs text-gray-700 print:text-[8px]">PRC License No.: 0004578 / 0001990</div>
                    <div class="text-xs text-gray-700 print:text-[8px]">University Psychometrician</div>
                </div>

                <div class="flex-1 text-left">
                    <div class="text-xs text-gray-600 mb-1">Noted:</div>
                    <img src="{{ public_path('images/signature/bacera.png') }}" style="height: 3rem; margin-bottom: -1rem;" alt="Signature">
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
