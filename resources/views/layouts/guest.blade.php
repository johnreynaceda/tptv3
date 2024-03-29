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

<body>
    <div class="antialiased text-gray-900 bg-gray-100 font-poppins">
        {{ $slot }}
    </div>
    <x-dialog z-index="z-50" blur="md" align="center" />
    @livewireScripts
</body>

</html>
