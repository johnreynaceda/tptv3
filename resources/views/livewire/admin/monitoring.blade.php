<div>
  <div class="">
    <div class="mt-8 flex flex-col">
      <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
          <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
            <div class="bg-white p-2 px-4 flex items-center justify-between">
              <x-input wire:model.debounce.500ms="search" placeholder="Search" />
              <div class="flex space-x-1">

                <x-native-select wire:model="time">
                  <option>Select Time</option>
                  <option value="AM 8:00 - 12:00">AM 8:00 - 12:00</option>
                  <option value="PM 1:00 - 5:00">PM 1:00 - 5:00</option>
                </x-native-select>
                <x-native-select wire:model="date">
                  <option>Select Date of Exam</option>
                  @foreach ($dates as $item)
                    <option value="{{ $item }}">{{ $item }}</option>
                  @endforeach
                </x-native-select>
                <x-native-select wire:model="test_center">
                  <option>Select Testing Center</option>
                  @foreach ($test_centers as $item)
                    <option value="{{ $item->id }}">{{ $item->campus->name }} -
                      {{ $item->slots->first()->building_name }}
                    </option>
                  @endforeach

                </x-native-select>


              </div>
            </div>

            <table class="min-w-full divide-y divide-gray-300">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">ROOM NUMBER</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">TOTAL SLOT
                    OCCUPIED</th>

                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 bg-white">

                @forelse ($student_slots as $application)
                  <tr>
                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                      {{ $application->first()->room_number ?? null }}
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                      {{ $application->count() ?? null }}</td>


                  </tr>
                @empty
                  <td colspan="2">
                    <div class="span px-2 py-2">No Slot Occupied</div>
                  </td>
                @endforelse

                <!-- More people... -->
              </tbody>
            </table>
          </div>
          <div class="mt-2">
            {{-- {{ $student_slots->links() }} --}}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
