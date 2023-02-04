<div x-data="{
    printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
}">
<div class="flex space-x-1">
              
<x-native-select cwire:model="exam">
  <option>Select Exam</option>
  @foreach ($examinations as $exam)
    <option value="{{ $exam->id }}">{{ $exam->title }}</option>
  @endforeach
</x-native-select>
<x-native-select wire:model="date">
  <option>Select Date of Exam</option>
  @foreach ($dates as $item)
    <option value="{{ $item }}">{{ $item }}</option>
  @endforeach
</x-native-select>
<x-native-select wire:model="time">
  <option>Select Time</option>
  <option value="AM 8:00 - 12:00">AM 8:00 - 12:00</option>
  <option value="PM 1:00 - 5:00">PM 1:00 - 5:00</option>
</x-native-select>  
<x-native-select wire:model="test_center">
  <option>Select Testing Center</option>
  @foreach ($test_centers as $item)
     <option value="{{ $item->id }}">{{ $item->campus->name }} -
        {{ $item->slots->first()->building_name }}
     </option>
  @endforeach
</x-native-select>
<x-native-select wire:model="rooms">
  <option value="">Select Room Number</option>
  @php
    $roomNumbers = [];
  @endphp
  @foreach ($test_centers as $test_center)
    @if ($test_center->id == $this->test_center)
      @foreach ($test_center->slots as $slot)
        @foreach ($slot->student_slots as $studentSlot)
          @if (!in_array($studentSlot->room_number, $roomNumbers))
            @php
              $roomNumbers[] = $studentSlot->room_number;
            @endphp
            <option value="{{ $studentSlot->room_number }}">{{ $studentSlot->room_number }}</option>
          @endif
        @endforeach
      @endforeach
    @endif
  @endforeach
</x-native-select>
</div>
<x-button class="m-2" positive label="Print" x-on:click="printDiv('printable')"/>
@if ($exam && $date && $time && $test_center)

    <div class="bg-white mt-5" id="printable" >
      <div class="flex flex-col items-center justify-center py-5">
      <p class="text-xl font-bold underline">{{$exam->title}}</p>
      <p class="text-lg font-bold">{{Carbon\Carbon::parse($date)->format('F d, Y')}}</p>
      <p class="text-lg font-bold">{{$time}}</p>
      <p class="text-lg font-bold">{{$campus_name}} - {{$building_name}}</p>
      @if($rooms == null)
      <p class="text-2xl font-bold">All Rooms</p>
      @else
      <p class="text-2xl font-bold">ROOM # {{$rooms}}</p>

      @endif

    </div>
      

      <table class="min-w-full divide-y divide-gray-300">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="px-5 py-3.5 text-left text-sm font-semibold text-gray-900">Full Name</th>
                  <th scope="col" class="px-5 py-3.5 text-center text-sm font-semibold text-gray-900">Seat Number</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 bg-white">

                @forelse ($student_slot_details as $detail)
                  <tr>
                    <td class="whitespace-nowrap py-1.5 pl-4 px-5 text-sm font-medium text-gray-900 sm:pl-6">
                      {{ $detail->users->name }}
                    </td>
                      <td class="whitespace-nowrap px-5 py-1.5 text-center text-sm text-gray-500">
                      {{ $detail->seat_number }}</td>  
                  </tr>
                @empty
                  <td colspan="2">
                    <div class="span px-2 py-2">No Slot Occupied</div>
                  </td>
                @endforelse

              </tbody>
            </table>
    </div>
  @endif
  </div>

