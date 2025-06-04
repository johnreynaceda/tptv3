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
    class="py-10 antialiased font-poppins">
    <div class="flex justify-between max-w-5xl px-3 mx-auto sm:px-0">
        <h1>
            TPT RESULT
        </h1>
        <div class="flex space-x-3">
            <x-button x-on:click="printDiv('printable')"
                icon="printer"
                positive>
                Print
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
            <img src="{{ asset('images/bagong_pilipinas.png') }}" class="w-16 mx-auto  h-16" alt="University Logo">
            <img src="{{ asset('images/sksu1.png') }}" class="w-16 mx-auto  h-16" alt="Header Logo">
        </div>
        <div>
            <p class=" leading-[1.1rem] text-gray-600 text-sm font-bold uppercase">Republic of the Philippines</p>
            <p class=" leading-[1.1rem] text-lg text-green-800 font-bold">SULTAN KUDARAT STATE UNIVERSITY</p>
            <p class=" leading-[1.1rem] text-gray-600 text-sm">EJC Montilla, City of Tacurong, 9800</p>
            <p class=" leading-[1.1rem] text-gray-600 text-sm mb-4">Province of Sultan Kudarat</p>
        </div>
    </div>
    <div class="flex items-center justify-center  border-b-2 border-[#008000] pt-1 pb-3 text-gray-700 text-sm">
        <a href="https://www.sksu.edu.ph" target="_blank" class="flex items-center text-xs space-x-2 ml-2 hover:underline">
            <i class="text-green-600  fas fa-globe"></i>
            <span>https://www.sksu.edu.ph</span>
        </a>

        <a href="mailto:officeofthepresident@sksu.edu.ph" class="flex items-center text-xs space-x-2 ml-2 hover:underline">
            <i class="text-green-600  fas fa-envelope"></i>
            <span>officeofthepresident@sksu.edu.ph</span>
        </a>

        <a href="tel:(064)200-7338" class="flex items-center text-xs space-x-2 ml-2 hover:underline">
            <i class="text-green-600  fas fa-phone-alt"></i>
            <span>(064) 200-7338</span>
        </a>
    </div>

</div>


     <div class="flex print-compact print-avoid-break mt-4">


        <!-- Logo Placeholder -->
        <div class="w-1/4 flex   ">
            <div class="border border-gray-400 w-32 h-36 flex items-center justify-center overflow-hidden">
                <img src="{{Auth::user()->personal_information->photo ?? asset('images/placeholder.png') }}" alt="{{Auth::user()->personal_information->photo ?? 'images/sksu1.png' }}" class="w-full h-auto">
            </div>
        </div>
        <!-- Header & Details -->
        <div class="w-3/4 ">
            <div class=" text-sm font-medium">Guidance and Testing Center</div>
            <div class="leading-[1.1rem] font-extrabold mt-1 mb-2 print-text-lg">SKSU TERTIARY PLACEMENT<br>TEST RESULT 2025</div>
            <div class="mt-2 text-sm">
                <div>
                    <span class="font-semibold">NAME OF EXAMINEE</span>
                    <span class="ml-3">: {{ $user_personal_information->first_name ?? '' }} {{ $user_personal_information->middle_name ?? '' }} {{ $user_personal_information->last_name ?? '' }} {{ $user_personal_information->extension ?? '' }}</span>
                </div>
                <div>
                    <span class="font-semibold">EXAMINEE NUMBER</span>
                    <span class="ml-3">: {{ $examinee_number ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="font-semibold">DATE OF EXAMINATION</span>
                    <span class="ml-3">: {{ $result->examination_date ?? 'April 6, 2025' }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-1 print-compact print-avoid-break">
         <!-- Table -->
                <livewire:result.score-result />
                {{-- <livewire:result.score-guide /> --}}

    </div>

    <div class=" rounded  bg-white py-6 print:mt-4 print-compact print-break-after">
    <!-- Title & Subtitle -->
    <div class="text-center mb-4">
        <div class="font-bold text-base">
            SKSU Tertiary Placement Test Cut-off Scores Per Program
        </div>
        <div class="text-xs italic mt-1 text-gray-700">
            The cut-off score is the minimum required score to qualify for a specific program and only applicants who meet or exceed the prescribed standard are eligible for selection.
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full text-xs print-table-compact">
            <thead>
                <tr class="bg-gray-50">
                    <th class="border border-gray-300 px-2 py-1 w-1/4">PROGRAM</th>
                    <th class="border border-gray-300 px-2 py-1 w-1/12">STANDARD SCORE</th>
                    <th class="border border-gray-300 px-2 py-1 w-1/4">PROGRAM</th>
                    <th class="border border-gray-300 px-2 py-1 w-1/12">STANDARD SCORE</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border border-gray-300 px-2 py-1">Bachelor of Science in Medical Technology</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold">650</td>
                    <td class="border border-gray-300 px-2 py-1">Bachelor of Technical-Vocational Teacher Education major in: Electronics Technology</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold">500</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 px-2 py-1">Bachelor of Science in Nursing</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold">600</td>
                    <td class="border border-gray-300 px-2 py-1">Bachelor of Technical-Vocational Teacher Education major in: Food and Service Management</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold">500</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 px-2 py-1">Bachelor of Science in Accountancy</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold">600</td>
                    <td class="border border-gray-300 px-2 py-1">Bachelor of Science in Accounting Information System</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold">475</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 px-2 py-1">Bachelor of Elementary Education</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold">530</td>
                    <td class="border border-gray-300 px-2 py-1">Bachelor of Science in Management Accounting</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold">475</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 px-2 py-1">Bachelor of Physical Education</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold">530</td>
                    <td class="border border-gray-300 px-2 py-1">Bachelor of Arts in Political Science</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold">475</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 px-2 py-1">Bachelor of Secondary Education major in: English</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold">530</td>
                    <td class="border border-gray-300 px-2 py-1">Bachelor of Science in Hospitality Management</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold">475</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 px-2 py-1">Bachelor of Secondary Education major in: Filipino</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold">530</td>
                    <td class="border border-gray-300 px-2 py-1">Bachelor of Science in Tourism Management</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold">475</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 px-2 py-1">Bachelor of Secondary Education major in: Mathematics</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold">530</td>
                    <td class="border border-gray-300 px-2 py-1">Bachelor of Science in Biology</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold">450</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 px-2 py-1">Bachelor of Secondary Education major in: Science</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold">530</td>
                    <td class="border border-gray-300 px-2 py-1">Bachelor of Arts in Economics</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold">450</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 px-2 py-1">Bachelor of Secondary Education major in: Social Studies</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold">530</td>
                    <td class="border border-gray-300 px-2 py-1">Bachelor of Science in Entrepreneurship</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold">450</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 px-2 py-1">Bachelor of Science in Criminology</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold">530</td>
                    <td class="border border-gray-300 px-2 py-1">Bachelor of Science in Industrial Security Management</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold">450</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 px-2 py-1">Bachelor of Science in Civil Engineering</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold">530</td>
                    <td class="border border-gray-300 px-2 py-1">Bachelor of Science in Environmental Science</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold">400</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 px-2 py-1">Bachelor of Science in Computer Engineering</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold">530</td>
                    <td class="border border-gray-300 px-2 py-1">Bachelor of Science in Agribusiness</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold">400</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 px-2 py-1">Bachelor of Science in Electronics Engineering</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold">530</td>
                    <td class="border border-gray-300 px-2 py-1">Bachelor of Science in Computer Science</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold">400</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 px-2 py-1">Bachelor of Science in Midwifery</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold">530</td>
                    <td class="border border-gray-300 px-2 py-1">Bachelor of Science in Information System</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold">400</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 px-2 py-1">Bachelor of Technology and Livelihood Education major in Agri-fishery</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold">500</td>
                    <td class="border border-gray-300 px-2 py-1">Bachelor of Science in Information Technology</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold">400</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 px-2 py-1">Bachelor of Science in Agriculture</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold">500</td>
                    <td class="border border-gray-300 px-2 py-1">Bachelor of Industrial Technology major in: Automotive Technology</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold">400</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 px-2 py-1">Bachelor of Science in Fisheries</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold">500</td>
                    <td class="border border-gray-300 px-2 py-1">Bachelor of Industrial Technology major in: Civil and Construction Technology</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold">400</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 px-2 py-1">Bachelor of Technical Teacher Education major in: Automotive Technology</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold">500</td>
                    <td class="border border-gray-300 px-2 py-1">Bachelor of Industrial Technology major in: Architectural Drafting Technology</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold">400</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 px-2 py-1">Bachelor of Technical-Vocational Teacher Education major in: Civil Technology</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold">500</td>
                    <td class="border border-gray-300 px-2 py-1">Bachelor of Industrial Technology major in: Electrical Technology</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold">400</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 px-2 py-1">Bachelor of Technical-Vocational Teacher Education major in: Drafting Technology</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold">500</td>
                    <td class="border border-gray-300 px-2 py-1">Bachelor of Industrial Technology major in: Electronics Technology</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold">400</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 px-2 py-1">Bachelor of Technical-Vocational Teacher Education major in: Electrical Technology</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold">500</td>
                    <td class="border border-gray-300 px-2 py-1">Bachelor of Industrial Technology major in: Food Innovation and Culinary Technology</td>
                    <td class="border border-gray-300 px-2 py-1 text-center font-bold">400</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Signatories -->
    <div class="mt-6 grid grid-cols-3 gap-2 print:mt-3 print-compact print-avoid-break">
        <div class="flex flex-col ">
            <span class="text-xs print:text-[7px]">Prepared by:</span>
            <div class="flex w-full">
                <img src="{{ asset('images/signature/john-michael.png') }}" class="h-8 my-1 print:h-6" alt="Signature">
            </div>
            <div class="text-xs font-semibold print:text-[7px]">JAN MICHAEL B. SALDICAYA, LPT</div>
            <div class="text-xs text-gray-600 print:text-[6px]">PRC License No.: 1443740</div>
            <div class="text-xs text-gray-600 print:text-[6px]">Personnel, Guidance and Testing Center</div>
        </div>
        <div class="flex flex-col ">
            <span class="text-xs print:text-[7px]">Interpreted by:</span>
            <div class="flex w-full">
                <img src="{{ asset('images/signature/mark.png') }}" class="h-8 my-1 print:h-6" alt="Signature">
            </div>
            <div class="text-xs font-semibold print:text-[7px]">MARK F. ONIA, RPm, RPsy</div>
            <div class="text-xs text-gray-600 print:text-[6px]">PRC License No.: 0004578 / 0001990</div>
            <div class="text-xs text-gray-600 print:text-[6px]">University Psychometrician</div>
        </div>
        <div class="flex flex-col ">
            <span class="text-xs print:text-[7px]">Noted:</span>
            <div class="flex w-full">
                <img src="{{ asset('images/signature/bacera.png') }}" class="h-8 my-1 print:h-6" alt="Signature">
            </div>
            <div class="text-xs font-semibold print:text-[7px]">JOSELYN H. BACERA, RGC</div>
            <div class="text-xs text-gray-600 print:text-[6px]">PRC License No.: 0002274</div>
            <div class="text-xs text-gray-600 print:text-[6px]">Director, Guidance and Testing Center</div>
        </div>
    </div>

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
