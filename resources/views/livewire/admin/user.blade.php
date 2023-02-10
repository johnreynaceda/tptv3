<div>
<div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
<div class="bg-white p-2 px-4 space-x-4">
<x-input wire:model.debounce.500ms="search" placeholder="Search Name or Email" />
</div>
</div>
<div class="mt-5 overflow-hidden bg-white shadow sm:rounded-md">
  <ul role="list" class="divide-y divide-gray-200">
    @if($informations != null)
    @forelse($informations as $info)
    <li>
      <a wire:click="openStudentModal({{$info->user->id}})" class="block hover:bg-gray-50">
        <div class="flex items-center px-4 py-4 sm:px-6">
          <div class="flex min-w-0 flex-1 items-center">
            <div class="flex-shrink-0">
              <img class="h-16 w-16 rounded-full" src="{{Storage::url($info['photo'])}}" alt="">
            </div>
            <div class="min-w-0 flex-1 px-4 md:grid md:grid-cols-2 md:gap-4">
              <div>
                <p class="truncate text-sm font-medium text-indigo-600">{{$info->user->name}}</p>
                <p class="mt-2 flex items-center text-sm text-gray-500">
                  <!-- Heroicon name: mini/envelope -->
                  <svg class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path d="M3 4a2 2 0 00-2 2v1.161l8.441 4.221a1.25 1.25 0 001.118 0L19 7.162V6a2 2 0 00-2-2H3z" />
                    <path d="M19 8.839l-7.77 3.885a2.75 2.75 0 01-2.46 0L1 8.839V14a2 2 0 002 2h14a2 2 0 002-2V8.839z" />
                  </svg>
                  <span class="truncate">{{$info->user->email}}</span>
                </p>
              </div>
              <div class="hidden md:block">
                <div>
                  <p class="text-sm text-gray-900">
                    Applied on
                    <time datetime="2020-01-07">January 7, 2020</time>
                  </p>
                  <p class="mt-2 flex items-center text-sm text-gray-500">
                    <!-- Heroicon name: mini/check-circle -->
                    <svg class="mr-1.5 h-5 w-5 flex-shrink-0 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                    </svg>
                    Completed phone screening
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div>
            <!-- Heroicon name: mini/chevron-right -->
            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
            </svg>
          </div>
        </div>
      </a>
    </li>
    @empty
    <div class="flex justify-center items-center">
    <span class="text-xl text-gray-500 font-extrabold mt-10">NO RESULT</span>
    </div>
    @endforelse
    @else
    <div class="flex justify-center items-center">
    <span class="text-xl text-gray-500 font-extrabold p-2">NO RESULT</span>
    </div>
    @endif
  </ul>
</div>

<x-modal.card max-width="4xl" title="Student Information" blur wire:model.defer="studentModal">
@if($user != null && $info != null)
<div class="-ml-4 -mt-4 flex flex-wrap items-center justify-between sm:flex-nowrap">
    <div class="ml-4 mt-4">
      <div class="flex items-center">
        <div class="flex-shrink-0">
          <img class="h-44 rounded-lg flex-shrink-0" src="{{Storage::url($user->personal_information->photo)}}" alt="">
          
        </div>
        <div class="ml-4">
          <h3 class="text-lg font-medium leading-6 text-gray-900">{{$user->name}}</h3>
          <p class="text-sm text-gray-500">
            <a href="#">{{$user->email}}</a>
          </p>
        </div>
      </div>
    </div>
    <div class="ml-4 mt-4 flex flex-shrink-0">
    <x-button negative label="Reset Password" wire:click="confirmResetPassword"/>
    </div>
    
  </div>
  <div class="mt-5 border-t border-gray-200">
    <dl class="sm:divide-y sm:divide-gray-200">
      <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
        <dt class="text-sm font-medium text-gray-500">Present Address</dt>
        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{$info->present_address}}</dd>
      </div>
      <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
        <dt class="text-sm font-medium text-gray-500">Permanent Address</dt>
        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{$info->permanent_address}}</dd>
      </div>
      <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
        <dt class="text-sm font-medium text-gray-500">Contact Number</dt>
        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{$info->phone_number}}</dd>
      </div>
      <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
        <dt class="text-sm font-medium text-gray-500">Gender</dt>
        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{$info->sex}}</dd>
      </div>
      <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
        <dt class="text-sm font-medium text-gray-500">Status</dt>
        @if($user['step'] == 1)
        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0"></dd>
        @elseif($user['step'] == 2)
        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">Filling Up Application</dd>
        @elseif($user['step'] == 3)
        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">For Payment</dd>
        @elseif($user['step'] == 4)
        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">Payment Validation</dd>
        @elseif($user['step'] == 5)
        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">Paid</dd>
        @elseif($user['step'] == 100)
        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">Rejected </dd>
        @endif
      </div>
    </dl>
  </div>
  @endif
</x-modal.card>

{{-- @if($user != null && $info != null)
<div>
<div class="rounded-md mt-5 border-b border-gray-200 bg-white px-4 py-4 sm:px-6">
  <div class="-ml-4 -mt-4 flex flex-wrap items-center justify-between sm:flex-nowrap">
    <div class="ml-4 mt-4">
      <div class="flex items-center">
        <div class="flex-shrink-0">
          <img class="h-44 rounded-lg flex-shrink-0" src="{{Storage::url($info['photo'])}}" alt="">
        </div>
        <div class="ml-4">
          <h3 class="text-lg font-medium leading-6 text-gray-900">{{$user['name']}}</h3>
          <p class="text-sm text-gray-500">
            <a href="#">{{$user['email']}}</a>
          </p>
        </div>
      </div>
    </div>
    <div class="ml-4 mt-4 flex flex-shrink-0">
    <x-button negative label="Reset Password" wire:click="confirmResetPassword"/>

    </div>
    
  </div>

</div>

<div class="rounded-md mt-2 border-b border-gray-200 bg-white px-4 py-4 sm:px-6">
<div>
  <div>
    <h3 class="text-lg font-medium leading-6 text-gray-900">Student Information</h3>
    <p class="mt-1 max-w-2xl text-sm text-gray-500">Personal details.</p>
  </div>
  <div class="mt-5 border-t border-gray-200">
    <dl class="sm:divide-y sm:divide-gray-200">
      <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
        <dt class="text-sm font-medium text-gray-500">Present Address</dt>
        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{$info['present_address']}}</dd>
      </div>
      <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
        <dt class="text-sm font-medium text-gray-500">Permanent Address</dt>
        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{$info['permanent_address']}}</dd>
      </div>
      <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
        <dt class="text-sm font-medium text-gray-500">Contact Number</dt>
        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{$info['phone_number']}}</dd>
      </div>
      <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
        <dt class="text-sm font-medium text-gray-500">Gender</dt>
        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{$info['sex']}}</dd>
      </div>
      <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
        <dt class="text-sm font-medium text-gray-500">Status</dt>
        @if($user['step'] == 1)
        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0"></dd>
        @elseif($user['step'] == 2)
        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">Filling Up Application</dd>
        @elseif($user['step'] == 3)
        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">For Payment</dd>
        @elseif($user['step'] == 4)
        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">Payment Validation</dd>
        @elseif($user['step'] == 5)
        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">Paid</dd>
        @elseif($user['step'] == 100)
        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">Rejected </dd>
        @endif
      </div>
    </dl>
  </div>
</div>
</div>
</div>
@else
<div class="flex justify-center items-center">
<span class="text-xl text-gray-500 font-extrabold mt-10">NO RESULT</span>
</div>
@endif --}}
</div>
