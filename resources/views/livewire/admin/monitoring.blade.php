<div>
  <div class="">
    <div class="mt-8 flex flex-col">
      <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
          <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
            <div class="bg-white p-2 px-4 flex items-center justify-between">
              <x-input wire:model.debounce.500ms="search" placeholder="Search" />
              <div class="flex space-x-1">
                sdsd
              </div>
            </div>
            <table class="min-w-full divide-y divide-gray-300">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                    STUDENT NAME
                  </th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">DATE OF EXAM
                  </th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">TESTING CENTER
                  </th>

                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">ROOM NUMBER</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">SEAT NUMBER</th>

                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 bg-white">
                @foreach ($applications as $application)
                  <tr>
                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                      {{ $application->user->personal_information->first_name . ' ' . $application->user->personal_information->middle_name[0] . '. ' . $application->user->personal_information->last_name }}
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                      {{ $application->student_slot->slot->date_of_exam ?? 'null' }}</td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                      {{ $application->student_slot->slot->test_center->campus->name ?? null }}</td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                      Room {{ $application->student_slot->room_number ?? null }}</td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                      #{{ $application->student_slot->seat_number ?? null }}</td>

                  </tr>
                @endforeach

                <!-- More people... -->
              </tbody>
            </table>
          </div>
          <div class="mt-2">
            {{ $applications->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
