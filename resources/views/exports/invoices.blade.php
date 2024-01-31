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
    </tbody>
  </table>
