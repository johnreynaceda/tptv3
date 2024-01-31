<div>
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


      {{-- <x-native-select wire:model="selected_campus">
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
      </x-native-select> --}}
      <x-button dark label="Export Excel" icon="download" wire:click="generateReport" spinner="generateReport" />
      <x-button positive label="Print"  icon="printer" x-on:click="printDiv('printable')"/>

</div>


<div class="grid grid-cols-8 mt-5 space-x-3">

</div>
    <div class="bg-white mt-2" id="printable" >
        <div class="flex flex-col items-center justify-center py-5">
            {{-- <p class="text-lg font-bold underline">List of Students</p>
            <p class="text-md font-bold">{{$campus_name}} - {{$program_name}}</p> --}}
          </div>
          <div class="flex justify-end pr-10 py-3">
            {{-- <p class="text-lg font-bold">Total : {{$students != null ? $students->count() : 0}}</p> --}}
          </div>
      <table class="min-w-full divide-y divide-gray-300">
              <thead class="bg-white-50 ">
                <tr>
                  <th scope="col" class="px-5 py-3.5 text-left text-sm font-semibold text-gray-900 border-2 border-gray-800">No. </th>
                  <th scope="col" class="px-5 py-3.5 text-center text-sm font-semibold text-gray-900 border-2 border-gray-800">External Client Name</th>
                  <th scope="col" class="px-5 py-3.5 text-left text-sm font-semibold text-gray-900 border-2 border-gray-800">Service Availed</th>
                  <th scope="col" class="px-5 py-3.5 text-center text-sm font-semibold text-gray-900 border-2 border-gray-800">Client Contact Number (Phone Number)</th>
                  <th scope="col" class="px-5 py-3.5 text-center text-sm font-semibold text-gray-900 border-2 border-gray-800">Day of Service Completion / Registration</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 bg-white">
                @if($students)
                @foreach ($students as $item)
                  <tr>
                    <td class="whitespace-nowrap uppercase py-1.5 pl-4 px-5 text-sm font-medium text-gray-900 sm:pl-6 border-2 border-gray-800">
                        {{ $loop->iteration }}
                      </td>
                    <td class="whitespace-nowrap uppercase py-1.5 pl-4 px-5 text-sm font-medium text-gray-900 sm:pl-6 border-2 border-gray-800">
                        {{ ucfirst($item->user->personal_information->first_name.' '.$item->user->personal_information->middle_name.' '.$item->user->personal_information->last_name) }}
                      </td>
                    <td class="whitespace-nowrap uppercase py-1.5 pl-4 px-5 text-sm font-medium text-gray-900 sm:pl-6 border-2 border-gray-800">
                        SKSU TPT Online Registration
                    </td>
                      <td class="whitespace-nowrap px-5 py-1.5 text-center text-sm text-gray-500 border-2 border-gray-800">
                        {{ $item->user->personal_information->phone_number }}</td>
                      <td class="whitespace-nowrap px-5 py-1.5 text-center text-sm text-gray-500 border-2 border-gray-800">
                      {{ Carbon\Carbon::parse($item->created_at)->format('F d, Y h:i A') }}</td>
                  </tr>
                @endforeach
                @elseif(!$students || $students->count() == 0)
                <tr>
                    <td colspan="4" class="text-center py-5">No Data Available</td>
                </tr>
                @endif
              </tbody>
            </table>
            {{ $students->links() }}
        </div>
    </div>
    <script>
        window.addEventListener('afterprint', function() {
      // Reload the page
      location.reload();
    });
        </script>
  </div>

