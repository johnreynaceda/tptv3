<x-layout.applicant>


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
            border-right: 4px solid black;
        }
        .c-bl{
            border-left: 4px solid black;
        }
        .c-bt{
            border-top: 4px solid black;
        }
        .c-bb{
            border-bottom: 4px solid black;
        }

        .custom-dashed {
    border-top: 2px dashed black;
    border-top-style: dashed;
    border-spacing:20px !important; 
    border-width: 3px;
  }

    
        </style>
         
         <div class=" mx-auto border border-black p-4 max-w-[8.5in] ">
           
            <div class="text-end mb-6  flex items-center justify-between">
                <div class="text-center w-full">

                    <h1 class=" text-lg uppercase">Sultan Kudarat State University Tertiary Placement Test</h1>
                    <h2 class="font-bold uppercase text-xl">Test Permit</h2>
                </div>
                <div class="flex justify-end  min-w-28">
                    @if(!empty($permit))
                        <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG($permit->generateQrData(), 'QRCODE') }}" 
                             alt="QR Code" 
                             class="h-24 w-24">
                    @else
                        <div class="h-16 w-16 flex text-center text-xs items-center justify-center border border-gray-400 rounded bg-gray-100 text-gray-600">
                            <p>No</p>
                            <p>Schedule</p>
                        </div>
                    @endif
                </div>
               
            </div>
    
            <div class="">
                <div class="flex">
                    <!-- Left Section: Photo and Examinee Number -->
                    <div>
                        <div class="w-24 h-24 border border-black flex items-center justify-center">
                            <img src="{{ Storage::url($permit->user->personal_information->photo) }}" alt="User Photo" class="h-full">
                        </div>
                        <div class="text-center">
                            <p class="text-lg font-bold">1.11414</p>
                            <p class="text-sm">Examinee Number</p>
                        </div>
                    </div>
                    
                    <!-- Right Section: Personal Details -->
                    <div class="">
                        <p class="text-sm"><span class="font-bold">Full Name:</span> DELA CRUZ, JUAN PEDRO</p>
                        <p class="text-sm"><span class="font-bold">Present Address:</span> BARANGAY TINA, TACURONG CITY</p>
                        <p class="text-sm"><span class="font-bold">School:</span> TACURONG NATIONAL HIGH SCHOOL</p>
                        <p class="text-sm"><span class="font-bold">Sex:</span> MALE</p>
                        <p class="text-sm"><span class="font-bold">Date of Birth:</span> JUNE 15, 1989</p>
                        <p class="text-sm"><span class="font-bold">PWD / Pregnant / Special Need:</span> YES</p>
                    </div>
                </div>
                
    
               
            </div>
    
            <div class="mt-4 grid grid-cols-2 gap-4 ">
                <div class="">
                    <h3 class="text-sm font-semibold  border-black">Appointment Details</h3>
                    <p class="text-sm"><span class="font-bold">Date of Exam:</span> February 2, 2024</p>
                    <p class="text-sm"><span class="font-bold">Time:</span> 07:30AM</p>
                    <p class="text-sm"><span class="font-bold">Testing Site:</span> ACCESS Campus</p>
                </div>
                <div>
                    <h3 class="text-sm font-semibold  border-black">Examination Requirements</h3>
                    <ul class="list-disc list-inside text-sm">
                        <li>Printed Test Permit (A4 or Short Size Bond Paper)</li>
                        <li>Pencil No. 2 with Eraser</li>
                        <li>School ID or any Valid ID</li>
                    </ul>
                </div>
            </div>
    
            <div class="mt-4">
                <h3 class="text-sm font-semibold ">Important Reminders</h3>
                <ol class="list-decimal list-inside text-sm space-y-1">
                    <li>All examinees are required to wear closed shoes, white polo shirt or T-shirt, and long pants or long skirt. Strictly no tattered pants and long slit skirt.</li>
                    <li>Admission of examinees is on a First Come, First Serve Basis. All examinees are advised to proceed at the testing site 30 minutes before the examination starts. Late examinees will no longer be entertained.</li>
                    <li>Parents or guardians are not allowed to enter the university premises during the examination.</li>
                    <li>You are only allowed to take the examination once. Taking the examination twice will result in disqualification of your application for admission to SKSU.</li>
                    <li>Backpack or any other large bags are not allowed inside the university premises.</li>
                </ol>
            </div>
            
            <div class="my-4">
                <hr class="border-t-2 custom-dashed ">
            </div>
            
            <div class="mt-6  pt-4">
                <p class="text-sm">To be filled out by SKSU Personnel only.</p>
                <div class="mt-4 text-center">
                    <h4 class="text-sm font-semibold">Examiner's Confirmation</h4>
                </div>
                <div class="mt-4 flex justify-between items-center">
                    <div class="w-1/2">
                        <p class="text-sm">Signature over printed name</p>
                        <div class="border-b border-black"></div>
                    </div>
                    <div class="w-1/4">
                        <p class="text-sm">Date</p>
                        <div class="border-b border-black"></div>
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

        

        
</x-layout.applicant>
