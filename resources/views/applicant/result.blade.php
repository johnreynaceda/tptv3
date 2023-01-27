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

<body x-data="{
    printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
}"
    class="py-10 antialiased font-poppins">
    <div class="flex justify-between max-w-5xl px-3 mx-auto sm:px-0">
        <h1>
            TPT RESULT
        </h1>
        <div class="flex space-x-3">
            <x-button x-on:click="printDiv('printable')"
                icon="printer"
                positive>
                Print
            </x-button>
        </div>
    </div>
    <div id="printable"
        class="px-3 sm:px-0">
        <div class="grid ">
            <div class="flex space-x-2">
                <img src="{{ asset('images/sksu1.png') }}"
                    class="h-28"
                    alt="">
                <div class="grid space-x-1 text-sm font-semibold">
                    <h1>
                        Republic of the Philippines
                    </h1>
                    <h1 class="text-green-700">
                        Sultan Kudarat State University
                    </h1>
                    <h1 class="font-thin">
                        ACCESS, EJC Montilla, 9800 City of Tacurong
                    </h1>
                    <h1 class="font-thin">
                        Province of Sultan Kudarat
                    </h1>
                    <h1 class="font-thin">
                        Tertiary Placement Test Result
                    </h1>
                </div>
            </div>
            <div class="flex mt-10 space-x-2 item-end">
                <img src="{{ Storage::url($user_personal_information->photo) }}"
                    class="h-40"
                    alt="">
                <div class="flex items-end ">
                    <div class="grid space-y-1">
                        <h1>
                            Name : <span class="font-semibold">
                                {{ $user_personal_information->first_name }}
                                {{ $user_personal_information->middle_name }}
                                {{ $user_personal_information->last_name }}
                                {{ $user_personal_information->extension }}
                            </span>
                        </h1>
                        @foreach ($user_program_choices as $user_program_choice)
                            <h1>
                                {{ $user_program_choice->is_priority ? 'First Priority' : 'Second Priority' }} :
                                <span class="font-semibold">
                                    {{ $user_program_choice->program->name }}
                                </span>
                            </h1>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="grid mt-10 space-y-5">
                <livewire:result.score-result />
                <x-result.score-guide />
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
