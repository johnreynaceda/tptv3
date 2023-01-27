<div>
    <div class="border border-gray-300 rounded-md">
        <x-card shadow="shadow-none"
            title="Payment">
            <div class="mb-4">
                <!-- This example requires Tailwind CSS v2.0+ -->
                <div class="p-4 rounded-md bg-blue-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <!-- Heroicon name: solid/information-circle -->
                            <svg class="w-5 h-5 text-blue-400"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="flex-1 ml-3 md:flex md:justify-between">
                            <p class="text-sm text-blue-700"> Please pay <span class="font-semibold">&#8369; 275</span>
                                .Please make sure that the
                                reference number is clearly
                                reflected in your proof of payment.</p>

                            <p class="mt-3 text-sm md:mt-0 md:ml-6">
                                <x-button
                                    href="https://epaymentportal.landbank.com/pay1.php?code=S05EUEtVSGltb2t0emdaNmwyRFV5aG1pVVYzNHdTRXByL2ZoNHZjS1pZRT0="
                                    target="_bank"
                                    class="font-medium text-blue-700 whitespace-nowrap hover:text-blue-600">Pay Here
                                    <span aria-hidden="true">&rarr;</span>
                                </x-button>
                            </p>
                        </div>
                    </div>
                </div>

            </div>
            <form>
                @csrf
                <div class="space-y-3">
                    <div class="space-y-3">
                        <x-input label="Reference Number"
                            wire:model.defer="reference_number"
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
