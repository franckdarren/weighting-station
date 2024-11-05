<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!--LOGO APP-->
    <link rel="icon" type="image/png" href="{{ asset('images/R.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
    @filamentStyles
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="font-sans antialiased flex flex-col min-h-screen" x-data="{ darkMode: false }"
    :class="{ 'dark': darkMode === true }">
    <x-banner />

    <div class="flex-grow bg-[#e7eff7]">
        @livewire('navigation-menu')

        <!-- Page Heading -->
        <!-- @if (isset($header))
<header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
@endif -->

        <!-- Page Content -->
        <main class="flex-grow">
            {{ $slot }}
        </main>
    </div>

    @include('components.footer')

    @stack('modals')
    @livewireScripts
    @livewire('notifications')
    @filamentScripts
</body>

</html>