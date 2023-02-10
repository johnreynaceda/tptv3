<div>
<div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
<div class="bg-white p-2 px-4 space-x-4">
<x-input wire:model.debounce.500ms="search" placeholder="Search Name or Email" />
</div>
</div>
@if($user != null && $info != null)
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
        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">Rejected</dd>
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
@endif
</div>
