<div>

    <x-layout.ordinary>
        <head>
            <title>Document</title>
            <script src="https://cdn.tailwindcss.com"></script>
        </head>

        <div class="mt-8">
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

        
         
         {{-- <div class=" mx-auto border border-black p-4 max-w-[8.5in] "> --}}
         <div class=" mx-auto  p-4 max-w-[8.5in] ">
           
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
                    <!-- Left Section: Photo and Examinee Number -->
                    <div>
                        <!-- Image Container -->
                        <div class="w-32 h-32  flex items-center justify-center bg-gray-100">
                            @if($permit->user->personal_information->photo)
                                <img src="{{ asset('storage/' . $permit->user->personal_information->photo) }}" alt="User Photo" class="h-full w-full object-cover">
                            @else
                                <span class="text-xs text-gray-500">Photo Not Available</span>
                            @endif
                        </div>
                        
                
                        <!-- Examinee Number -->
                        <div class="text-center mt-2">
                            <p class="text-lg font-bold text-3xl ">{{$permit->examinee_number}}</p>
                            <p class="text-sm">Examinee Number</p>
                        </div>
                    </div>
                
                    <!-- Right Section: Personal Details -->
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
                            <span class="uppercase">{{ $permit->user->personal_information->formatted_date_of_birth ?? 'None' }}</span>
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
                        @if(optional(optional($permit->user->application->student_slot)->slot)->date_of_exam)
                            {{ \Carbon\Carbon::parse($permit->user->application->student_slot->slot->date_of_exam)->format('F d, Y') }}
                        @else
                            Not Assigned
                        @endif
                    </p>
                
                    <!-- Time -->
                    <p class="text-sm">
                        <span class="font-bold">Time:</span> 
                        {{ optional($permit->user->application->student_slot)->time ?? 'Not Assigned' }}
                    </p>
                
                    <!-- Room -->
                    <p class="text-sm">
                        <span class="font-bold">Room:</span> 
                        {{ optional($permit->user->application->student_slot)->room_number ?? 'Not Assigned' }}
                    </p>
                
                    <!-- Testing Site -->
                    <p class="text-sm">
                        <span class="font-bold">Testing Site:</span> 
                        @if(optional(optional(optional($permit->user->application->student_slot)->slot)->test_center)->campus)
                            {{ $permit->user->application->student_slot->slot->test_center->campus->name }} -
                            {{ optional($permit->user->application->student_slot->slot->test_center->slots->first())->building_name ?? 'Not Assigned' }}
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

        

        

    </x-layout.ordinary>
</div>
