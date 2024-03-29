<div class="hidden-print">
  <span wire:click="$set('update_modal', true)"
    class="text-xs italic text-green-600 cursor-pointer hover:text-green-700">(Update)</span>


  <x-modal.card max-width="3xl" title="{{ $priority == 1 ? 'First Priority Choice' : 'Second Priority Choice' }}"
    wire:model.defer="update_modal">
    {{-- <form>
      @csrf
      <x-input wire:model.defer="photo" type="file" accept="image/*" label="Upload your photo" />
      <div id="loader">
        @if ($photo)
          <h1 class="text-green-600">
            File is ready to upload
          </h1>
        @endif
        <div wire:loading.flex wire:target="photo">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 animate-spin" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
          <span class="ml-3 text-gray-500">
            Please wait while preparing your photo...
          </span>
        </div>
      </div>
    </form> --}}
    <div>
      @foreach ($campuses as $campus)
        <h1>{{ $campus->name }}</h1>
        @foreach ($campus->programs as $key => $item)
          <x-radio id="{{ $key }}" value="{{ $item->id }}" label="{{ $item->name }}"
            wire:model.defer="choice_id" />
        @endforeach
      @endforeach
    </div>
    <x-slot name="footer">
      <div class="flex justify-end">
        <x-button positive wire:click="save">
          Save
        </x-button>
      </div>
    </x-slot>
  </x-modal.card>

</div>
