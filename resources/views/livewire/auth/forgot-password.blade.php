<div>
    <div class="mb-2">
        <x-errors />
    </div>
    <div>
        <x-jet-label for="email"
            value="{{ __('Email') }}" />
        <x-jet-input wire:model="email"
            class="block w-full mt-1"
            type="email"
            name="email"
            :value="old('email')"
            required
            autofocus />
    </div>

    <div class="mt-4">
        <x-jet-label for="new_password"
            value="{{ __('New Password') }}" />
        <x-jet-input wire:model="new_password"
            class="block w-full mt-1"
            type="password"
            name="password"
            required />
    </div>

    <div class="mt-4">
        <x-jet-label for="confirm_password"
            value="{{ __('Confirm Password') }}" />
        <x-jet-input wire:model="confirm_password"
            class="block w-full mt-1"
            type="password"
            name="password"
            required />
    </div>
    <div class="flex items-center justify-end mt-4 space-x-3">
        <a href="{{ route('login') }}"
            class="text-sm text-gray-600 underline">
            Already registered?
        </a>
        <x-button negative label="Reset Password" wire:click="resetPassword"/>
    </div>
</div>
