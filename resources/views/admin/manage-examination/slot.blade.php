<x-layout.admin>
  <div class="py-6">
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
          <li>
            <div class="flex items-center">
              <svg class="flex-shrink-0 w-5 h-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 20" aria-hidden="true">
                <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
              </svg>
              <a href="#" class="ml-4 text-xl font-medium text-gray-500 hover:text-gray-700" aria-current="page">
                Manage Slots
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
      <livewire:admin.manage-slot :examination="$examination_id" />
    </div>
  </div>
</x-layout.admin>
