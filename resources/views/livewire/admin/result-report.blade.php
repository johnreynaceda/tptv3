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
    {{-- <x-native-select wire:ignore wire:model="remarks">
        <option>Select Remarks</option>
          <option value="1">Board Degree Programs</option>
          <option value="2">Non-Board Degree Programs</option>
      </x-native-select> --}}
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
</div>

<div class="bg-white mt-5" id="printable" >
    {{-- <div class="flex flex-col items-center justify-center py-5">
    <p class="text-lg font-bold underline">Preferred Courses of Students</p>
    <p class="text-md font-bold">{{Carbon\Carbon::parse(now())->format('F d, Y')}}</p>
  </div> --}}
  <div class="px-4 sm:px-6 lg:px-8">
    <div class="mt-8 flow-root">
      <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle">
          <table class="min-w-full divide-y divide-gray-300">
            <thead>
              <tr>
                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 lg:pl-8">Campus</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Program</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">1st Priority</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">2nd Priority</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">3rd Priority</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @foreach ($programs as $item)
              <tr>
                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8">{{$item->campus->name}}</td>
                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$item->name}}</td>
                <td class="whitespace-wrap px-3 py-4 text-sm text-gray-500">{{$item->selected_courses->where('priority_level', 1)->count()}}</td>
                <td class="whitespace-wrap px-3 py-4 text-sm text-gray-500">{{$item->selected_courses->where('priority_level', 2)->count()}}</td>
                <td class="whitespace-wrap px-3 py-4 text-sm text-gray-500">{{$item->selected_courses->where('priority_level', 3)->count()}}</td>
              </tr>
               @endforeach
              <!-- More people... -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <script>
    window.addEventListener('afterprint', function() {
  // Reload the page
  location.reload();
});
    </script>
</div>
