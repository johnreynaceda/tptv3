<div id="upload_result_modal"
    x-on:open-upload-result-modal.window="$wire.$set('openModal',true)">
    <x-modal.card wire:model.defer="openModal"
        title="Upload Result">
        <form class="grid space-y-2">
            @csrf
            <x-input type="file"
                wire:model="file"
                label="File"
                cornerHint=".xlsx, .xls" />
            <div>
                <div wire:loading.flex
                    wire:target="file"
                    class="flex space-x-2 items-center">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        class="h-6 fill-gray-600 animate-spin">
                        <path fill="none"
                            d="M0 0h24v24H0z" />
                        <path d="M18.364 5.636L16.95 7.05A7 7 0 1 0 19 12h2a9 9 0 1 1-2.636-6.364z" />
                    </svg>
                    <span class="text-gray-500">
                        Please wait while preparing for upload...
                    </span>
                </div>
            </div>
            <div>
                @if ($file)
                    <span class="text-green-600">
                        File is ready to upload.
                    </span>
                @endif
            </div>
        </form>
        <x-slot name="footer">
            <div class="flex justify-end">
                @if ($file)
                    <x-button wire:click="upload"
                        positive
                        spinner="upload">
                        Upload now
                    </x-button>
                @endif
            </div>
        </x-slot>
    </x-modal.card>
</div>
