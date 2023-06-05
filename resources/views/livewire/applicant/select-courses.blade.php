<div>
    <h1 class="font-semibold mb-3">SELECT YOUR PREFERRED COURSES</h1>
    <div class="py-3 space-y-4">
        <x-native-select label="First Priority" wire:model="first_priority">
            <option selected>-- Select --</option>
            @foreach ($courses as $item)
            <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
        </x-native-select>
        <x-native-select label="Second Priority" wire:model="second_priority">
            <option selected>-- Select --</option>
            @foreach ($courses as $item)
            <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
        </x-native-select>
        <x-native-select label="Third Priority" wire:model="third_priority">
            <option selected>-- Select --</option>
            @foreach ($courses as $item)
            <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
        </x-native-select>
    </div>
    <div class="flex justify-end">
        <x-button emerald label="Submit"
        x-on:confirm="{
            title: 'Are you Sure?',
            description: 'Save the information?',
            acceptlabel: 'Yes, save it',
            icon: 'info',
            method: 'save',
            params: 1
        }"
        />
      </div>

</div>
