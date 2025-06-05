<div class="">
    <style>
        @page {
            size: auto;
            margin: 0 !important;
            padding: 0.5cm 1cm;
            background: white;
        }
        
        @media print {
            @page {
                size: auto;
                margin: 0.5cm 1cm;
            }
            
            html, body {
                width: 100% !important;
                height: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
           
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            #printable {
                width: 100% !important;
                max-width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                background: white !important;
                box-shadow: none !important;
                font-size: 10px !important;
                color: black !important;
            }
            
            body * {
                visibility: hidden;
            }
            
            #printable, #printable * {
                visibility: visible;
            }
            
            #printable {
                width: 100%;
                padding: 0;
                margin: 0 auto;
                max-width: 21cm; /* Standard A4 width */
                position: relative;
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
          html {
            font-size: 12px !important;
          }
          .print-text-xs { font-size: 0.67rem !important; }
          .print-text-sm { font-size: 0.83rem !important; }
          .print-text-base { font-size: 1rem !important; }
          .print-text-lg { font-size: 1.17rem !important; }
          .print-text-xl { font-size: 1.33rem !important; }

          /* Hide non-essential elements when printing */
          .print-hide { display: none !important; }

          /* Ensure page breaks appropriately */
          .print-avoid-break { 
            page-break-inside: avoid;
            break-inside: avoid;
          }
          .print-break-after { 
            page-break-after: always;
            break-after: page;
          }
          
          /* Prevent unwanted page breaks inside important elements */
          table, thead, tbody, tr, td, th, div, p {
            page-break-inside: avoid;
            break-inside: avoid;
          }

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
     
        @page {
            size: auto;
            margin: 0 !important;
          
        }
        
        #printable {
            width: 100%;
            margin: 0 auto;
            padding: 0;
            max-width: 21cm;
        }
        
        .print-table-compact {
            page-break-inside: avoid;
        }
        
        .print-avoid-break {
            page-break-inside: avoid;
        }
    </style>
    <div class="pt-2">

        
    </div>
      <div class="max-w-3xl mx-auto mt-4 mb-2 print:hidden mt-8">
        <button onclick="window.print()" 
                class="flex items-center px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 text-sm transition-colors duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                </path>
            </svg>
            Print Result
        </button>
    </div>
 
        
<div class="px-3 sm:px-0 print:p-0 print:m-0 print:bg-white print:shadow-none print:max-w-full print:pt-0 print:mx-auto " id="printable">
    <!-- Print Button -->
   
   <!-- Print Button -->
  
    <div class="max-w-3xl mx-auto border border-gray-300 bg-white   p-6 rounded mt-2 print:p-2 print:border-0 print:rounded-none print:mt-0 print:max-w-full print-compact">
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

        <div class="flex print-compact print-avoid-break mt-4">

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
                        <span class="font-semibold inline-block w-40">NAME OF EXAMINEE</span>
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
        
        </div>
    
        <!-- Score Guide -->
        {{-- <livewire:result.score-guide /> --}}
        <div class="mt-4">
            <livewire:footer-signature/>
        </div>
  
    
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
