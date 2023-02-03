<div>
  <div class="overflow-hidden bg-white shadow sm:rounded-lg">
    <div class="px-4 py-5 sm:px-6 bg-green-600">
      <h3 class="text-lg  leading-6 text-white">Selection of Test Center</h3>
      <p class="mt-1 max-w-2xl text-sm text-gray-500"></p>
    </div>
    <div class="border-t border-gray-200 px-4 py-5 ">
      <div class="flex flex-col space-y-3">
        <x-native-select label="Time" wire:model="time">
          <option selected>Select Day Time</option>
          <option value="AM 8:00 - 12:00">AM 8:00 - 12:00</option>
          <option value="PM 1:00 - 5:00">PM 1:00 - 5:00</option>
        </x-native-select>
        @php
          $dates = \App\Models\Slot::whereHas('test_center', function ($query) {
              $query->where('examination_id', auth()->user()->application->examination_id);
          })->where('is_active', 1)
              ->pluck('date_of_exam')
              ->unique()
              ->toArray();
        @endphp
        <x-native-select label="Date of Exam" wire:model="date">
          <option selected>Select Date of Exam</option>
          @foreach ($dates as $date)
            <option value="{{ $date }}">{{ \Carbon\Carbon::parse($date)->format('F d, Y') }}</option>
          @endforeach

        </x-native-select>
        <div>
          <x-native-select label="Test Center" wire:model="center_id">
            <option selected>Select Test Center</option>
            @foreach ($testing_centers as $center)
              <option value="{{ $center->id }}">
                {{ $center->test_center->campus->name . ' - ' . $center->building_name }}
              </option>
            @endforeach
          </x-native-select>
        </div>
      </div>
    </div>
  </div>
  <div class="flex justify-end space-x-2 mt-3">
    @if ($room_number != null && $seat_number != null)
      <x-button positive label="Save Slot" wire:click="saveSlot" />
    @endif
  </div>

</div>
