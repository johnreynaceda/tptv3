<div>
    <div class="border border-gray-300 rounded-md">
        <x-card shadow="shadow-none"
            title="Payment">
            <div class="mb-4">
              

            </div>
            <form>
                @csrf
                <div class="space-y-3">
                    <div class="space-y-3">
                        <x-input label="Reference Number"
                            wire:model.defer="receipt_number"
                            hint="Reference number from your payment receipt" />
                        <x-input type="file"
                            wire:model="proofs"
                            multiple
                            accept="image/*"
                            label="Proof of payment"
                            hint="Please upload the actual photo of receipt" />
                    </div>
                    <div id="laoding">
                        <div wire:loading.flex
                            wire:target="proofs">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-6 h-6 animate-spin"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="ml-3 text-gray-500">
                                Please wait while preparing your photo...
                            </span>
                        </div>
                    </div>
                    <div id="count">
                        @if (count($proofs) > 0)
                            <span class="text-green-600">
                                {{ count($proofs) }} photo(s) is/are ready to be uploaded.
                            </span>
                        @endif
                    </div>
                </div>
            </form>
            <x-slot name="footer">
                <div class="flex justify-end">
                    <x-button wire:click="submit"
                        spinner="submit"
                        positive>
                        Submit
                    </x-button>
                </div>
            </x-slot>
        </x-card>
    </div>
</div>
