<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <!-- Styles -->
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">

  @livewireStyles
  @wireUiScripts

  <style>

    @media print {
      .hidden-print {
        display: none !important;
      }
      
      .ew {
        display: none !important;
      }
    }
  </style>
  <!-- Scripts -->
  <script src="{{ mix('js/app.js') }}" defer></script>
</head>

<body x-data="{
    printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
}" class="antialiased font-poppins">
<div class="mt-8"></div>
<div class="flex hidden-print justify-between max-w-5xl px-3 mx-auto sm:px-0 cmt">
  <h1>
      TPT PERMIT
  </h1>
  <div class="flex space-x-3">
      <livewire:applicant.update-photo />
      <!-- Print Button -->
      <x-button x-on:click="printDiv('printable')" icon="printer" positive>
          Print
      </x-button>
      <!-- Download PDF Button -->
      <a href="{{ route('admin.generate-pdf-permit', $permit) }}"
         class="flex items-center px-4 py-2 text-white bg-green-500 hover:bg-green-600 font-medium text-sm rounded-md shadow focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
          <x-heroicon-o-document-download class="w-5 h-5 mr-2"/> <!-- Optional: Icon -->
          Download PDF
      </a>
  </div>
</div>


  <div class="mt-8"></div>

  <div id="printable" class="px-3 sm:px-0 ">
    <div class="">
      <style>
        @page {
              size: auto;
              margin: 0;
          }
          body {
              margin: 0;
              padding: 0;
              font-size: 10pt;
          }
          .c-br{
              border-right: 3px solid black;
          }
          .c-bl{
              border-left: 3px solid black;
          }
          .c-bt{
              border-top: 3px solid black;
          }
          .c-bb{
              border-bottom: 3px solid black;
          }
  
          .bbt{
              border-top: 1px solid black;
          }
          .bbb{
              border-bottom: 1px solid black;
          }
  
          .custom-dashed {
      border-top: 2px dashed black;
      border-top-style: dashed;
      border-spacing:20px !important; 
      border-width: 3px;
    }
  
      
          </style>
  
          
           
              <div class=" mx-auto border border-black p-4 max-w-[8.5in]  ">
       
             
              <div class="text-end mb-6 flex items-center justify-between">
                  <div class="text-center w-full">
                      <h1 class="text-lg uppercase">Sultan Kudarat State University Tertiary Placement Test</h1>
                      <h2 class="font-bold uppercase text-xl">Test Permit</h2>
                  </div>
                  <div>
                      @if(!empty($permit))
                          <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG($permit->generateQrData(), 'QRCODE') }}" 
                               alt="QR Code" 
                               class="h-24 w-24 ">
                      @else
                          <div class="h-16 w-16 flex text-center text-xs items-center justify-center border border-gray-400 rounded bg-gray-100 text-gray-600">
                              <p>No</p>
                              <p>Schedule</p>
                          </div>
                      @endif
                  </div>
              </div>
              
      
              <div class="">
                  <div class="flex gap-6">
                  
                      <div>
                       
                          <div class="w-32 h-32  flex items-center justify-center bg-gray-100">
                              @if($permit->user->personal_information->photo)
                                  <img src="{{ asset('storage/' . $permit->user->personal_information->photo) }}" alt="User Photo" class="h-full w-full object-cover">
                              @else
                                  <span class="text-xs text-gray-500">Photo Not Available</span>
                              @endif
                          </div>
                          
                  
                        
                          <div class="text-center mt-2">
                              <p class="text-lg font-bold text-3xl ">{{$permit->examinee_number}}</p>
                              <p class="text-sm">Examinee Number</p>
                          </div>
                      </div>
                  
                    
                      <div class="grid grid-cols-1 gap-2">
                          <div class="text-sm flex">
                              <span class="font-bold min-w-[150px]">Full Name:</span>
                              <span class="uppercase">{{ $permit->user->personal_information->fullName() ?? 'None' }}</span>
                          </div>
                          <div class="text-sm flex">
                              <span class="font-bold min-w-[150px]">Present Address:</span>
                              <span class="uppercase">{{ $permit->user->personal_information->present_address ?? 'None' }}</span>
                          </div>
                          <div class="text-sm flex">
                              <span class="font-bold min-w-[150px]">School:</span>
                              <span class="uppercase">{{ $permit->user->school_information->school_graduated ?? 'None' }}</span>
                          </div>
                          <div class="text-sm flex">
                              <span class="font-bold min-w-[150px]">Sex:</span>
                              <span class="uppercase">{{ $permit->user->personal_information->sex ?? 'None' }}</span>
                          </div>
                          <div class="text-sm flex">
                              <span class="font-bold min-w-[150px]">Date of Birth:</span>
                              <span class="uppercase">{{ $permit->user->personal_information->date_of_birth ?? 'None' }}</span>
                          </div>
                          <div class="text-sm flex items-center">
                              <span class="font-bold min-w-[150px]">PWD / Pregnant / Special Need:</span>
                              <span class="ml-2 flex items-center gap-6">
                                  <span class="flex items-center">
                                      <span class="w-3 h-3 border border-black inline-block mr-2"></span>
                                      <span class="">Yes</span>
                                  </span>
                                  <span class="flex items-center">
                                      <span class="w-3 h-3 border border-black inline-block mr-2"></span>
                                      <span class="">No</span>
                                  </span>
                              </span>
                          </div>
                          
                          
                      </div>
                      
                  </div>
                  
                  
      
                 
              </div>
      
              <div class="mt-4 grid grid-cols-2 gap-4 c-bt c-bb ">
                <div class="c-br p-2">
                  <h3 class="text-sm font-semibold border-black">Appointment Details</h3>
              
                  <!-- Date of Exam -->
                  <p class="text-sm">
                      <span class="font-bold">Date of Exam:</span> 
                      @if(optional(optional(auth()->user()->application->student_slot)->slot)->date_of_exam)
                          {{ \Carbon\Carbon::parse(auth()->user()->application->student_slot->slot->date_of_exam)->format('F d, Y') }}
                      @else
                          Not Assigned
                      @endif
                  </p>
              
                  <!-- Time -->
                  <p class="text-sm">
                      <span class="font-bold">Time:</span> 
                      {{ optional(auth()->user()->application->student_slot)->time ?? 'Not Assigned' }}
                  </p>
              
                  <!-- Room -->
                  <p class="text-sm">
                      <span class="font-bold">Room:</span> 
                      {{ optional(auth()->user()->application->student_slot)->room_number ?? 'Not Assigned' }}
                  </p>
              
                  <!-- Testing Site -->
                  <p class="text-sm">
                      <span class="font-bold">Testing Site:</span> 
                      @if(optional(optional(optional(auth()->user()->application->student_slot)->slot)->test_center)->campus)
                          {{ auth()->user()->application->student_slot->slot->test_center->campus->name }} -
                          {{ optional(auth()->user()->application->student_slot->slot->test_center->slots->first())->building_name ?? 'Not Assigned' }}
                      @else
                          Not Assigned
                      @endif
                  </p>
              </div>
              
                  <div class="p-2">
                      <h3 class="text-sm font-semibold  border-black">Examination Requirements</h3>
                      <ol class="list-decimal list-inside text-sm" >
                          <li class="">Printed Test Permit <span class="text-xs text-gray-600 italic">(A4 or Short Size Bond Paper)</span></li>
                          <li class="">Pencil No. 2 with Eraser</li>
                          <li class="">School ID or any Valid ID</li>
                      </ol>
                  </div>
              </div>
      
              <div class="mt-4">
                  <h2 class="font-bold uppercase text-xl text-center">Important Reminders</h2>
                  <ol class="list-decimal list-inside text-sm  pl-4">
                      <li class="">
                          All examinees are required to wear closed shoes, white polo shirt or T-shirt, and long pants or long skirt. Strictly no tattered pants and long slit skirt.
                      </li>
                      <li class="">
                          Admission of examinees is on a First Come, First Serve Basis. All examinees are advised to proceed at the testing site 30 minutes before the examination starts. Late examinees will no longer be entertained.
                      </li>
                      <li class="">
                          Parents or guardians are not allowed to enter the university premises during the examination.
                      </li>
                      <li class="">
                          You are only allowed to take the examination once. Taking the examination twice will result in disqualification of your application for admission to SKSU.
                      </li>
                      <li class="">
                          Backpack or any other large bags are not allowed inside the university premises.
                      </li>
                  </ol>
                  
              </div>
              
              <div class="my-4">
                  <hr class="border-t-2 custom-dashed ">
              </div>
              
              <div class="mt-6  pt-4">
                  <p class="text-sm">To be filled out by SKSU Personnel only.</p>
                  <div class="mt-8 text-center">
                      <h2 class=" uppercase text-xl text-center">Examiner's Confirmation</h2>
                  </div>
                  <div class="mt-14 flex justify-around items-center space-x-12">
                      <div class="flex flex-col items-center">
                          <div class="bbb   w-full  mt-1"></div>
                          <p class="text-sm px-4">Signature over printed name</p>
                      </div>
                      <div class="flex flex-col items-center">
                          <div class="bbb w-full mt-1"></div>
                          <p class="text-sm px-4">Date</p>
                      </div>
                  </div>
              </div>
      
              <div class="mt-4">
                  <p class="text-xs font-light text-justify">
                      <span class="font-bold">VISION:</span> A leading University in advancing scholarly innovation, multi-cultural convergence, and responsive public service in a borderless Region. 
                      <span class="font-bold">MISSION:</span> The University shall primarily provide advanced instruction and professional training in science and technology, agriculture, fisheries, education and other relevant fields of study. It shall also undertake research and extension services, and provide progressive leadership in its areas of specialization. 
                      <span class="font-bold">CORE VALUES:</span> Patriotism, Respect, Integrity, Zeal, Excellence in Public Service.
                  </p>
              </div>
          </div>
  
          
  
          
     {{-- <div class="flex justify-between max-w-5xl mx-auto mt-10 border-4 border-gray-800 ">
      <div class="grid w-full space-y-2">
        <div class="flex justify-around p-4">
          <div>
            <img src="{{ asset('images/sksu1.png') }}" class="h-20" alt="...">
          </div>
          <div class="grid justify-center text-center">
            <h1>
              Republic of the Philippines
            </h1>
            <h1 class="text-xl font-semibold text-green-600 uppercase">
              Sultan Kudarat State University
            </h1>
            <h1>
              ACCESS, EJC Montilla, 9800 City of Tacurong
            </h1>
            <h1>
              Province of Sultan Kudarat
            </h1>
          </div>
          <div>
            <img src="{{ asset('images/logo2.png') }}" class="h-20" alt="...">
          </div>
        </div>
        <div class="flex justify-center">
          <h1 class="text-xl font-bold text-center text-gray-800">
            SULTAN KUDARAT STATE UNIVERSITY - TERTIARY PLACEMENT TEST
          </h1>
        </div>
        <div class="w-full h-1 bg-black"></div>
        <div class="grid grid-cols-4 pl-1">
          <div class="col-span-1">
            <div class="grid justify-center ">
              <div class="flex justify-center">
                <img src="{{ Storage::url($personal_information->photo) }}" class="h-44" alt="">
              </div>
              <div class="w-full mt-1 text-center text-2xl text-white bg-gray-800">
                {{ $permit->examinee_number_updated }}
              </div>
              <div class="my-2">
                <h1 class="text-center">Confirmation</h1>
                <div class="w-full h-0.5 mt-10 bg-gray-500"></div>
                <h1 class="text-sm bg-gray-100 text-center">
                  Signature over printed name
                </h1>
                <div class="w-full h-0.5 mt-10  bg-gray-500"></div>
                <h1 class="text-sm bg-gray-100 text-center">
                  Date
                </h1>
              </div>
            </div>
          </div>
          <div class="col-span-3">
            <div class="overflow-hidden ">

             

              <div class="border-gray-200 px-6 ">
                <dl class="">
                  <div class=" grid grid-cols-3 gap-4 py-0.5">
                    <dt class="text-sm font-medium text-gray-500">Full name</dt>
                    <dd class=" flex text-sm text-gray-900 col-span-2 sm:mt-0">
                      <p class="flex-1"> {{ $personal_information->first_name }}
                        {{ $personal_information->middle_name }}
                        {{ $personal_information->last_name }}
                        {{ $personal_information->extension }}</p>

                    </dd>
                  </div>
                  <div class=" grid grid-cols-3 gap-4 py-0.5">
                    <dt class="text-sm font-medium text-gray-500">Present Address</dt>
                    <dd class=" flex text-sm text-gray-900 col-span-2 sm:mt-0">
                      <span class="flex-grow">{{ $personal_information->present_address }}</span>

                    </dd>
                  </div>
                  <div class=" grid grid-cols-3 gap-4 py-0.5">
                    <dt class="text-sm font-medium text-gray-500">Permanent address</dt>
                    <dd class=" flex text-sm text-gray-900 col-span-2 sm:mt-0">
                      <span class="flex-grow">{{ $personal_information->permanent_address }}</span>

                    </dd>
                  </div>
                  <div class=" grid grid-cols-3 gap-4 py-0.5">
                    <dt class="text-sm font-medium text-gray-500">Sex</dt>
                    <dd class=" flex text-sm text-gray-900 col-span-2 sm:mt-0">
                      <span class="flex-grow">{{ $personal_information->sex }}</span>

                    </dd>
                  </div>
                  <div class=" grid grid-cols-3 gap-4 py-0.5">
                    <dt class="text-sm font-medium text-gray-500">Date of Birth</dt>
                    <dd class=" flex text-sm text-gray-900 col-span-2 sm:mt-0">
                      <span class="flex-grow">{{ $personal_information->date_of_birth }}</span>
                    </dd>
                  </div>
                  <div class=" grid grid-cols-3 gap-4 py-0.5">
                    <dt class="text-sm font-medium text-gray-500">Contact Number</dt>
                    <dd class=" flex text-sm text-gray-900 col-span-2 sm:mt-0">
                      <span class="flex-grow">{{ $personal_information->phone_number }}</span>
                    </dd>
                  </div>
                  @if (auth()->user()->type_id == 1)
                  <div class=" grid grid-cols-3 gap-4 py-0.5">
                    <dt class="text-sm font-medium text-gray-500">School Graduated</dt>
                    <dd class=" flex text-sm text-gray-900 col-span-2 sm:mt-0">
                      <span class="flex-grow">{{ $school_information->school_graduated }}</span>
                    </dd>
                  </div>
                  <div class=" grid grid-cols-3 gap-4 py-0.5">
                    <dt class="text-sm font-medium text-gray-500">Senior High School Track</dt>
                    <dd class=" flex text-sm text-gray-900 col-span-2 sm:mt-0">
                      <span class="flex-grow">{{ $school_information->track_and_strand_taken }}</span>
                    </dd>
                  </div>
                  @endif
                  @foreach ($program_choices as $key => $program_choice)
                    <div class=" grid grid-cols-3 gap-4 py-0.5">
                      <dt class="text-sm font-medium text-gray-500">
                        @if ($program_choice->is_priority == 1)
                          First Priority Program
                        @else
                          Second Priority Program
                        @endif
                      </dt>
                      <dd class=" flex text-sm text-gray-900 col-span-2 sm:mt-0">
                        <span class="flex-grow">
                          <div class="flex space-x-1">
                            <span>{{ $program_choice->program->name }} </span>
                            <livewire:applicant.update-program-choice :priority="$program_choice->is_priority" />
                          </div>
                        </span>
                      </dd>
                    </div>
                  @endforeach

                </dl>
              </div>
              <div class=" border-t-4 border-black mt-3  ml-6 ">
                <h1 class="font-bold mt-2 uppercase">Appointment Details</h1>
                <div class="mt-2">
                  @if(optional( auth()->user()->application->student_slot)->slot)
                    <h1 class="text-gray-600 text-sm mt-1">
                        Date of Exam: {{ \Carbon\Carbon::parse( auth()->user()->application->student_slot->slot->date_of_exam)->format('F d, Y') }}
                    </h1>
                @else
                    <h1 class="text-gray-600 text-sm mt-1">
                        Date of Exam: Not Assigned
                    </h1>
                @endif
                  <h1 class="text-gray-600 text-sm mt-1">Time:
                    {{ auth()->user()->application->student_slot->time }}
                  </h1>
                  <h1 class="text-gray-600 text-sm mt-1">Test Center:
                    {{ auth()->user()->application->student_slot->slot->test_center->campus->name }} -
                    {{ auth()->user()->application->student_slot->slot->test_center->slots->first()->building_name }}
                  </h1>
                  <h1 class="text-gray-600 text-sm mt-1">Room:
                    Room {{ auth()->user()->application->student_slot->room_number }}
                  </h1>
                  <h1 class="text-gray-600 text-sm mt-1">Seat Number:
                    #{{ auth()->user()->application->student_slot->seat_number }}
                  </h1>
                </div>
              </div>
              <div class=" border-t-4 border-black mt-3 mb-3  ml-6 ">
                <h1 class="font-bold mt-2">IMPORTANT REMINDERS</h1>
                <div class="mt-2 pr-2">
                  <p class="text-xs py-0.5 text-justify text-gray-700">1. All examinees are required to wear facemask,
                    closed shoes, white
                    polo shirt or
                    shirt, long pants
                    or skirt.</p>
                  <p class="text-xs py-0.5 text-justify text-gray-700">2. All examinees are advised to proceed at the
                    venue 30 minutes
                    before the
                    examination starts. Late examinees will not be entertained.</p>
                  <p class="text-xs py-0.5 text-justify text-gray-700">3. You may visit the venue a day before
                    examination to familiarize
                    the room
                    assignment.</p>
                  <p class="text-xs py-0.5 text-justify text-gray-700">4. Parent/Guardian is NOT allowed to enter the
                    university premises.
                  </p>
                </div>
              </div>
            </div>

          </div>
        </div>

      </div>
    </div> 
  </div> --}}
  <x-notifications z-index="z-50" />
  <x-dialog z-index="z-50" blur="md" align="center" />


  @livewireScripts
</body>

</html>
