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
}" class="py-10 antialiased font-poppins">
  <div class="flex hidden-print  justify-between max-w-5xl px-3 mx-auto sm:px-0">
    <h1>
      TPT PERMIT
    </h1>
    <div class="flex space-x-3">
      <livewire:applicant.update-photo />
      <x-button x-on:click="printDiv('printable')" icon="printer" positive>
        Print
      </x-button>
    </div>
  </div>
  <div id="printable" class="px-3 sm:px-0">
    <div class="flex justify-between max-w-5xl mx-auto mt-10 border-4 border-gray-800 ">
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
                {{ $permit->examinee_number }}
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

              <!-- {{-- <div class=" sm:p-0">
                <dl class="space-y-2">
                  <div class=" grid grid-cols-3 gap-4 py-0.5 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Full name</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 col-span-2">
                      {{ $personal_information->first_name }}
                      {{ $personal_information->middle_name }}
                      {{ $personal_information->last_name }}
                      {{ $personal_information->extension }}
                    </dd>
                  </div>
                  <div class=" grid grid-cols-3 gap-4 py-0.5 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Present Address</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 col-span-2">
                      {{ $personal_information->present_address }}
                    </dd>
                  </div>
                  <div class=" grid grid-cols-3 gap-4 py-0.5 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Permanent Address</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 col-span-2">
                      {{ $personal_information->permanent_address }}
                    </dd>
                  </div>
                  <div class=" grid grid-cols-3 gap-4 py-0.5 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                      Sex
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 col-span-2">
                      {{ $personal_information->sex }}
                    </dd>
                  </div>
                  <div class=" grid grid-cols-3 gap-4 py-0.5 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                      Date of Birth
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 col-span-2">
                      {{ $personal_information->date_of_birth }}
                    </dd>
                  </div>
                  <div class=" grid grid-cols-3 gap-4 py-0.5 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                      Contact Number
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 col-span-2">
                      {{ $personal_information->phone_number }}
                    </dd>
                  </div>
                  @if (auth()->user()->type_id == 1)
                    <div class=" grid grid-cols-3 gap-4 py-0.5 sm:px-6">
                      <dt class="text-sm font-medium text-gray-500">
                        School Graduated
                      </dt>
                      <dd class="mt-1 text-sm text-gray-900 sm:mt-0 col-span-2">
                        {{ $school_information->school_graduated }}
                      </dd>
                    </div>
                    <div class=" grid grid-cols-3 gap-4 py-0.5 sm:px-6">
                      <dt class="text-sm font-medium text-gray-500">
                        Senior High School Track
                      </dt>
                      <dd class="mt-1 text-sm text-gray-900 sm:mt-0 col-span-2">
                        {{ $school_information->track_and_strand_taken }}
                      </dd>
                    </div>
                  @else
                    <div class=" grid grid-cols-3 gap-4 py-0.5 sm:px-6">
                      <dt class="text-sm font-medium text-gray-500">
                        School Last Attended
                      </dt>
                      <dd class="mt-1 text-sm text-gray-900 sm:mt-0 col-span-2">
                        {{ $school_information->school_last_attended }}
                      </dd>
                    </div>
                  @endif
                  @foreach ($program_choices as $key => $program_choice)
                    <div class=" grid grid-cols-3 gap-4 py-0.5 sm:px-6">
                      <dt class="text-sm font-medium text-gray-500">
                        @if ($program_choice->is_priority == 1)
                          First Priority Program
                        @else
                          Second Priority Program
                        @endif
                      </dt>
                      <dd class="mt-1 text-sm text-gray-900 sm:mt-0 col-span-2">
                        <div class="flex space-x-1">
                          <span>{{ $program_choice->program->name }} </span>
                          <livewire:applicant.update-program-choice :priority="$program_choice->is_priority" />
                        </div>
                      </dd>
                    </div>
                  @endforeach
                </dl>
              </div> --}} -->

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
                  <h1 class="text-gray-600 text-sm mt-1">Date of Exam:
                    {{ \Carbon\Carbon::parse(auth()->user()->application->student_slot->slot->date_of_exam)->format('F d, Y') }}
                  </h1>
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
  </div>
  <x-notifications z-index="z-50" />
  <x-dialog z-index="z-50" blur="md" align="center" />


  @livewireScripts
</body>

</html>
