<div>

  <div class="">

    <div class="flex flex-col">
      <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
          <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
            <div class="py-2 flex justify-between items-center bg-white px-4">
              <div>
                {{-- <x-input wire:model.debounce.500ms="search" placeholder="Search" /> --}}
              </div>
              <div>
                <x-button label="Add New" icon="plus" wire:click="openAddModal" dark />
              </div>
            </div>
            {{-- <table class="min-w-full divide-y divide-gray-300">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col"
                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold uppercase text-gray-900 sm:pl-6">
                    Testing Center
                  </th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold uppercase text-gray-900">
                    Exam Date
                  </th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold uppercase text-gray-900">
                    Building Name
                  </th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold uppercase text-gray-900">Slots
                  </th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold uppercase text-gray-900">Number
                    of Rooms
                  </th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold uppercase text-gray-900">Status
                  </th>
                  <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                    <span class="sr-only">Edit</span>
                  </th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 bg-white">
                @foreach ($centers as $center)
                  <tr>
                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                      {{ $center->campus->name }}
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                      {{ \Carbon\Carbon::parse($center->slots->first()->date_of_exam)->format('M d, Y') }}</td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                      {{ $center->slots->first()->building_name }}</td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $center->slots->first()->slots }}
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                      {{ $center->slots->first()->number_of_rooms }}</td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                      @if($center->slots->first()->is_active)
                      <x-button negative label="Deactivate" wire:click="deactivateSched({{$center->slots->first()->id}})"/>

                      @else
                      <x-button positive label="Activate" wire:click="activateSched({{$center->slots->first()->id}})"/>

                      @endif
                      </td> 
                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                      <div class="flex justify-end items-center">
                        <x-button sm flat icon="pencil-alt" wire:click="openUpdateModal({{$center->slots->first()->id}})" positive label="Edit" />
                        <x-button sm flat icon="trash" negative label="Delete" />
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table> --}}

            <div>
              @foreach ($test_centers_by_campus as $campus_id => $centers)
                  <div class="mb-8">
                      <!-- Campus Name -->
                      <h2 class="py-3.5 text-left text-sm font-semibold uppercase text-white bg-gray-600 px-2 rounded-t-lg">
                          {{ $centers->first()->campus->name }}
                      </h2>
          
                      <!-- Table with Aligned Headers -->
                      <table class="divide-y divide-gray-200 bg-white w-full rounded-lg">
                          <thead class="bg-gray-100">
                              <tr>
                                  <th class="py-2 px-3 text-left text-sm uppercase text-gray-900 font-normal">Exam Date</th>
                                  <th class="py-2 px-3 text-left text-sm uppercase text-gray-900 font-normal">Building Name</th>
                                  <th class="py-2 px-3 text-left text-sm uppercase text-gray-900 font-normal">Slots</th>
                                  <th class="py-2 px-3 text-left text-sm uppercase text-gray-900 font-normal">Number of Rooms</th>
                                  <th class="py-2 px-3 text-left text-sm uppercase text-gray-900 font-normal">Status</th>
                                  <th class="py-2 px-3 text-left text-sm uppercase text-gray-900 font-normal">Actions</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach ($centers as $center)
                                  @foreach ($center->slots as $index => $slot)
                                      <tr class="{{ $index % 2 === 0 ? 'bg-gray-50' : 'bg-gray-100' }}">
                                          <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-800">
                                              {{ \Carbon\Carbon::parse($slot->date_of_exam)->format('F d, Y') }}
                                          </td>
                                          <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-800">
                                              {{ $slot->building_name }}
                                          </td>
                                          <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-800">
                                              {{ $slot->slots }}
                                          </td>
                                          <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-800">
                                              {{ $slot->number_of_rooms }}
                                          </td>
                                          <!-- Status Column -->
                                          <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                              @if ($slot->is_active)
                                                  <x-button negative label="Deactivate" wire:click="deactivateSched({{ $slot->id }})" />
                                              @else
                                                  <x-button positive label="Activate" wire:click="activateSched({{ $slot->id }})" />
                                              @endif
                                          </td>
                                          <!-- Actions Column -->
                                          <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                              <div class="flex justify-end items-center">
                                                  <x-button sm flat icon="pencil-alt" wire:click="openUpdateModal({{ $slot->id }})" positive label="Edit" />
                                                  {{-- <x-button sm flat icon="trash" wire:click="deleteSlot({{ $slot->id }})" negative label="Delete" /> --}}
                                              </div>
                                          </td>
                                      </tr>
                                  @endforeach
                              @endforeach
                          </tbody>
                      </table>
                  </div>
              @endforeach
          </div>
          
          
          
          
          </div>
        </div>
      </div>
    </div>
  </div>


  <x-modal wire:model.defer="manage_modal">
    <x-card title="MANAGE SLOTS">
      <div class="grid grid-cols-2 gap-4">
        <div class="col-span-2">
          <x-native-select label="Testing Center" wire:model="test_center">
            <option>Select Testing Center</option>
            @foreach ($campuses as $campus)
              <option value="{{ $campus->id }}">{{ $campus->name }}</option>
            @endforeach
          </x-native-select>
        </div>
        <div class="col-span-2">
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Date of Exam</label>
            <div class="mt-1">
              <input type="date" wire:model="date"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                placeholder="you@example.com">
            </div>
          </div>
        </div>
        <div class="col-span-2">
          <x-input label="Building Name" wire:model="building_name" />
        </div>
        <x-input label="Number of Slots" wire:model="slots" />
        <x-input label="Number of Rooms" wire:model="rooms" />
      </div>

      <x-slot name="footer">
        <div class="flex justify-end gap-x-4">
          <x-button flat label="Close" x-on:click="close" />
          @if($is_edit == false)
          <x-button positive wire:click="addSlot" label="Save" />
          @else
          <x-button positive wire:click="editSlot" label="Update" />
          @endif
        </div>
      </x-slot>
    </x-card>
  </x-modal>
</div>
