<x-layout.admin>
  <div x-data="{ action: 'none' }" x-on:view-info.window="action = 'view-info'"
    x-on:view-payment.window="action = 'view-payment'" x-on:none.window="action = 'none'" class="py-6">
    <div class="flex items-center px-4 mx-auto space-x-2 max-w-7xl sm:px-6 md:px-8">
      <nav class="flex" aria-label="Breadcrumb">
        <ol role="list" class="flex items-center space-x-4">
          <li>
            <div class="flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-600" viewBox="0 0 20 20"
                fill="currentColor">
                <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" />
              </svg>

              <a href="#" class="ml-4 text-xl font-medium text-gray-500 hover:text-gray-700">Examinations</a>
            </div>
          </li>
          <li>
            <div class="flex items-center">
              <svg class="flex-shrink-0 w-5 h-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 20" aria-hidden="true">
                <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
              </svg>
              <a href="#" class="ml-4 text-xl font-medium text-gray-500 hover:text-gray-700" aria-current="page">
                Applications
              </a>
            </div>
          </li>
        </ol>
      </nav>
      <nav class="flex" aria-label="Breadcrumb">
        <ol role="list" class="flex items-center space-x-4">
          <li x-cloak x-show="action=='create'">
            <div class="flex items-center">
              <svg class="flex-shrink-0 w-5 h-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 20" aria-hidden="true">
                <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
              </svg>
              <a href="#" class="ml-4 text-xl font-medium text-gray-500 hover:text-gray-700">Create</a>
            </div>
          </li>

          <li x-cloak x-show="action=='edit'">
            <div class="flex items-center">
              <svg class="flex-shrink-0 w-5 h-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 20" aria-hidden="true">
                <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
              </svg>
              <a href="#" class="ml-4 text-xl font-medium text-gray-500 hover:text-gray-700"
                aria-current="page">Edit</a>
            </div>
          </li>
        </ol>
      </nav>
    </div>
    <div class="px-4 mx-auto mt-10 max-w-7xl sm:px-6 md:px-8">
      <div x-show="action=='none'">
        <x-card shadow="shadow-none" padding="px-2 py-2 md:px-2 "
          class="border border-gray-300 flex justify-between items-center w-full rounded-lg">
          <div class="flex space-x-3">
            <x-button x-on:click="$dispatch('open-upload-result-modal')">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 text-green-600" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
              </svg>
              Upload Result
            </x-button>
            <livewire:admin.applications.generate-report.download-result :examination="$examination_id" />
            <livewire:admin.applications.generate-report.all-ready-to-exam :examination="$examination_id" />
          </div>
          <div>
            {{-- <livewire:admin.manage-slot :examination="$examination_id" /> --}}
            <x-button label="Manage Slots" dark
              href="{{ route('admin.manage-examination.applications.slots', ['id' => $examination_id]) }}" />
          </div>
        </x-card>
        <div class="mt-4">
          <livewire:admin.applications.table :examination="$examination_id" />
        </div>
      </div>
      <div x-cloak x-show="action=='view-info'">
        <livewire:admin.applications.view />
      </div>
      <div x-cloak x-show="action=='view-payment'">
        <livewire:admin.applications.view-payment />
      </div>
    </div>
    <livewire:admin.applications.upload-result :examination="$examination_id" />
</x-layout.admin>
