<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
        </x-slot>
        <div class="flex items-center mb-5 space-x-3">
            <img src="{{ asset('images/sksu1.png') }}"
                class="h-14"
                alt="">
            <div class="text-2xl font-bold text-center text-gray-600">
                Sign in to your account
            </div>
        </div>
        @if (session('status'))
            <div class="mb-4 text-sm font-medium text-green-600">
                {{ session('status') }}
            </div>
        @endif
        <div class="mb-2">
            <x-errors />
        </div>
        <form method="POST"
            action="{{ route('login') }}">
            @csrf

            <div>
                <x-jet-label for="email"
                    value="{{ __('Email') }}" />
                <x-jet-input id="email"
                    class="block w-full mt-1"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autofocus />
            </div>

            <div class="mt-4">
                <x-jet-label for="password"
                    value="{{ __('Password') }}" />
                <x-jet-input id="password"
                    class="block w-full mt-1"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password" />
            </div>
            <div class="block mt-4">
                <label for="remember_me"
                    class="flex items-center">
                    <x-jet-checkbox id="remember_me"
                        name="remember" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>
            <div class="flex items-center justify-end mt-4 space-x-3">
                <a href="{{ route('register') }}"
                    class="text-sm text-gray-600 underline">
                    Don't have an account?
                </a>
                <x-button type="submit"
                    positive>
                    LOGIN
                </x-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
{{-- <!DOCTYPE html>
<html class="h-full"
    lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1">
    <meta name="csrf-token"
        content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="preconnect"
        href="https://fonts.googleapis.com">
    <link rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap"
        rel="stylesheet">
    <link rel="stylesheet"
        href="{{ mix('css/app.css') }}">
    <script src="{{ mix('js/app.js') }}"
        defer></script>
</head>

<body class="h-full antialiased font-poppins">
    <div class="flex min-h-full">
        <div class="flex flex-col justify-center flex-1 px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
            <div class="w-full max-w-sm mx-auto lg:w-96">
                <div>
                    <img class="w-auto h-12"
                         src="{{ asset('images/sksu1.png') }}"
                        alt="Workflow">
                    <h2 class="mt-6 text-3xl text-gray-900">Sign in to your account</h2>
                </div>

                <div class="mt-8">


                    <div class="mt-6">
                        <form action="#"
                            method="POST"
                            class="space-y-6">
                            <div>
                                <label for="email"
                                    class="block text-sm font-medium text-gray-700"> Email address </label>
                                <div class="mt-1">
                                    <input id="email"
                                        name="email"
                                        type="email"
                                        autocomplete="email"
                                        required
                                        class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                </div>
                            </div>

                            <div class="space-y-1">
                                <label for="password"
                                    class="block text-sm font-medium text-gray-700"> Password </label>
                                <div class="mt-1">
                                    <input id="password"
                                        name="password"
                                        type="password"
                                        autocomplete="current-password"
                                        required
                                        class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <input id="remember-me"
                                        name="remember-me"
                                        type="checkbox"
                                        class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                    <label for="remember-me"
                                        class="block ml-2 text-sm text-gray-900"> Remember me </label>
                                </div>

                                <div class="text-sm">
                                    <a href="#"
                                        class="font-medium text-green-600 hover:text-green-500"> Forgot your password?
                                    </a>
                                </div>
                            </div>

                            <div>
                                <button type="submit"
                                    class="flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Sign
                                    in</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="relative flex-1 hidden w-0 lg:block">
            <img class="absolute inset-0 object-cover w-full h-full"
                src="{{ asset('images/sksu.png') }}"
                alt="">
        </div>
    </div>

</body>

</html> --}}
