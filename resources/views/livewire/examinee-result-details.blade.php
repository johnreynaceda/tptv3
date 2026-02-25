<div class="bg-white print:p-0 print:m-0">
    <style>
        .side-pattern {
            position: absolute;
            top: -50px;
            left: 0;
            bottom: 0;
            z-index: 0;
            pointer-events: none;
        }

        .side-pattern img {
            height: calc(100% + 0px);
            width: auto;
            object-fit: cover;
            object-position: left top;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            @page {
                size: A4;
                margin: 0;
                margin-right: 1cm;
                margin-bottom: 0.5cm;
            }

            *,
            *::before,
            *::after {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            html,
            body {
                margin: 0 !important;
                padding: 0 !important;
                background: white !important;
                font-family: 'Times New Roman', serif !important;
            }

            .min-h-screen,
            .bg-gray-100,
            .bg-gray-50 {
                background: white !important;
            }

            #printable {
                zoom: 0.65;
                margin: 0 !important;
                padding: 0 !important;
                position: relative;
                z-index: 1;
            }

            #printable .p-6 {
                padding: 4px !important;
            }

            #printable p {
                margin-bottom: 0 !important;
            }

            table {
                border-collapse: collapse !important;
            }

            .print-section table {
                font-size: 9pt !important;
            }

            img {
                max-width: 100% !important;
            }
        }

        @media screen {
            .max-w-3xl {
                max-width: 48rem;
            }
        }
    </style>

    <div class="max-w-3xl mx-auto mt-4 mb-2 print:hidden flex gap-2">
        <button onclick="window.print()"
            class="flex items-center px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 text-sm transition-colors duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                </path>
            </svg>
            Print Result
        </button>
        <a href="{{ route('generate-examination-result-2026', $result->examinee_number) }}" target="_blank"
            class="flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm transition-colors duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                </path>
            </svg>
            Download PDF
        </a>
    </div>

    <div class="bg-white rounded-lg print:mt-4" id="printable">

        <div class="max-w-3xl mx-auto border border-gray-300 bg-white p-6 rounded mt-2 print:p-2 print:border-0 print:rounded-none print:mt-0 print:max-w-full"
            style="position: relative; overflow: hidden;">
            <!-- Side Pattern - inside container -->
            <div class="side-pattern">
                <img src="{{ asset('images/resultassets/side_pattern_header.png') }}" alt="">
            </div>
            <!-- SKSU Logo Watermark - centered -->
            <div
                style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); pointer-events: none; z-index: 0;">
                <img src="{{ asset('images/resultassets/sksu_logo.png') }}"
                    style="width: 550px; height: auto; opacity: 0.05;">
            </div>
            <div style="position: relative; z-index: 1; margin-left: 45px;">
                <div class="flex">
                    <div class="flex mr-2">
                        <img src="{{ asset('images/resultassets/bagong_pilipinas.png') }}" class="w-16 mx-auto h-16"
                            alt="Bagong Pilipinas Logo">
                        <img src="{{ asset('images/resultassets/sksu_logo.png') }}" class="w-16 mx-auto h-16"
                            alt="SKSU Logo">
                    </div>
                    <div>
                        <p class="leading-[1.1rem] text-gray-600 text-sm font-bold uppercase">Republic of the
                            Philippines</p>
                        <p class="leading-[1.1rem] text-lg text-green-800 font-bold">SULTAN KUDARAT STATE UNIVERSITY</p>
                        <p class="leading-[1.1rem] text-gray-600 text-sm">EJC Montilla, City of Tacurong, 9800</p>
                        <p class="leading-[1.1rem] text-gray-600 text-sm">Province of Sultan Kudarat</p>
                    </div>
                </div>
                <!-- Contact Info -->
                <div class="flex items-center gap-4 text-xs text-gray-700 mt-2 mb-4">
                    <span class="flex items-center">
                        <span class="w-4 h-4 rounded-full bg-green-600 flex items-center justify-center mr-1">
                            <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM4.332 8.027a6.012 6.012 0 011.912-2.706C6.512 5.73 6.974 6 7.5 6A1.5 1.5 0 019 7.5V8a2 2 0 004 0 2 2 0 011.523-1.943A5.977 5.977 0 0116 10c0 .34-.028.675-.083 1H15a2 2 0 00-2 2v2.197A5.973 5.973 0 0110 16v-2a2 2 0 00-2-2 2 2 0 01-2-2 2 2 0 00-1.668-1.973z" clip-rule="evenodd"></path></svg>
                        </span>
                        https://www.sksu.edu.ph
                    </span>
                    <span class="flex items-center">
                        <span class="w-4 h-4 rounded-full bg-green-600 flex items-center justify-center mr-1">
                            <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path></svg>
                        </span>
                        guidance@sksu.edu.ph
                    </span>
                    <span class="flex items-center">
                        <span class="w-4 h-4 rounded-full bg-green-600 flex items-center justify-center mr-1">
                            <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path></svg>
                        </span>
                        0965 917 4078
                    </span>
                </div>
                <div class="flex print-compact mt-4 mb-2">
                    <!-- Photo -->
                    <div class="w-1/4 flex">
                        <div
                            class="border border-gray-400 w-[35mm] h-[45mm] flex items-center justify-center overflow-hidden bg-white">
                            <img src="{{ $photo }}" alt="Photo" class="object-cover w-full h-full">
                        </div>
                    </div>
                    <!-- Header & Details -->
                    <div class="w-3/4 pl-4">
                        <div class="text-sm italic" style="font-family: 'Times New Roman', serif;">Guidance and Testing
                            Center</div>
                        <div class="leading-[1.1rem] font-extrabold mt-1 mb-2 print-text-lg">SKSU TERTIARY
                            PLACEMENT<br>TEST RESULT 2026</div>
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

                <!-- Score Table -->
                <div class="overflow-x-auto -mx-2 sm:mx-0 mt-2">
                    <div class="inline-block min-w-full sm:px-0 px-2">
                        <table class="w-full text-sm border border-black" style="border-collapse: collapse;">
                            <thead>
                                <tr class="text-center">
                                    <th class="border border-black px-2 py-2 font-bold text-xs sm:text-sm">SUBJECT</th>
                                    <th class="border border-black px-2 py-2 font-bold text-xs sm:text-sm">STANDARD
                                        SCORE</th>
                                    <th class="border border-black px-2 py-2 font-bold text-xs sm:text-sm">STANINE</th>
                                    <th class="border border-black px-2 py-2 font-bold text-xs sm:text-sm">QUALITATIVE
                                        INTERPRETATION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border border-black px-2 py-1 text-xs sm:text-sm">ENGLISH</td>
                                    <td class="border border-black px-2 py-1 text-center font-bold text-xs sm:text-sm">
                                        {{ $result->english_standard_score ?? '' }}</td>
                                    <td class="border border-black px-2 py-1 text-center text-xs sm:text-sm">
                                        {{ $result->english_raw_score ?? '' }}</td>
                                    <td class="border border-black px-2 py-1 text-xs sm:text-sm">
                                        {{ $this->stanineInterpretation($result->english_raw_score) }}</td>
                                </tr>
                                <tr>
                                    <td class="border border-black px-2 py-1 text-xs sm:text-sm">SCIENCE</td>
                                    <td class="border border-black px-2 py-1 text-center font-bold text-xs sm:text-sm">
                                        {{ $result->science_standard_score ?? '' }}</td>
                                    <td class="border border-black px-2 py-1 text-center text-xs sm:text-sm">
                                        {{ $result->science_raw_score ?? '' }}</td>
                                    <td class="border border-black px-2 py-1 text-xs sm:text-sm">
                                        {{ $this->stanineInterpretation($result->science_raw_score) }}</td>
                                </tr>
                                <tr>
                                    <td class="border border-black px-2 py-1 text-xs sm:text-sm">MATHEMATICS</td>
                                    <td class="border border-black px-2 py-1 text-center font-bold text-xs sm:text-sm">
                                        {{ $result->math_standard_score ?? '' }}</td>
                                    <td class="border border-black px-2 py-1 text-center text-xs sm:text-sm">
                                        {{ $result->math_raw_score ?? '' }}</td>
                                    <td class="border border-black px-2 py-1 text-xs sm:text-sm">
                                        {{ $this->stanineInterpretation($result->math_raw_score) }}</td>
                                </tr>
                                <tr>
                                    <td class="border border-black px-2 py-1 text-xs sm:text-sm">FILIPINO</td>
                                    <td class="border border-black px-2 py-1 text-center font-bold text-xs sm:text-sm">
                                        {{ $result->filipino_standard_score ?? '' }}</td>
                                    <td class="border border-black px-2 py-1 text-center text-xs sm:text-sm">
                                        {{ $result->filipino_raw_score ?? '' }}</td>
                                    <td class="border border-black px-2 py-1 text-xs sm:text-sm">
                                        {{ $this->stanineInterpretation($result->filipino_raw_score) }}</td>
                                </tr>
                                <tr>
                                    <td class="border border-black px-2 py-1 text-xs sm:text-sm">SOCIAL STUDIES</td>
                                    <td class="border border-black px-2 py-1 text-center font-bold text-xs sm:text-sm">
                                        {{ $result->social_studies_standard_score ?? '' }}</td>
                                    <td class="border border-black px-2 py-1 text-center text-xs sm:text-sm">
                                        {{ $result->social_studies_raw_score ?? '' }}</td>
                                    <td class="border border-black px-2 py-1 text-xs sm:text-sm">
                                        {{ $this->stanineInterpretation($result->social_studies_raw_score) }}</td>
                                </tr>
                                <tr>
                                    <td class="border border-black px-2 py-1 font-bold text-xs sm:text-sm">ESM
                                        COMPETENCY SCORE</td>
                                    <td class="border border-black px-2 py-1 text-center font-bold text-xs sm:text-sm">
                                        {{ $result->esm_standard_score ?? '' }}</td>
                                    <td class="border border-black px-2 py-1 text-center text-xs sm:text-sm">
                                        {{ $result->esm_raw_score ?? '' }}</td>
                                    <td class="border border-black px-2 py-1 text-xs sm:text-sm">
                                        {{ $this->stanineInterpretation($result->esm_raw_score) }}</td>
                                </tr>
                                <tr>
                                    <td class="border border-black px-2 py-1 font-bold text-xs sm:text-sm">OVERALL
                                        SCORE
                                    </td>
                                    <td class="border border-black px-2 py-1 text-center font-bold text-xs sm:text-sm">
                                        {{ $result->total_standard_score ?? '' }}</td>
                                    <td class="border border-black px-2 py-1 text-center text-xs sm:text-sm">
                                        {{ $result->total_raw_score ?? '' }}</td>
                                    <td class="border border-black px-2 py-1 text-xs sm:text-sm font-bold">
                                        {{ $this->stanineInterpretation($result->total_raw_score) }}</td>
                                </tr>
                                <!-- Score Definitions -->
                                <tr>
                                    <td colspan="4" class="border border-black px-2 py-2 text-xs text-justify"
                                        style="line-height: 1.4;">
                                        <p class="mb-2">
                                            <span class="font-bold italic">OVERALL SCORE</span> – The composite score
                                            based on all subjects taken in the SKSU TPT. This score is used for
                                            admission to all other college programs not included under the EMS Score.
                                        </p>
                                        <p>
                                            <span class="font-bold italic">ESM COMPETENCY SCORE</span> - The composite
                                            score based only on English, Mathematics, and Science. This score is used
                                            for admission to the following college programs: Nursing, Midwifery, Medical
                                            Technology, Electronics Engineering, Civil Engineering, Computer
                                            Engineering, Computer Science, Fisheries, Biology, Accountancy, Management
                                            Accounting, Accounting Information Systems, Mathematics Education, and
                                            Science Education.
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Campus Cutoff Table -->
                <livewire:result.score-guide />

                <!-- Signatures -->
                <div class="mt-4 pt-2 print:mt-1 print:pt-0">
                    <div class="flex flex-col sm:flex-row justify-between gap-4 print:gap-1">
                        <div class="flex-1 text-left">
                            <div class="text-xs text-gray-600 mb-1 print:mb-0">Prepared by:</div>
                            <img src="{{ asset('images/signature/john-michael.png') }}" class="h-8 print:h-5"
                                alt="Signature">
                            <div class="text-xs font-bold">JAN MICHAEL B. SALDICAYA, LPT</div>
                            <div class="text-xs text-gray-700">PRC License No.: 1443740</div>
                            <div class="text-xs text-gray-700">Personnel, Guidance and Testing Center</div>
                        </div>
                        <div class="flex-1 text-left">
                            <div class="text-xs text-gray-600 mb-1 print:mb-0">Interpreted by:</div>
                            <img src="{{ asset('images/signature/mark.png') }}" class="h-8 print:h-5"
                                alt="Signature">
                            <div class="text-xs font-bold">MARK F. ONIA, RPm, RPsy</div>
                            <div class="text-xs text-gray-700">PRC License No.: 0004578 / 0001990</div>
                            <div class="text-xs text-gray-700">University Psychometrician</div>
                        </div>
                        <div class="flex-1 text-left">
                            <div class="text-xs text-gray-600 mb-1 print:mb-0">Noted:</div>
                            <img src="{{ asset('images/signature/bacera.png') }}" class="h-8 print:h-5"
                                alt="Signature">
                            <div class="text-xs font-bold">JOSELYN H. BACERA, RGC</div>
                            <div class="text-xs text-gray-700">PRC License No.: 0002274</div>
                            <div class="text-xs text-gray-700">Director, Guidance and Testing Center</div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-2 border-t border-dashed border-gray-400 pt-1 print:mt-1">
                    <p class="text-center text-gray-500 mb-0 print:leading-tight" style="font-size: 8px;"><span
                            class="font-bold">VISION:</span> A leading University in advancing scholarly innovation,
                        multi-cultural convergence, and responsive public service in a borderless Region. | <span
                            class="font-bold">MISSION:</span> The University shall primarily provide advanced
                        instruction and professional training in science and technology, agriculture, fisheries,
                        education and other relevant fields of study. It shall also undertake research and extension
                        services, and provide progressive leadership in its areas of specialization. | <span
                            class="font-bold">MAXIM:</span> Generator of Solutions.</p>
                    <p class="text-center text-gray-500 mb-0 print:leading-tight" style="font-size: 8px;">| <span
                            class="font-bold">CORE VALUES:</span> Patriotism, Respect, Integrity, Zeal, Excellence in
                        Public Service.</p>
                </div>

            </div> <!-- end z-index wrapper -->
        </div>
    </div>
</div>
