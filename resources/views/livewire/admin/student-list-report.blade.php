<div x-data="{
    printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
}">
<div class="flex justify-end space-x-3">


      <x-native-select wire:model="selected_campus">
        <option>Select Campus</option>
        @foreach ($campuses as $item)
            <option value={{$item->id}}>{{$item->name}}</option>
        @endforeach
      </x-native-select>
      <x-native-select wire:model="selected_program">
        <option>Select Program</option>
        @foreach ($program_selects as $item)
            <option value={{$item->id}}>{{$item->name}}</option>
        @endforeach
      </x-native-select>
      <x-button dark label="Generate" wire:click="generateReport" spinner="generateReport" />
      {{-- <x-button dark label="Download" icon="download" wire:click="downloadQualifiedStudents" spinner="downloadQualifiedStudents" /> --}}
      <x-button positive label="Print"  icon="printer" x-on:click="printDiv('printable')"/>

</div>
{{-- <div class="grid grid-cols-4 items-end space-x-3">
    <div class="col-span-3">
        <x-input wire:model.defer="student_name" class="mt-3 w-full" label="Search Name" icon="search" placeholder="Search" />
    </div>
    <div class="col-span-1 justify-center">
        <x-button dark label="Search Name" wire:click="generateReportByName" icon="search" spinner="generateReportByName" />
    </div>

    </div> --}}

<div class="grid grid-cols-8 mt-5 space-x-3">

</div>
    <div class="bg-white mt-2" id="printable" >
        <div class="flex flex-col items-center justify-center py-5">
            <p class="text-lg font-bold underline">List of Students</p>
            <p class="text-md font-bold">{{$campus_name}} - {{$program_name}}</p>
          </div>
          <div class="flex justify-end pr-10 py-3">
            <p class="text-lg font-bold">Total : {{$students != null ? $students->count() : 0}}</p>
          </div>
      <table class="min-w-full divide-y divide-gray-300">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="px-5 py-3.5 text-left text-sm font-semibold text-gray-900">Examinee Number</th>
                  <th scope="col" class="px-5 py-3.5 text-left text-sm font-semibold text-gray-900">FULL NAME</th>
                  <th scope="col" class="px-5 py-3.5 text-center text-sm font-semibold text-gray-900">CAMPUS</th>
                  <th scope="col" class="px-5 py-3.5 text-center text-sm font-semibold text-gray-900">PROGRAM</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 bg-white">
                @if($students)
                @foreach ($students as $item)
                  <tr>
                    <td class="whitespace-nowrap uppercase py-1.5 pl-4 px-5 text-sm font-medium text-gray-900 sm:pl-6">
                        {{ $item->examinee_number }}
                      </td>
                    <td class="whitespace-nowrap uppercase py-1.5 pl-4 px-5 text-sm font-medium text-gray-900 sm:pl-6">
                      {{ $item->user->personal_information->first_name }} {{ $item->user->personal_information->middle_name }} {{ $item->user->personal_information->last_name }}
                    </td>
                      <td class="whitespace-nowrap px-5 py-1.5 text-center text-sm text-gray-500">
                        {{ $item->user->program_choices->where('is_priority', 1)->first()?->program->campus->name }}</td>
                      <td class="whitespace-nowrap px-5 py-1.5 text-center text-sm text-gray-500">
                      {{ $item->user->program_choices->where('is_priority', 1)->first()?->program->name }}</td>
                  </tr>
                @endforeach
                @elseif(!$students || $students->count() == 0)
                <tr>
                    <td colspan="4" class="text-center py-5">No Data Available</td>
                </tr>
                @endif
              </tbody>
            </table>
        </div>
    </div>
    <script>
        window.addEventListener('afterprint', function() {
      // Reload the page
      location.reload();
    });
        </script>
  </div>

