<div>
    <div class="border border-gray-300 rounded-md">
        @if ($user_id != '')
            <x-card title="Payment Information"
                shadow="shadow-none">
                <x-slot name="action">
                    <x-button icon="arrow-left"
                        x-on:click="$dispatch('none')">
                        Return
                    </x-button>
                </x-slot>
                <div class="space-y-3">
                    <h1>
                        Applicant : <span class="font-semibold">{{ $payment->user->personal_information->first_name }}
                            {{ $payment->user->personal_information->middle_name }}
                            {{ $payment->user->personal_information->last_name }}</span>
                    </h1>
                    <h1>
                        Reference Number : <span class="font-semibold">{{ $payment->reference_number }}</span>
                    </h1>
                    <h1>
                        Paid At : <span class="font-semibold">{{ $payment->paid_at }}</span>
                    </h1>
                    <hr>
                    <div class="space-y-3">
                        <h1>
                            Proof of Payment
                        </h1>
                        <ul>
                            @foreach ($payment->proofs as $key => $proof)
                                <li class="space-y-3">
                                    <a href="{{ Storage::url($proof->path) }}"
                                        target="_blank"
                                        class="text-blue-600">
                                        View image {{ $key + 1 }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @if ($payment->user->step == '4')
                    <x-slot name="footer">
                        <div class="flex justify-end space-x-3">
                            <x-button negative
                                wire:click="reject"
                                spinner="reject">
                                Deny Payment
                            </x-button>
                            <x-button positive
                                wire:click="approve"
                                spinner="approve">
                                Approve Payment
                            </x-button>
                        </div>
                    </x-slot>
                @endif
            </x-card>
        @endif
    </div>
</div>
