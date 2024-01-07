<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">

        </x-slot>
        <div class="flex items-center mb-5 space-x-3">
            <img src="{{ asset('images/sksu1.png') }}"
                class="h-14"
                alt="">
            <div class="text-2xl font-bold text-center text-gray-600">
                Forgot Password
            </div>
        </div>
        <livewire:auth.forgot-password />

    </x-jet-authentication-card>
</x-guest-layout>
