<div class="mb-5">
    <div class="border border-gray-300 rounded-md">
        <x-card shadow="shadow-none" title="Personal Information">
            <form>
                @csrf
                <div class="space-y-3">
                    <x-native-select label="Type" wire:model="type_id">
                        <option value=""></option>
                        <option value="1">Freshmen</option>
                        <option value="2">Transferee</option>
                    </x-native-select>
                    <x-input wire:model.defer="first_name" autocomplete="on" label="First Name" />
                    <x-input wire:model.defer="middle_name" autocomplete="on" label="Middle Name"
                        hint="Leave it blank if not applicable" />
                    <x-input wire:model.defer="last_name" autocomplete="on" label="Last Name" />
                    <x-input wire:model.defer="extension" autocomplete="on" label="Extension"
                        hint="Leave it blank if not applicable" />
                    <x-native-select wire:model.defer="sex" label="Sex">
                        <option value=""></option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </x-native-select>
                    <x-input wire:model.defer="present_address" autocomplete="on" label="Present Address" />
                    <x-input wire:model.defer="permanent_address" autocomplete="on" label="Permanent Address" />
                    <x-input wire:model.defer="phone_number" autocomplete="on" label="Phone Number" />
                    <x-input wire:model="date_of_birth" max="{{ \Carbon\Carbon::now()->subYears(16)->format('Y-m-d') }}"
                        type="date" label="Date Of Birth" />
                    <x-input wire:model.defer="place_of_birth" autocomplete="on" label="Place Of Birth" />
                    <x-input wire:model.defer="age" disabled autocomplete="on" label="Age" />
                    <x-input wire:model.defer="tribe" autocomplete="on" label="Tribe" />
                    <x-input wire:model.defer="religion" autocomplete="on" label="Religion" />
                    <x-input wire:model.defer="nationality" autocomplete="on" label="Nationality" />
                    <!-- <x-input wire:model.defer="citizenship"
                        autocomplete="on"
                        label="Citizenship" /> -->

                    {{-- <div id="imagepreview">
                        @if ($personal_information?->photo)
                            <img src="{{ Storage::url($personal_information->photo) }}" alt="" class="h-40">
                        @endif
                    </div>
                    <x-input wire:model="photo" label="Actual Photo" accept="image/*" type="file"
                        hint="If you encounter an error while uploading your photo, please try to reduce the size of your photo to less than 2MB."
                        corner-hint="Use white background with name tag" />
                    <div wire:loading.flex wire:target="photo">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 animate-spin" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="ml-3 text-gray-500">
                            Please wait while preparing your photo...
                        </span>
                    </div>
                    @if ($photo && $photo != $personal_information?->photo)
                        <div>
                            <span class="text-green-700">
                                File is ready.
                            </span>
                        </div>
                    @endif --}}

                    <div class="mt-4">
                        <x-label value="Actual Photo" />
                        @if ($personal_information?->photo)
                            <img src="{{ Storage::url($personal_information->photo) }}" alt="Photo"
                                class="mx-auto my-2 rounded-md h-40 object-cover border">
                        @endif

                        {{-- Trigger Modal --}}
                     <x-button primary wire:click="$set('showCameraModal', true)">
    Capture / Upload Photo
</x-button>


                    </div>
                </div>
            </form>
            <x-slot name="footer">
                <div class="flex justify-end">
                    @if (auth()->user()->step == '2')
                        @if ($this->personal_information)
                            <x-button  wire:click="update">
                                Update
                            </x-button>
                        @else
                            <x-button  wire:click="create">
                                Save
                            </x-button>
                        @endif
                    @endif
                </div>
            </x-slot>
        </x-card>
    </div>
<x-modal wire:model="showCameraModal" align="center">
        <x-slot name="button"></x-slot>
        <div x-data="cameraModalHandler()" x-init="init()" class="text-center">
            <h2 class="font-semibold text-lg mb-3">📷 Capture Photo</h2>

            {{-- Video / Canvas --}}
            <video x-ref="video" x-show="!captured" autoplay playsinline
                class="rounded-md border w-full h-64 bg-black mx-auto"></video>
            <canvas x-ref="canvas" x-show="captured"
                width="480" height="360"
                class="rounded-md border w-full h-64 bg-black mx-auto"></canvas>

            {{-- Buttons --}}
            <div class="flex justify-center gap-2 mt-4">
                <x-button x-show="!captured"

                    @click="capturePhoto()"


                    >Capture</x-button>

                <x-button x-show="captured"

                    @click="retakePhoto()"


                    >Retake</x-button>

                <x-button x-show="captured"

                    @click="savePhoto()"


                    >Save</x-button>
            </div>
        </div>
    </x-modal>

@section('footer-applicant')
<script>
function cameraModalHandler() {
    return {
        stream: null,
        video: null,
        canvas: null,
        captured: false,

        init() {
            document.addEventListener('modal-closed', () => this.stopCamera());
        },

        async startCamera() {
            this.video = this.$refs.video;
            this.canvas = this.$refs.canvas;

            try {
                this.stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user' } });
                this.video.srcObject = this.stream;
            } catch (err) {
                console.error("Camera access denied:", err);
                this.toast('Camera Access Denied', 'Please allow camera access in your browser settings.', 'warning');
            }
        },

        capturePhoto() {
            this.canvas.width = this.video.videoWidth;
            this.canvas.height = this.video.videoHeight;
            this.canvas.getContext('2d').drawImage(this.video, 0, 0);
            this.captured = true;
            this.stopCamera();
        },

        retakePhoto() {
            this.captured = false;
            this.startCamera();
        },

        stopCamera() {
            if (this.stream) {
                this.stream.getTracks().forEach(track => track.stop());
                this.stream = null;
            }
        },

        async savePhoto() {
            const dataUrl = this.canvas.toDataURL('image/jpeg');
            const blob = this.dataURItoBlob(dataUrl);

            try {
                await $wire.upload('photo', blob, 'captured_photo.jpg',
                    () => this.toast('Photo Captured!', 'Your photo has been uploaded successfully.', 'success'),
                    (error) => this.toast('Upload Failed', error.message, 'error')
                );
            } catch (e) {
                this.toast('Unexpected Error', e.message, 'error');
            }
        },

        toast(title, description, type) {
            // Graceful check if WireUI notify is available
            if ($wire && $wire.notify) {
                $wire.notify({
                    title: title,
                    description: description,
                    icon: type
                });
            } else {
                console.log(`[${type.toUpperCase()}] ${title}: ${description}`);
                alert(`${title}\n${description}`);
            }
        },

        dataURItoBlob(dataURI) {
            const byteString = atob(dataURI.split(',')[1]);
            const mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];
            const ab = new ArrayBuffer(byteString.length);
            const ia = new Uint8Array(ab);
            for (let i = 0; i < byteString.length; i++) {
                ia[i] = byteString.charCodeAt(i);
            }
            return new Blob([ab], { type: mimeString });
        }
    }
}
</script>
@endsection

</div>
