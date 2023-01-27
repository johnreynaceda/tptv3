<div>
    <div class="border border-gray-300 rounded-md">
        <x-card shadow="shadow-none"
            title="Previous School Information">
            <form>
                @csrf
                <div class="space-y-3">

                    @if ($applicant_is_freshmen)
                        <x-input wire:model.defer="school_graduated"
                            label="School Graduated" />
                        <x-input wire:model.defer="year_graduated"
                            label="Year Graduated" />
                        <x-input wire:model.defer="track_and_strand_taken"
                            label="Track And Strand Taken" />
                        <x-input wire:model.defer="honor_or_awards_received"
                            corner-hint="Leave it blank if not applicable"
                            label="Honor / Award Received" />
                    @endif
                    @if ($applicant_is_transferee)
                        <x-input wire:model.defer="school_last_attended"
                            label="School Last Attended" />
                        <x-input wire:model.defer="year_last_attended"
                            label="Year Last Attended" />
                    @endif
                    <x-input wire:model.defer="previous_school_address"
                        label="Previous School Address" />
                </div>
            </form>
            <x-slot name="footer">
                <div class="flex justify-end">
                    @if (auth()->user()->step == '2')
                        @if (!$school_information)
                            <x-button wire:click="save"
                                positive>
                                Save
                            </x-button>
                        @else
                            <x-button blue
                                wire:click="update">
                                Update
                            </x-button>
                        @endif
                    @endif
                </div>
            </x-slot>
        </x-card>
    </div>
</div>
