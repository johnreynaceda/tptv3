<div>
    <div class="border border-gray-300 rounded-lg">
        <x-card shadow="shadow-none"
            title="Update Examination"
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
                    <x-input label="Title"
                        wire:model.defer="title" />
                    <x-native-select label="School Year"
                        wire:model.defer="school_year">
                        <option value=""></option>
                        @foreach ($shool_years as $shool_year)
                            <option value="{{ $shool_year }}">{{ $shool_year }}</option>
                        @endforeach
                    </x-native-select>
                    <x-input label="Date Start "
                        type="date"
                        wire:model.defer="date_start" />
                    <x-input label="Date End "
                        wire:model.defer="date_end"
                        type="date" />
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
