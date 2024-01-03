<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">

        </x-slot>
        <div class="flex items-center mb-5 space-x-3">
            <img src="{{ asset('images/sksu1.png') }}"
                class="h-14"
                alt="">
            <div class="text-2xl font-bold text-center text-gray-600">
                Create an account
            </div>
        </div>
        <x-errors />
        <form method="POST"
            action="{{ route('register') }}">
            @csrf

            <div>
                <x-jet-label for="first_name"
                    value="{{ __('First Name') }}" />
                <x-jet-input id="first_name"
                    class="block w-full mt-1"
                    type="text"
                    name="first_name"
                    :value="old('first_name')"
                    required
                    autofocus
                    autocomplete="first_name" />
            </div>

            <div class="mt-4">
                <x-jet-label for="middle_name"
                    value="{{ __('Middle Name') }}" />
                <x-jet-input id="middle_name"
                    class="block w-full mt-1"
                    type="text"
                    name="middle_name"
                    :value="old('middle_name')"
                    required
                    autofocus
                    autocomplete="middle_name" />
            </div>

            <div class="mt-4">
                <x-jet-label for="last_name"
                    value="{{ __('Last Name') }}" />
                <x-jet-input id="last_name"
                    class="block w-full mt-1"
                    type="text"
                    name="last_name"
                    :value="old('last_name')"
                    required
                    autofocus
                    autocomplete="last_name" />
            </div>

            <div class="mt-4">
                <x-jet-label for="email"
                    value="{{ __('Email') }}" />
                <x-jet-input id="email"
                    class="block w-full mt-1"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required />
            </div>

            <div class="mt-4">
                <x-jet-label for="password"
                    value="{{ __('Password') }}" />
                <x-jet-input id="password"
                    class="block w-full mt-1"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label for="password_confirmation"
                    value="{{ __('Confirm Password') }}" />
                <x-jet-input id="password_confirmation"
                    class="block w-full mt-1"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-jet-label for="terms">
                        <div class="flex items-center">
                            <x-jet-checkbox name="terms"
                                id="terms" />

                            <div class="ml-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
    'terms_of_service' => '<a target="_blank" href="' . route('terms.show') . '" class="text-sm text-gray-600 underline hover:text-gray-900">' . __('Terms of Service') . '</a>',
    'privacy_policy' => '<a target="_blank" href="' . route('policy.show') . '" class="text-sm text-gray-600 underline hover:text-gray-900">' . __('Privacy Policy') . '</a>',
]) !!}
                            </div>
                        </div>
                    </x-jet-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="text-sm text-gray-600 underline hover:text-gray-900"
                    href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-jet-button class="ml-4">
                    {{ __('Register') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
