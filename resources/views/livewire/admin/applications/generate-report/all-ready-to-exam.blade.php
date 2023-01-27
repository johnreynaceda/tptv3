<div>
    <x-button wire:click="$set('report_modal',true)"
        outline>
        <svg xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            class="h-5 fill-green-600">
            <path fill="none"
                d="M0 0h24v24H0z" />
            <path
                d="M2.859 2.877l12.57-1.795a.5.5 0 0 1 .571.495v20.846a.5.5 0 0 1-.57.495L2.858 21.123a1 1 0 0 1-.859-.99V3.867a1 1 0 0 1 .859-.99zM17 3h4a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1h-4V3zm-6.8 9L13 8h-2.4L9 10.286 7.4 8H5l2.8 4L5 16h2.4L9 13.714 10.6 16H13l-2.8-4z" />
        </svg>
        General Report
    </x-button>
    <div id="report_modal">
        <x-modal.card wire:model.defer="report_modal"
            title="Generate Report">
            <form>
                @csrf
                <x-native-select label="Select Report"
                    wire:model="selected_report">
                    <option value="">Select Report</option>
                    <option value="1">
                        All Ready to Exam
                    </option>
                    <option value="2">
                        All Application (Approve and not Approved)
                    </option>
                </x-native-select>
            </form>
            <x-slot name="footer">
                <div class="flex justify-end">
                    @if ($ready_to_download)
                        <x-button positive
                            spinner="startDownload"
                            wire:click="startDownload">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5"
                                viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                            Download
                        </x-button>
                    @endif
                </div>
            </x-slot>
        </x-modal.card>
    </div>
</div>
