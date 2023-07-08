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
<div class="grid grid-cols-8 mt-5 space-x-3">
    {{-- <x-button dark label="1-1000" icon="download" wire:click="exportRange1To1000" spinner="exportRange1To1000" />
    <x-button dark label="1001-2000" icon="download" wire:click="exportRange1001To2000" spinner="exportRange1001To2000" />
    <x-button dark label="2001-3000" icon="download" wire:click="exportRange2001To3000" spinner="exportRange2001To3000" />
    <x-button dark label="3001-4000" icon="download" wire:click="exportRange3001To4000" spinner="exportRange3001To4000" />
    <x-button dark label="4001-5000" icon="download" wire:click="exportRange4001To5000" spinner="exportRange4001To5000" />
    <x-button dark label="5001-6000" icon="download" wire:click="exportRange5001To6000" spinner="exportRange5001To6000" />
    <x-button dark label="6001-7000" icon="download" wire:click="exportRange6001To7000" spinner="exportRange6001To7000" />
    <x-button dark label="7001-7500" icon="download" wire:click="exportRange7001To7500" spinner="exportRange7001To7500" /> --}}
</div>
    <div class="bg-white mt-2" id="printable" >
        <div class="flex flex-col items-center justify-center py-5">
            <p class="text-lg font-bold underline">List of Qualified Students</p>
            <p class="text-md font-bold">{{$campus_name}} - {{$program_name}}</p>
          </div>

      <table class="min-w-full divide-y divide-gray-300">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="px-5 py-3.5 text-left text-sm font-semibold text-gray-900">Examinee Number</th>
                  <th scope="col" class="px-5 py-3.5 text-left text-sm font-semibold text-gray-900">FULL NAME</th>
                  <th scope="col" class="px-5 py-3.5 text-center text-sm font-semibold text-gray-900">SCORE</th>
                  <th scope="col" class="px-5 py-3.5 text-center text-sm font-semibold text-gray-900">CAMPUS</th>
                  <th scope="col" class="px-5 py-3.5 text-center text-sm font-semibold text-gray-900">PROGRAM</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 bg-white">
                @if($rankings)
                @foreach ($rankings as $item)
                  <tr>
                    <td class="whitespace-nowrap uppercase py-1.5 pl-4 px-5 text-sm font-medium text-gray-900 sm:pl-6">
                        {{ $item->examinee_number }}
                      </td>
                    <td class="whitespace-nowrap uppercase py-1.5 pl-4 px-5 text-sm font-medium text-gray-900 sm:pl-6">
                      {{ $item->user->name }}
                    </td>
                      <td class="whitespace-nowrap px-5 py-1.5 text-center text-sm text-gray-500">
                      {{ $item->result?->total_standard_score }}</td>
                      <td class="whitespace-nowrap px-5 py-1.5 text-center text-sm text-gray-500">
                        {{ $item->user->selected_courses->where('priority_level', 1)->first()?->program->campus->name }}</td>
                      <td class="whitespace-nowrap px-5 py-1.5 text-center text-sm text-gray-500">
                      {{ $item->user->selected_courses->where('priority_level', 1)->first()?->program->name }}</td>
                  </tr>
                @endforeach
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

