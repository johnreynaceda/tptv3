<div>
  <div class="">
    <div class="mt-8 flex flex-col">
      <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
          <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
            <div class="bg-white p-2 px-4 flex items-center justify-between">
              <x-input wire:model.debounce.500ms="search" placeholder="Search" />
              <x-button class="hidden" positive label="View All" wire:click="$set('student_slot_modal', true)" />

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

            <x-modal.card title="Student Slots" fullscreen blur wire:model.defer="student_slot_modal">
            <div class="flex ">
            <!-- <table class="min-w-full divide-y divide-gray-300">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Name</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Date of Exam</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Test Center</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Building Name</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Time</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Room Number</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Seat Number</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 bg-white">

                @forelse ($student_slot_details as $detail)
                  <tr>
                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                      {{ $detail->users->name }}
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                      {{ $detail->slot->date_of_exam }}</td>
                      <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                      {{ $detail->slot->test_center->campus->name }}</td>
                      <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                      {{ $detail->slot->building_name }}</td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                      {{ $detail->time }}</td>
                      <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                      {{ $detail->room_number }}</td>
                      <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                      {{ $detail->seat_number }}</td>  
                  </tr>
                @empty
                  <td colspan="2">
                    <div class="span px-2 py-2">No Slot Occupied</div>
                  </td>
                @endforelse

              </tbody>
            </table> -->
            </div>
        
            <x-slot name="footer">
                <div class="flex justify-between gap-x-4">
                    <div></div>
                    <div class="flex">
                        <x-button dark label="Close" wire:click="$set('student_slot_modal', false)" />
                    </div>
                </div>
            </x-slot>
          </x-modal.card>

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
