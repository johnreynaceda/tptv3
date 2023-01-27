<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1">
    <meta name="csrf-token"
        content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="preconnect"
        href="https://fonts.googleapis.com">
    <link rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap"
        rel="stylesheet">
    <!-- Styles -->
    <link rel="stylesheet"
        href="{{ mix('css/app.css') }}">

    @livewireStyles
    @wireUiScripts
    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"
        defer></script>
</head>

<body x-data="{ openMenu: false }"
    class="relative font-poppins">
    <!-- This example requires Tailwind CSS v2.0+ -->
    <div x-cloak
        x-show="openMenu"
        class="relative z-50"
        aria-labelledby="slide-over-title"
        role="dialog"
        aria-modal="true">
        <div class="fixed inset-0"></div>
        <div class="fixed inset-0 overflow-hidden">
            <div class="absolute inset-0 overflow-hidden">
                <div class="fixed inset-y-0 left-0 flex max-w-full pointer-events-none">
                    <div x-cloak
                        x-show="openMenu"
                        x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                        x-transition:enter-start="-translate-x-full"
                        x-transition:enter-end="translate-x-0"
                        x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                        x-transition:leave-start="translate-x-0"
                        x-transition:leave-end="-translate-x-full"
                        class="w-screen pointer-events-auto">
                        <div class="flex flex-col h-full py-6 overflow-y-scroll bg-white shadow-xl">
                            <div class="px-4 sm:px-6">
                                <div class="flex items-start justify-between sm:px-5">

                                    <div class="flex items-center ml-3 h-7">
                                        <button type="button"
                                            x-on:click="openMenu = false"
                                            class="text-gray-400 rounded-md hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                            <span class="sr-only">Close panel</span>
                                            <!-- Heroicon name: outline/x -->
                                            <svg class="w-6 h-6"
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke-width="2"
                                                stroke="currentColor"
                                                aria-hidden="true">
                                                <path stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="relative flex-1 px-10 mt-10 ">
                                <nav class="justify-center space-y-1 "
                                    aria-label="Sidebar">
                                    <a href="#"
                                        class="flex items-center px-3 py-2 text-sm font-medium text-center text-gray-600 rounded-md hover:bg-gray-50 hover:text-gray-900">
                                        <span class="truncate"> Help Desk </span>
                                    </a>

                                    <form method="POST"
                                        action="{{ route('logout') }}"
                                        x-data>
                                        @csrf
                                        <a href="{{ route('logout') }}"
                                            @click.prevent="$root.submit();"
                                            class="flex items-center px-3 py-2 text-sm font-medium text-center text-gray-600 rounded-md hover:bg-gray-50 hover:text-gray-900">
                                            <span class="truncate"> Logout </span>
                                        </a>

                                    </form>
                                </nav>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="mx-auto sm:max-w-3xl">
            <div class="sticky top-0 z-40 flex w-full p-3 bg-white">
                <div id="menuContainer">
                    {{--  --}}
                </div>
            </div>
            <div class="px-4">
                {{ $slot }}

            </div>
        </div>
    </div>
    <x-notifications z-index="z-50" />
    <x-dialog z-index="z-50"
        blur="md"
        align="center" />
    @livewireScripts
</body>

</html>
