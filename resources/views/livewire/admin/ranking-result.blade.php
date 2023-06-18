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
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Course / Program</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Name</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Ranking (Highest to Lowest)</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Qualitative Interpretation </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @foreach ($rankings as $item)
              <tr>
                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8">{{$item->user->selected_courses->where('priority_level', 1)->first()->program->campus->name}}</td>
                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$item->user->selected_courses->where('priority_level', 1)->first()->program->name}}</td>
                <td class="whitespace-wrap px-3 py-4 text-sm text-gray-500">{{$item->user->name}}</td>
                <td class="whitespace-wrap px-3 py-4 text-sm text-center text-gray-500">{{$item->result->total_standard_score}}</td>
                @if ($item->result->total_standard_score >= 680 && $item->result->total_standard_score <= 800)
                <td class="whitespace-wrap px-3 py-4 text-sm text-gray-500">Outstanding</td>
                @elseif($item->result->total_standard_score >= 580 && $item->result->total_standard_score <= 679)
                <td class="whitespace-wrap px-3 py-4 text-sm text-gray-500">Above Average</td>
                @elseif($item->result->total_standard_score >= 525 && $item->result->total_standard_score <= 579)
                <td class="whitespace-wrap px-3 py-4 text-sm text-gray-500">High Average</td>
                @elseif($item->result->total_standard_score >= 475 && $item->result->total_standard_score <= 524)
                <td class="whitespace-wrap px-3 py-4 text-sm text-gray-500">Middle Average</td>
                @elseif($item->result->total_standard_score >= 375 && $item->result->total_standard_score <= 474)
                <td class="whitespace-wrap px-3 py-4 text-sm text-gray-500">Low Average</td>
                @elseif($item->result->total_standard_score >= 325 && $item->result->total_standard_score <= 374)
                <td class="whitespace-wrap px-3 py-4 text-sm text-gray-500">Below Average</td>
                @elseif($item->result->total_standard_score >= 200 && $item->result->total_standard_score <= 324)
                <td class="whitespace-wrap px-3 py-4 text-sm text-gray-500">Low</td>
                @endif

              </tr>
               @endforeach
              <!-- More people... -->
            </tbody>
          </table>
          {{ $rankings->links() }}
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
