<div>
    <div class="border border-gray-300 rounded-lg">
        <x-card shadow="shadow-none"
            title="Update Program"
            rounded="rounded-lg">
            <x-slot name="action">
                <x-button sm
                    icon="arrow-left"
                    x-on:click="$dispatch('none')"
                    label="Return" />
            </x-slot>
            <form>
                @csrf
                <div class="gap-3 sm:grid sm:grid-cols-2">
                    <x-input label="Name"
                        wire:model.defer="name" />
                    <x-input label="Abbreviation"
                        wire:model.defer="abbreviation" />
                    <div class="col-span-2">
                        <x-native-select label="Campus"
                            wire:model.defer="campus_id">
                            <option value=""></option>
                            @foreach ($campuses as $campus)
                                <option value="{{ $campus->id }}">{{ $campus->name }}</option>
                            @endforeach
                        </x-native-select>
                    </div>
                </div>
            </form>
            <x-slot name="footer">
                <div class="flex justify-end">
                    <x-button icon="save"
                        wire:click.prevent="update"
                        spinner="update"
                        positive>
                        Save Update
                    </x-button>
                </div>
            </x-slot>
        </x-card>
    </div>
</div>
