<div>
    <div class="ml-3">
        <h3 class="text-sm font-medium text-red-800">
        Your payment is denied.
        </h3>
        <div class="mt-2 text-sm text-red-700">
        <ul role="list" class="pl-5 space-y-1">
            <li>Your application was disapproved due to the following reason :</li>
        </ul>
        <ul role="list" class="pl-10 pt-2 space-y-1 list-disc text-sm">
            <li>{{auth()->user()->remarks}}</li>
        </ul>
        </div>
    </div>

    <div class="mt-4 flex justify-center">
        <x-button wire:click="resubmitPayment" warning lg rightIcon="cash">
            Resubmit Payment
           </x-button>
    </div>
</div>
