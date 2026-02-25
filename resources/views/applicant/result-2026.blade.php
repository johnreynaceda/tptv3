<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1">
    <meta name="csrf-token"
        content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="preconnect"
        href="https://fonts.googleapis.com">
    <link rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap"
        rel="stylesheet">
    <!-- Styles -->
    <link rel="stylesheet"
        href="{{ mix('css/app.css') }}">

    @livewireStyles
    @wireUiScripts

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"
        defer></script>

        <style>
            /* Side pattern container - visible on screen and print */
            .result-container {
                position: relative;
                min-height: 100vh;
                background: white;
            }

            .side-pattern {
                position: absolute;
                top: -76px;
                left: 0;
                right: 0;
                bottom: 0;
                z-index: 0;
                pointer-events: none;
            }
            .side-pattern img {
                height: calc(100% + 76px);
                width: 100%;
                object-fit: fill;
                object-position: left top;
            }

            .result-content {
                position: relative;
                z-index: 1;
                margin-left: 50px;
            }

            @media print {
              .no-print { display: none !important; }
              .print-only { display: block !important; }

              @page {
                size: A4;
                margin: 0;
                margin-right: 1cm;
                margin-bottom: 0.5cm;
              }

              .side-pattern {
                position: fixed;
              }

              *, *::before, *::after {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
              }

              html, body {
                margin: 0 !important;
                padding: 0 !important;
                background: white !important;
                font-family: 'Times New Roman', serif !important;
                font-size: 12pt;
                line-height: 1.4;
                color: #333;
              }

              #printable {
                zoom: 0.65;
                margin: 0 !important;
                padding: 0 !important;
                position: relative;
                z-index: 1;
              }

              .result-content {
                margin-left: 50px !important;
              }

              #printable .p-6 { padding: 4px !important; }
              #printable p { margin-bottom: 0 !important; }
              .print-compact { margin: 0 !important; padding: 2px !important; }

              table { border-collapse: collapse !important; }

              img { max-width: 100% !important; }

              /* Watermark */
              .print-watermark {
                display: block !important;
              }
            }

            /* Watermark - visible on both screen and print */
            .watermark {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                pointer-events: none;
                z-index: 0;
            }
            .watermark img {
                width: 700px;
                height: auto;
                opacity: 0.05;
            }

            @media screen {
              .max-w-3xl {
                max-width: 48rem;
              }
              .print-only { display: none; }
            }
            </style>
</head>

<body x-data="{
    printDiv() {
        window.print();
    }
}"
    class="print:py-0 antialiased font-poppins">
    <div class="result-container">
        <!-- Side Pattern - visible on screen and print -->
        <div class="side-pattern">
            <img src="{{ asset('images/resultassets/side_pattern_header.png') }}" alt="">
        </div>

        <div class="result-content py-10 print:py-0">
    <div class="no-print flex justify-between items-center max-w-3xl px-3 mx-auto sm:px-0">
        <h1 class="text-xl sm:text-2xl font-bold">
            TPT RESULT
        </h1>
        <div class="flex space-x-3">
            <a href="{{ route('generate-examination-result-2026', $examinee_number) }}"
                target="_blank">
                <x-button icon="download"
                    info
                    class="text-xs sm:text-sm">
                    Download PDF
                </x-button>
            </a>
            <x-button onclick="window.print()"
                icon="printer"
                positive
                class="text-xs sm:text-sm hidden sm:inline-flex">
                Print Result
            </x-button>
        </div>
    </div>
    <div id="printable"
        class="px-3 sm:px-0 print:p-0 print:m-0 print:bg-white print:shadow-none print:max-w-full">

        <div class="max-w-3xl mx-auto border border-gray-300 bg-white p-6 rounded mt-8 print:p-2 print:border-0 print:rounded-none print:mt-0 print:max-w-full print-compact" style="position: relative; overflow: hidden;">
            <!-- SKSU Logo Watermark - centered -->
            <div class="watermark">
                <img src="{{ asset('images/resultassets/sksu_logo.png') }}" alt="">
            </div>
            <div style="position: relative; z-index: 1; margin-left: 45px;">
            <!-- OFFICIAL HEADER WITH LOGOS -->
             <div>

        <div class="flex">
            <div class="flex mr-2">
                <img src="{{ asset('images/resultassets/bagong_pilipinas.png') }}" class="w-16 mx-auto h-16" alt="Bagong Pilipinas Logo">
                <img src="{{ asset('images/resultassets/sksu_logo.png') }}" class="w-16 mx-auto h-16" alt="SKSU Logo">
            </div>
            <div>
                <p class="leading-[1.1rem] text-gray-600 text-sm font-bold uppercase">Republic of the Philippines</p>
                <p class="leading-[1.1rem] text-lg text-green-800 font-bold">SULTAN KUDARAT STATE UNIVERSITY</p>
                <p class="leading-[1.1rem] text-gray-600 text-sm">EJC Montilla, City of Tacurong, 9800</p>
                <p class="leading-[1.1rem] text-gray-600 text-sm">Province of Sultan Kudarat</p>
            </div>
        </div>
        <!-- Contact Info -->
        <div class="flex items-center gap-4 text-xs text-gray-700 mt-2 mb-4">
            <span class="flex items-center">
                <span class="w-4 h-4 rounded-full bg-green-600 flex items-center justify-center mr-1">
                    <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM4.332 8.027a6.012 6.012 0 011.912-2.706C6.512 5.73 6.974 6 7.5 6A1.5 1.5 0 019 7.5V8a2 2 0 004 0 2 2 0 011.523-1.943A5.977 5.977 0 0116 10c0 .34-.028.675-.083 1H15a2 2 0 00-2 2v2.197A5.973 5.973 0 0110 16v-2a2 2 0 00-2-2 2 2 0 01-2-2 2 2 0 00-1.668-1.973z" clip-rule="evenodd"></path>
                    </svg>
                </span>
                https://www.sksu.edu.ph
            </span>
            <span class="flex items-center">
                <span class="w-4 h-4 rounded-full bg-green-600 flex items-center justify-center mr-1">
                    <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                    </svg>
                </span>
                guidance@sksu.edu.ph
            </span>
            <span class="flex items-center">
                <span class="w-4 h-4 rounded-full bg-green-600 flex items-center justify-center mr-1">
                    <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                    </svg>
                </span>
                0965 917 4078
            </span>
        </div>
    @if(isset($resultsVisible) && !$resultsVisible)
    <!-- Results are not visible -->
    <div class="max-w-3xl mx-auto border border-gray-300 bg-white p-6 rounded mt-8">
        <div class="flex items-center justify-center py-12">
            <div class="text-center">
                <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4 mb-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">Results Not Available</h3>
                            <div class="mt-2 text-sm text-yellow-700">
                                <p>The examination results are not yet available for viewing. Please check back later or contact the Guidance and Testing Center for more information.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="text-gray-600 mt-4">Results will be made available once they are finalized and released by the administration.</p>
            </div>
        </div>
    </div>
    @else
    <!-- Results are visible -->
    <div class="flex print-compact mt-10 mb-2">

        <!-- Photo Placeholder - Standard Passport Size -->
        <div class="w-1/4 flex">
            <div class="border border-gray-400 w-[35mm] h-[45mm] print-photo flex items-center justify-center overflow-hidden bg-white">
                <img src="{{ Auth::user()->personal_information->photo ? asset('storage/' . Auth::user()->personal_information->photo) : asset('images/placeholder.png') }}" alt="Photo" class="object-cover w-full h-full">
            </div>
        </div>
        <!-- Header & Details -->
        <div class="w-3/4 pl-4">
            <div class="text-sm italic" style="font-family: 'Times New Roman', serif;">Guidance and Testing Center</div>
            <div class="leading-[1.1rem] font-extrabold mt-1 mb-2 print-text-lg">SKSU TERTIARY PLACEMENT<br>TEST RESULT 2026</div>
            <div class="mt-2 text-sm">
                <div class="mb-1">
                    <span class="font-semibold inline-block w-40 uppercase">NAME OF EXAMINEE</span>
                    <span>: {{ $user_personal_information->first_name ?? '' }} {{ $user_personal_information->middle_name ?? '' }} {{ $user_personal_information->last_name ?? '' }} {{ $user_personal_information->extension ?? '' }}</span>
                </div>
                <div class="mb-1">
                    <span class="font-semibold inline-block w-40">EXAMINEE NUMBER</span>
                    <span>: {{ $examinee_number ?? 'N/A' }}</span>
                </div>
                <div class="mb-1">
                    <span class="font-semibold inline-block w-40">PREFERRED PROGRAM</span>
                    <span>: {{ $preferred_program ?? 'N/A' }}</span>
                </div>
                <div class="mb-1">
                    <span class="font-semibold inline-block w-40">DATE OF EXAMINATION</span>
                    <span>: January 11, 2026</span>
                </div>
            </div>
        </div>
    </div>


    <livewire:result.score-result />

    <livewire:result.score-guide />

    <!-- Signatures with labels matching PDF (after cutoff table) -->
    <div class="mt-4 pt-2 print:mt-1 print:pt-0 print-keep-together">
        <div class="flex flex-col sm:flex-row justify-between gap-4 print:gap-1">
            <div class="flex-1 text-left">
                <div class="text-xs text-gray-600 mb-1 print:mb-0">Prepared by:</div>
                <img src="{{ asset('images/signature/john-michael.png') }}" class="h-8 print:h-5" alt="Signature">
                <div class="text-xs font-bold print:text-[9px]">JAN MICHAEL B. SALDICAYA, LPT</div>
                <div class="text-xs text-gray-700 print:text-[8px]">PRC License No.: 1443740</div>
                <div class="text-xs text-gray-700 print:text-[8px]">Personnel, Guidance and Testing Center</div>
            </div>
            <div class="flex-1 text-left">
                <div class="text-xs text-gray-600 mb-1 print:mb-0">Interpreted by:</div>
                <img src="{{ asset('images/signature/mark.png') }}" class="h-8 print:h-5" alt="Signature">
                <div class="text-xs font-bold print:text-[9px]">MARK F. ONIA, RPm, RPsy</div>
                <div class="text-xs text-gray-700 print:text-[8px]">PRC License No.: 0004578 / 0001990</div>
                <div class="text-xs text-gray-700 print:text-[8px]">University Psychometrician</div>
            </div>
            <div class="flex-1 text-left">
                <div class="text-xs text-gray-600 mb-1 print:mb-0">Noted:</div>
                <img src="{{ asset('images/signature/bacera.png') }}" class="h-8 print:h-5" alt="Signature">
                <div class="text-xs font-bold print:text-[9px]">JOSELYN H. BACERA, RGC</div>
                <div class="text-xs text-gray-700 print:text-[8px]">PRC License No.: 0002274</div>
                <div class="text-xs text-gray-700 print:text-[8px]">Director, Guidance and Testing Center</div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="mt-2 border-t border-dashed border-gray-400 pt-1 print:mt-1">
        <p class="text-center text-gray-500 mb-0 print:leading-tight" style="font-size: 8px;"><span class="font-bold">VISION:</span> A leading University in advancing scholarly innovation, multi-cultural convergence, and responsive public service in a borderless Region. | <span class="font-bold">MISSION:</span> The University shall primarily provide advanced instruction and professional training in science and technology, agriculture, fisheries, education and other relevant fields of study. It shall also undertake research and extension services, and provide progressive leadership in its areas of specialization. | <span class="font-bold">MAXIM:</span> Generator of Solutions.</p>
        <p class="text-center text-gray-500 mb-0 print:leading-tight" style="font-size: 8px;">| <span class="font-bold">CORE VALUES:</span> Patriotism, Respect, Integrity, Zeal, Excellence in Public Service.</p>
    </div>

</div>


    <!-- Remarks -->

</div>
</div>

@endif




        </div>
    </div>

        </div> <!-- end result-content -->
    </div> <!-- end result-container -->

    <x-notifications z-index="z-50" />
    <x-dialog z-index="z-50"
        blur="md"
        align="center" />
    @livewireScripts
</body>

</html>
