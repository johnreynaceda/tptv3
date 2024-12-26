<div>
    <x-layout.admin>
        <style>
            @media print {
                .hidden-print {
                    display: none !important;
                }

                .permit-number {
                    background-color: black !important;
                    color: white !important;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                }

                .cut-line {
                    
                    border-top: 2px dashed black;
                    margin: 10px 0;
                }

                .qr-code {
                    float: right;
                    margin-right: 10px;
                }
                .admin{
                    background: white !important;
                }
            }
        </style>

        <div class="py-10 antialiased font-poppins">
            <!-- Top Header -->
            <div class="hidden-print flex justify-between max-w-5xl mx-auto px-3 sm:px-0">
                <h1 class="font-bold text-lg">TPT PERMIT</h1>
                <x-button onclick="printDiv('printable')" icon="printer" positive>
                    Print
                </x-button>
            </div>

            <!-- Printable Section -->
            <div id="printable" class="max-w-5xl mx-auto mt-8 border border-black bg-white">
                <!-- Header Section -->
                <div class="flex justify-between items-center p-4 border-b border-black relative">
                    <div>
                        <img src="{{ asset('images/sksu1.png') }}" class="h-16" alt="SKSU Logo">
                    </div>
                    <div class="text-center">
                        <h1 class="font-bold text-lg">SULTAN KUDARAT STATE UNIVERSITY</h1>
                        <h2 class="text-sm font-medium text-gray-600">TERTIARY PLACEMENT TEST</h2>
                    </div>
                    <div>
                        <img src="{{ asset('images/logo2.png') }}" class="h-16" alt="SKSU Logo">
                    </div>
                    <!-- QR Code -->
                    <div class="absolute top-4 right-4">
                        <img src="{{ asset('images/qr-code-placeholder.png') }}" alt="QR Code" class="h-16 w-16">
                    </div>
                </div>

                <!-- Examinee Details -->
                <div class="grid grid-cols-4 gap-4 p-4">
                    <!-- Photo & Permit Number -->
                    <div class="col-span-1 text-center">
                        <div class="border border-black w-full h-40 flex items-center justify-center">
                            <img src="{{ Storage::url($personal_information->photo) }}" alt="User Photo" class="h-full">
                        </div>
                        <div class="mt-3 bg-black text-white permit-number py-2 text-lg font-bold">
                            {{ $permit->examinee_number_updated??'' }}
                        </div>
                    </div>

                    <!-- Personal Information -->
                    <div class="col-span-3">
                        <dl class="grid grid-cols-3 gap-2">
                            <div>
                                <dt class="text-xs font-medium text-gray-600">Full Name:</dt>
                                <dd class="text-sm text-gray-900">
                                    {{ $personal_information->first_name }}
                                    {{ $personal_information->middle_name }}
                                    {{ $personal_information->last_name }}
                                    {{ $personal_information->extension }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-gray-600">Present Address:</dt>
                                <dd class="text-sm text-gray-900">{{ $personal_information->present_address }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-gray-600">School:</dt>
                                <dd class="text-sm text-gray-900">{{ $school_information->school_graduated }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-gray-600">Sex:</dt>
                                <dd class="text-sm text-gray-900">{{ $personal_information->sex }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-gray-600">Date of Birth:</dt>
                                <dd class="text-sm text-gray-900">{{ $personal_information->date_of_birth }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-gray-600">PWD / Pregnant / Special Need:</dt>
                                <dd class="text-sm text-gray-900">{{ $personal_information->special_need ? 'YES' : 'NO' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Appointment & Examination Details -->
                <div class="grid grid-cols-2 gap-4 px-4 border-t border-black py-3">
                    <div>
                        <h2 class="text-sm font-bold text-gray-800">APPOINTMENT DETAILS</h2>
                        <p class="text-xs text-gray-800 mt-1">Date of Exam: 
                            @if(optional($user->application->student_slot)->slot)
                                {{ \Carbon\Carbon::parse($user->application->student_slot->slot->date_of_exam)->format('F d, Y') }}
                            @else
                                Not Assigned
                            @endif
                        </p>
                        <p class="text-xs text-gray-800">Time: {{ $user->application->student_slot->time ?? 'Not Assigned' }}</p>
                        <p class="text-xs text-gray-800">Testing Site: {{ $user->application->student_slot->slot->test_center->campus->name ?? 'Not Assigned' }}</p>
                    </div>
                    <div>
                        <h2 class="text-sm font-bold text-gray-800">EXAMINATION REQUIREMENTS</h2>
                        <ul class="text-xs text-gray-800 list-disc pl-5">
                            <li>Printed Test Permit (A4 or Short Size Bond Paper)</li>
                            <li>Pencil No. 2 with Eraser</li>
                            <li>School ID or Any Valid ID</li>
                        </ul>
                    </div>
                </div>

                <!-- Reminders Section -->
                <div class="px-4 border-t border-black py-3">
                    <h2 class="text-sm font-bold text-gray-800 text-center">IMPORTANT REMINDERS</h2>
                    <ol class="text-xs text-gray-800 list-decimal pl-5 mt-2">
                        <li class="list-item">All examinees are required to wear closed shoes, white polo shirt or T-shirt, and long pants or long skirt.</li>
                        <li class="list-item">Admission of examinees is on a First Come, First Serve Basis.</li>
                        <li class="list-item">All examinees are advised to proceed to the testing site 30 minutes before the examination starts.</li>
                        <li class="list-item">Parents or guardians are not allowed to enter the university premises during the examination.</li>
                        <li class="list-item">You are only allowed to take the examination once. Taking it twice will result in disqualification.</li>
                        <li class="list-item">Backpacks or any large bags are not allowed inside the university premises.</li>
                    </ol>
                    
                    
                </div>

                <!-- Cut Line -->
                <div class="cut-line"></div>

                <!-- Confirmation Section -->
                <div class="px-4 border-t border-black py-3 text-center">
                    <p class="text-xs font-bold text-gray-800">EXAMINER'S CONFIRMATION</p>
                    <div class="flex justify-between mt-6 text-xs">
                        <p class="border-t border-black flex-1 text-center">Signature over printed name</p>
                        <p class="border-t border-black flex-1 text-center ml-4">Date</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Print Script -->
        <script>
            function printDiv(divName) {
                var printContents = document.getElementById(divName).innerHTML;
                var originalContents = document.body.innerHTML;
                document.body.innerHTML = printContents;
                window.print();
                document.body.innerHTML = originalContents;
            }
        </script>
    </x-layout.admin>
</div>
