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
            @media print {
              html, body, #printable {
                width: 100% !important;
                max-width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                box-shadow: none !important;
                background: white !important;
                font-size: 12px !important;
                color: black !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
              }
              /* Ensure table headers/footers repeat properly */
              table { page-break-inside: avoid; }
              tr, img { page-break-inside: avoid; }

              /* Reduce margins and padding for print */
              .print-compact {
                margin: 0 !important;
                padding: 4px !important;
              }

              /* Adjust font sizes for print */
              .print-text-xs { font-size: 8px !important; }
              .print-text-sm { font-size: 10px !important; }
              .print-text-base { font-size: 12px !important; }
              .print-text-lg { font-size: 14px !important; }

              /* Hide non-essential elements when printing */
              .print-hide { display: none !important; }

              /* Ensure page breaks appropriately */
              .print-avoid-break { page-break-inside: avoid; }
              .print-break-after { page-break-after: always; }

              /* Adjust table for print - ensure borders are visible */
              .print-table-compact th, .print-table-compact td {
                padding: 2px 4px !important;
                font-size: 10px !important;
                border-color: #000000 !important;
                border-width: 1px !important;
                color: black !important;
              }

              /* Make only table cell borders visible and darker */
              .print-table-compact table, .print-table-compact th, .print-table-compact td {
                border-color: #000000 !important;
                border-width: 1px !important;
                border-style: solid !important;
              }

              /* Ensure consistent colors in print but keep borders visible */
              .bg-gray-50, .bg-gray-100 { background-color: white !important; }
              .text-green-800, .text-green-700, .text-green-600 { color: black !important; }
              .text-gray-600, .text-gray-700 { color: #4b5563 !important; }
              .border-[#008000] { border-color: #000000 !important; border-width: 2px !important; }

              /* Only make specific borders visible where intended */
              table .border, table .border-gray-300, table .border-gray-400,
              .border-gray-300.px-2, .border-gray-400.px-2 {
                border-color: #000000 !important;
                border-width: 1px !important;
                border-style: solid !important;
              }

              /* Remove borders from parent containers */
              #printable, .max-w-3xl, .mx-auto {
                border: none !important;
              }
            }

            /* Optimize viewing experience */
            @media screen {
              .max-w-3xl {
                max-width: 48rem;
              }
            }
            </style>
</head>

<body x-data="{
    printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
}"
    class="py-10 antialiased font-poppins ">
    <div class="flex justify-between items-center max-w-3xl px-3 mx-auto sm:px-0">
        <h1 class="text-xl sm:text-2xl font-bold">
            TPT RESULT
        </h1>
        <div class="flex space-x-3">
            <x-button x-on:click="printDiv('printable')"
                icon="printer"
                positive
                class="text-xs sm:text-sm">
                Print Result
            </x-button>
        </div>
    </div>
    <div id="printable"
        class="px-3 sm:px-0 print:p-0 print:m-0 print:bg-white print:shadow-none print:max-w-full">

        <div class="max-w-3xl mx-auto border border-gray-300 bg-white p-6 rounded mt-8 print:p-2 print:border-0 print:rounded-none print:mt-0 print:max-w-full print-compact">
            <!-- OFFICIAL HEADER WITH LOGOS -->
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
    <div class="flex print-compact print-avoid-break mt-4">

        <!-- Photo Placeholder - Standard Passport Size -->
        <div class="w-1/4 flex">
            <div class="border border-gray-400 w-[35mm] h-[45mm] flex items-center justify-center overflow-hidden bg-white">
                <img src="{{Auth::user()->personal_information->photo ?? asset('images/placeholder.png') }}" alt="{{Auth::user()->personal_information->photo ?? 'images/sksu1.png' }}" class="object-cover w-full h-full">
            </div>
        </div>
        <!-- Header & Details -->
        <div class="w-3/4 pl-4">
            <div class="text-sm font-medium">Guidance and Testing Center</div>
            <div class="leading-[1.1rem] font-extrabold mt-1 mb-2 print-text-lg">SKSU TERTIARY PLACEMENT<br>TEST RESULT 2025</div>
            <div class="mt-2 text-sm">
                <div class="mb-1">
                    <span class="font-semibold inline-block w-40">NAME OF EXAMINEE</span>
                    <span>: {{ $user_personal_information->first_name ?? '' }} {{ $user_personal_information->middle_name ?? '' }} {{ $user_personal_information->last_name ?? '' }} {{ $user_personal_information->extension ?? '' }}</span>
                </div>
                <div class="mb-1">
                    <span class="font-semibold inline-block w-40">EXAMINEE NUMBER</span>
                    <span>: {{ $examinee_number ?? 'N/A' }}</span>
                </div>
                <div class="mb-1">
                    <span class="font-semibold inline-block w-40">DATE OF EXAMINATION</span>
                    <span>: April 6, 2025</span>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-2 print-compact print-avoid-break">
         <!-- Table -->
                <livewire:result.score-result />
                {{-- <livewire:result.score-guide /> --}}

    </div>

    <livewire:result.score-guide />
    <livewire:footer-signature/>

    <!-- Signatories -->


    {{-- <div class="flex justify-end mt-2 print-compact">
        <span class="text-sm font-bold">FORM B</span>
    </div> --}}
    <footer class="print-text-xs mt-2">
        <div class="text-center text-xs text-gray-600 mb-1 print:mb-0 print:text-[5px] print:leading-none">
            <p class="mb-0">Republic of the Philippines | SULTAN KUDARAT STATE UNIVERSITY | EJC Montilla, City of Tacurong</p>
            <p class="mb-0"><span class="font-bold">VISION:</span> A leading University in advancing scholarly innovation, multi-cultural convergence, and responsive public service.</p>
            <p class="mb-0"><span class="font-bold">CORE VALUES:</span> Patriotism, Respect, Integrity, Zeal, Excellence in Public Service.</p>
        </div>
    </footer>
</div>


    <!-- Remarks -->

</div>

@endif






        {{-- <div class="grid ">
            <div class="flex space-x-2">
                <img src="{{ asset('images/sksu1.png') }}"
                    class="h-28"
                    alt="">
                <div class="grid space-x-1 text-sm font-semibold">
                    <h1>
                        Republic of the Philippines
                    </h1>
                    <h1 class="text-green-700">
                        Sultan Kudarat State University
                    </h1>
                    <h1 class="font-thin">
                        ACCESS, EJC Montilla, 9800 City of Tacurong
                    </h1>
                    <h1 class="font-thin">
                        Province of Sultan Kudarat
                    </h1>
                    <h1 class="font-thin">
                        Tertiary Placement Test Result
                    </h1>
                </div>
            </div>
            <div class="flex mt-10 space-x-2 item-end">

                <img src="{{ Storage::url($user_personal_information->photo) }}"
                    class="h-48"
                    alt="profile.jpg">
                <div class="flex items-center">
                    <div class="grid space-y-3">
                        <h1>
                            Name : <span class="font-semibold">
                                {{ $user_personal_information->first_name }}
                                {{ $user_personal_information->middle_name }}
                                {{ $user_personal_information->last_name }}
                                {{ $user_personal_information->extension }}
                            </span>
                        </h1>

                        @foreach ($user_new_program_choices as $user_program_choice)
                            <h1>
                                @switch($user_program_choice->priority_level)
                                    @case(1)
                                    First Priority : <span class="font-semibold">{{ $user_program_choice->program->name }}</span>
                                        @break
                                    @case(2)
                                    Second Priority :  <span class="font-semibold">{{ $user_program_choice->program->name }}</span>
                                        @break
                                    @case(3)
                                        Third Priority :  <span class="font-semibold">{{ $user_program_choice->program->name }}</span>
                                        @break
                                    @default

                                @endswitch

                                <span class="font-semibold">

                                </span>
                            </h1>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="grid mt-10 space-y-5 px-3">
                <livewire:result.score-result />
                <livewire:result.score-guide />

            </div>
        </div> --}}
    </div>


    <x-notifications z-index="z-50" />
    <x-dialog z-index="z-50"
        blur="md"
        align="center" />
    @livewireScripts
</body>

</html>
