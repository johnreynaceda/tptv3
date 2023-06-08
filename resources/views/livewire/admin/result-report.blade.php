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
    <x-button positive label="Print" x-on:click="printDiv('printable')"/>
    <x-native-select wire:model="remarks">
        <option>Select Remarks</option>
          <option value="1">Board Degree Programs</option>
          <option value="2">Non-Board Degree Programs</option>
      </x-native-select>
</div>

<div class="bg-white mt-5" id="printable" >
    <div class="flex flex-col items-center justify-center py-5">
    <p class="text-lg font-bold underline">List Of Students And Their Preferred Courses</p>
    <p class="text-md font-bold">{{Carbon\Carbon::parse(now())->format('F d, Y')}}</p>
    {{-- <p class="text-md font-bold">{{$time}}</p> --}}
    {{-- <p class="text-md font-bold">{{$campus_name}} - {{$building_name}}</p> --}}
    @switch($remarks)
        @case('1')
        <p class="text-2xl font-bold">Qualified for Board Degree Programs</p>
        @break
        @case('2')
        <p class="text-2xl font-bold">Qualified for Non-Board Degree Programs</p>
        @break
        @default
        <p class="text-2xl font-bold">All</p>
    @endswitch
  </div>

  <div class="px-4 sm:px-6 lg:px-8">
    <div class="mt-8 flow-root">
      <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
          <table class="min-w-full">
            <thead class="bg-white">
              <tr>
                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-3">Name</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Examinee Number</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Remarks</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Courses</th>
              </tr>
            </thead>
            <tbody class="bg-white">
                @foreach ($permits as $item)
              <tr class="border-t border-gray-200">

                <th colspan="1" scope="colgroup" class="bg-gray-50 py-2 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-3">{{$item->user->name}}</th>
                <th colspan="1" scope="colgroup" class="bg-gray-50 py-2 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-3">{{$item->examinee_number}}</th>
                @if ($item->result)
                @if ($item->result->total_standard_score >= 375 && $item->result->total_standard_score <= 524)
                <th colspan="1" scope="colgroup" class="bg-gray-50 py-2 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-3">Qualified for Non-Board Degree Programs</th>
                @elseif($item->result->total_standard_score >= 525 && $item->result->total_standard_score <= 800)
                <th colspan="1" scope="colgroup" class="bg-gray-50 py-2 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-3">Qualified for Board Degree Programs</th>
                @endif
                @endif
                <th colspan="1" scope="colgroup" class="bg-gray-50 py-2 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-3"></th>
              </tr>

              @forelse ($item->user->selected_courses as $selected_course)
              {{-- @dump($selected_course->program); --}}
              <tr class="border-t border-gray-300">
                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-3"></td>
                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"></td>
                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"></td>
                <td class="break-words px-3 py-4 text-sm text-gray-500">{{$selected_course->program->name}}</td>
              </tr>
              @empty
              <tr class="border-t border-gray-300">
                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-3"></td>
                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"></td>
                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"></td>
                <td class="break-words px-3 py-4 text-sm text-gray-500">Not Yet Selected</td>
              </tr>
              @endforelse

              {{-- <tr class="border-t border-gray-300">
                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-3"></td>
                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"></td>
                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"></td>
                <td class="break-words px-3 py-4 text-sm text-gray-500">Bachelor of science in information technology Major in computer systems</td>
              </tr>
              <tr class="border-t border-gray-300">
                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-3"></td>
                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"></td>
                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"></td>
                <td class="break-words px-3 py-4 text-sm text-gray-500">Bachelor of science in information technology Major in computer systems</td>
              </tr> --}}
              @endforeach
              <!-- More people... -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  </div>
</div>
