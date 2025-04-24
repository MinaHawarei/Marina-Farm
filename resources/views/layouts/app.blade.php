<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="bg-gray-100 font-sans">
    @include('layouts.navigation')

    <div class="flex h-screen">
        <!-- Navbar -->

        @include('layouts.sidebar')

        <!-- Main Content -->
        <div class="flex-1 overflow-y-auto p-8">

            <main class="p-4">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
