<div>
    <div class="border border-gray-300 rounded-md">
        @if ($user_id !== '')
            <x-card title="Payment Information" shadow="shadow-none">
                <x-slot name="action">
                    <x-button icon="arrow-left" x-on:click="$dispatch('none')">
                        Return
                    </x-button>
                </x-slot>
                @if (!$payment)
                    <div class="text-red-600">
                        Payment not found
                    </div>
                @else
                <div class="space-y-3">
                    <h1>
                        Applicant : <span class="font-semibold">
                            {{ optional(optional($payment)?->user)?->personal_information?->first_name ?? 'N/A' }}
                            {{ optional(optional($payment)?->user)?->personal_information?->middle_name ?? '' }}
                            {{ optional(optional($payment)?->user)?->personal_information?->last_name ?? '' }}
                        </span>
                    </h1>
                    <h1>
                        Reference Number : <span class="font-semibold">{{ $payment?->reference_number ?? '' }}</span>
                    </h1>
                    <h1>
                        Paid At : <span class="font-semibold">{{ $payment?->paid_at ?? '' }}</span>
                    </h1>
                    <hr>
                    <div class="space-y-3">
                        <h1>
                            Proof of Payment
                        </h1>
                        <ul>
                            @forelse (optional($payment)?->proofs ?? [] as $key => $proof)
                                @if (optional($proof)->path)
                                    <li class="space-y-3">
                                        <a href="{{ Storage::url($proof->path) }}" target="_blank" class="text-blue-600"
                                            title="View the proof document">
                                            <img src="{{ Storage::url($proof->path) }}"
                                                alt="Proof document for {{ $proof->name ?? 'item' }}"
                                                class="max-w-xs h-auto rounded-md shadow-md object-cover" />
                                        </a>
                                    </li>
                                @endif
                            @empty
                                <li class="text-gray-500">No proof of payment uploaded</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
                @endif
                @if (optional($payment)?->user?->step == '4')
                    <x-slot name="footer">
                        <div class="flex justify-end space-x-3">

                            <x-button negative wire:click="reject" spinner="reject" wire:loading.attr="disabled" wire:target="reject">
                                Deny Payment
                            </x-button>
                            <x-button positive wire:click="approve" spinner="approve" wire:loading.attr="disabled" wire:target="approve">
                                Approve Payment
                            </x-button>


                        </div>
                    </x-slot>
                @endif
            </x-card>
        @endif
    </div>

    <x-modal.card align="center" title="Add Remarks" blur wire:model.defer="reject_modal">
        <div class="">
            <x-textarea wire:model="remarks" class="w-full focus:outline-none" label="Reason" placeholder="" />
        </div>

        <x-slot name="footer">
            <div class="flex justify-between gap-x-4">
                <div></div>
                <div class="flex">
                    <x-button flat label="Cancel" x-on:click="close" />
                    <x-button primary label="Save" wire:click="rejectConfirm" />
                </div>
            </div>
        </x-slot>
    </x-modal.card>
</div>
