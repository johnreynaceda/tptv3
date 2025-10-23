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

                    <div class="mt-4">
    <x-label value="Actual Photo" />

    {{-- Show existing saved photo --}}
    @if ($personal_information?->photo && !$photo)
        <div class="mt-2">
            <p class="text-xs text-gray-500 mb-1">Current Photo:</p>
            <img src="{{ Storage::url($personal_information->photo) }}" alt="Current Photo"
                class="mx-auto rounded-md h-40 object-cover border border-gray-300">
        </div>
    @endif

    {{-- Show preview of captured photo (before saving) --}}
    @if ($photo)
        <div class="mt-2 space-y-2">
            {{-- Show old photo for comparison --}}
            @if ($personal_information?->photo)
                <div>
                    <p class="text-xs text-gray-500 mb-1">Previous Photo:</p>
                    <img src="{{ Storage::url($personal_information->photo) }}" alt="Previous Photo"
                        class="mx-auto rounded-md h-32 object-cover border border-gray-300 opacity-60">
                </div>
            @endif

            {{-- Show new captured photo --}}
            <div>
                <p class="text-xs font-semibold text-green-600 mb-1">📸 New Photo (Not Saved Yet):</p>
                <img src="{{ $photo->temporaryUrl() }}" alt="New Photo Preview"
                    class="mx-auto rounded-md h-40 object-cover border-2 border-green-500 shadow-lg">
                <p class="text-sm text-green-600 text-center mt-2">
                      ✅ Photo captured! Click
                   @if (auth()->user()->step == '2')
                        @if ($this->personal_information)

                                Update

                        @else

                                Save
               
                        @endif
                    @endif
button below to confirm.
                </p>
            </div>
        </div>
    @endif

    {{-- Trigger Modal --}}
    <x-button primary wire:click="openCameraModal" class="mt-3">
        {{ $photo || $personal_information?->photo ? 'Retake Photo' : 'Take A Photo' }}
    </x-button>
</div>
                </div>
            </form>
            <x-slot name="footer">
                <div class="flex justify-end">
                    @if (auth()->user()->step == '2')
                        @if ($this->personal_information)
                            <x-button wire:click="update">
                                Update
                            </x-button>
                        @else
                            <x-button wire:click="create">
                                Save
                            </x-button>
                        @endif
                    @endif
                </div>
            </x-slot>
        </x-card>
    </div>

    {{-- Camera Modal --}}
    <x-modal wire:model="showCameraModal" align="center">
        <x-slot name="button"></x-slot>
        <div x-data="cameraModalHandler()" x-init="console.log('Alpine component initialized');
        setTimeout(() => {
            console.log('Checking modal state:', $wire.showCameraModal);
            if ($wire.showCameraModal) {
                console.log('Modal is open, starting camera...');
                startCamera();
            }
        }, 500);

        Livewire.on('start-camera', () => {
            console.log('Received start-camera event');
            setTimeout(() => startCamera(), 300);
        });" class="text-center">
            <h2 class="font-semibold text-lg mb-3">📷 Capture Photo</h2>

            {{-- Camera status --}}
            <div x-show="cameraLoading" class="mb-3 text-gray-600">
                <svg class="animate-spin h-5 w-5 inline-block" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                Starting camera...
            </div>

            {{-- Video / Canvas --}}
            <div class="relative">
                <video x-ref="video" x-show="!captured && !cameraLoading" autoplay playsinline
                    class="rounded-md border w-full h-64 bg-black mx-auto object-cover"></video>

                <canvas x-ref="canvas" x-show="captured" width="640" height="480"
                    class="rounded-md border w-full h-64 bg-gray-900 mx-auto object-cover"></canvas>
            </div>

            {{-- Debug info --}}
            <div class="text-xs text-gray-500 mt-2" x-show="captured">
                ✅ Photo captured! Preview above.
            </div>

            {{-- Upload loading indicator --}}
            <div x-show="uploading" class="mt-2 text-gray-600">
                <svg class="animate-spin h-5 w-5 inline-block" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                Uploading photo...
            </div>

            {{-- Buttons --}}
            <div class="flex justify-center gap-2 mt-4">
                <x-button x-show="!captured && !cameraLoading" @click="capturePhoto()">
                    📸 Capture
                </x-button>

                <x-button x-show="captured" @click="retakePhoto()" x-bind:disabled="uploading">
                    🔄 Retake
                </x-button>

                <x-button x-show="captured" @click="savePhoto()" x-bind:disabled="uploading">
                    ✅ Save
                </x-button>

                <x-button secondary @click="closeModal()" x-bind:disabled="uploading">
                    Cancel
                </x-button>
            </div>
        </div>
    </x-modal>

    <script>
        function cameraModalHandler() {
            return {
                stream: null,
                video: null,
                canvas: null,
                captured: false,
                uploading: false,
                cameraLoading: false,

                async startCamera() {
                    this.cameraLoading = true;
                    this.captured = false;

                    // Wait for DOM to be ready
                    await this.$nextTick();
                    await new Promise(resolve => setTimeout(resolve, 300));

                    this.video = this.$refs.video;
                    this.canvas = this.$refs.canvas;

                    if (!this.video) {
                        console.error('Video element not found');
                        this.cameraLoading = false;
                        alert('⚠️ Error: Video element not ready');
                        return;
                    }

                    try {
                        console.log('Requesting camera access...');

                        // Check if mediaDevices is available
                        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                            throw new Error('Camera API not supported in this browser');
                        }

                        this.stream = await navigator.mediaDevices.getUserMedia({
                            video: {
                                facingMode: 'user',
                                width: {
                                    ideal: 640
                                },
                                height: {
                                    ideal: 480
                                }
                            },
                            audio: false
                        });

                        console.log('Camera stream obtained:', this.stream);
                        this.video.srcObject = this.stream;

                        // Wait for video to be ready with timeout
                        await Promise.race([
                            new Promise((resolve) => {
                                this.video.onloadedmetadata = () => {
                                    console.log('Video metadata loaded, dimensions:', this.video
                                        .videoWidth, 'x', this.video.videoHeight);
                                    resolve();
                                };
                            }),
                            new Promise((_, reject) =>
                                setTimeout(() => reject(new Error('Video load timeout')), 5000)
                            )
                        ]);

                        await this.video.play();
                        console.log('Camera started successfully');
                        this.cameraLoading = false;

                    } catch (err) {
                        console.error('Camera access error:', err);
                        this.cameraLoading = false;
                        let errorMsg = '⚠️ Camera error: ';

                        if (err.name === 'NotAllowedError') {
                            errorMsg += 'Permission denied. Please allow camera access.';
                        } else if (err.name === 'NotFoundError') {
                            errorMsg += 'No camera found on this device.';
                        } else if (err.name === 'NotReadableError') {
                            errorMsg += 'Camera is already in use by another application.';
                        } else {
                            errorMsg += err.message || 'Unknown error occurred.';
                        }

                        alert(errorMsg);
                    }
                },

                capturePhoto() {
                    console.log('=== CAPTURE PHOTO CLICKED ===');
                    console.log('Video element:', this.video);
                    console.log('Canvas element:', this.canvas);
                    console.log('Video dimensions:', this.video?.videoWidth, 'x', this.video?.videoHeight);
                    console.log('Video ready state:', this.video?.readyState);
                    console.log('Current captured state:', this.captured);

                    if (!this.video) {
                        console.error('Video element is null');
                        alert('⚠️ Camera not initialized. Please close and reopen the modal.');
                        return;
                    }

                    if (!this.video.videoWidth || this.video.videoWidth === 0) {
                        console.error('Video not ready - no video dimensions');
                        alert(
                            '⚠️ Camera not ready. Please wait for the camera to fully load (you should see yourself on screen).');
                        return;
                    }

                    try {
                        console.log('Setting canvas dimensions...');
                        this.canvas.width = this.video.videoWidth;
                        this.canvas.height = this.video.videoHeight;
                        console.log('Canvas size set to:', this.canvas.width, 'x', this.canvas.height);

                        const ctx = this.canvas.getContext('2d');
                        console.log('Drawing image to canvas...');
                        ctx.drawImage(this.video, 0, 0);

                        console.log('Setting captured = true');
                        this.captured = true;
                        console.log('Captured state is now:', this.captured);

                        this.stopCamera();
                        console.log('✅ Photo captured successfully!');

                        // Force Alpine to update the DOM
                        this.$nextTick(() => {
                            console.log('DOM updated, canvas should be visible');
                        });
                    } catch (err) {
                        console.error('Capture error:', err);
                        alert('⚠️ Failed to capture photo: ' + err.message);
                    }
                },

                retakePhoto() {
                    this.captured = false;
                    this.startCamera();
                },

                stopCamera() {
                    if (this.stream) {
                        this.stream.getTracks().forEach(track => {
                            track.stop();
                            console.log('Camera track stopped');
                        });
                        this.stream = null;
                        if (this.video) {
                            this.video.srcObject = null;
                        }
                    }
                },

                async savePhoto() {
                    this.uploading = true;

                    try {
                        // Convert canvas to image file
                        const dataUrl = this.canvas.toDataURL('image/jpeg', 0.9);
                        const blob = this.dataURItoBlob(dataUrl);
                        const file = new File([blob], 'photo_' + Date.now() + '.jpg', {
                            type: 'image/jpeg'
                        });

                        console.log('Uploading photo... Size:', (file.size / 1024).toFixed(2), 'KB');

                        // Upload to Livewire
                        await this.$wire.upload('photo', file);

                        console.log('✅ Upload successful!');

                        // Close modal
                        this.closeModal();
                    } catch (error) {
                        console.error('Upload failed:', error);
                        alert('❌ Upload failed. Please try again.');
                    } finally {
                        this.uploading = false;
                    }
                },

                closeModal() {
                    this.stopCamera();
                    this.captured = false;
                    this.$wire.showCameraModal = false;
                },

                dataURItoBlob(dataURI) {
                    const byteString = atob(dataURI.split(',')[1]);
                    const mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];
                    const ab = new ArrayBuffer(byteString.length);
                    const ia = new Uint8Array(ab);
                    for (let i = 0; i < byteString.length; i++) {
                        ia[i] = byteString.charCodeAt(i);
                    }
                    return new Blob([ab], {
                        type: mimeString
                    });
                }
            }
        }
    </script>
</div>
