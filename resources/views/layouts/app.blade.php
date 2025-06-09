<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- Favicon Links - Start --}}
    {{-- Ensure these files exist in public/img/ --}}
    <link rel="icon" type="image/png" sizes="180x113" href="{{ asset('img/zeta-exa.png') }}">
    {{-- Favicon Links - End --}}

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans">
    @if(session('error'))
        <script>
            alert("{{ session('error') }}");
        </script>
    @endif

    {{-- Main Page Container: Uses flex-col and min-h-screen to push the footer to the bottom --}}
    {{-- This div now acts as the primary layout container for the entire page content. --}}
    <div class="flex flex-col min-h-screen">

        {{-- Top Navigation Bar (Navbar) --}}
        @include('layouts.navigation')

        {{-- Main Content Area Container: This div holds the fixed sidebar and the scrollable main content. --}}
        {{-- It uses flex-1 to occupy remaining vertical space, pushing the footer down. --}}
        <div class="flex h-screen">

            {{-- Sidebar: Positioned as a direct child of the main layout container. --}}
            {{-- 'hidden md:block' hides it on small screens and shows it as a block on medium/large screens. --}}
            {{-- Its 'position: fixed' CSS property (defined in sidebar.css) makes it stay in place. --}}

            @include('layouts.sidebar')

            {{-- Main Content Area: This container is responsible for the actual page content and the footer. --}}
            {{-- 'flex-1' allows it to take up remaining space. --}}
            {{-- 'flex flex-col' makes it a column flex container for its children (main content and footer). --}}
            {{-- 'overflow-y-auto' allows vertical scrolling for its content if it overflows. --}}
            {{-- 'md:pr-[16rem]' adds right padding on medium/large screens to offset the fixed sidebar. --}}
            {{-- This padding ensures main content doesn't get hidden behind the sidebar. --}}
            <div class="flex-1 flex flex-col overflow-y-auto p-0 ">

                {{-- Main Content Slot: This is where specific page content will be injected. --}}
                {{-- 'flex-1' on <main> ensures it expands to push the footer down if content is short. --}}
                <main class="p-1 flex-1">
                    {{ $slot }}
                </main>

                {{-- Footer: Positioned at the bottom of the Main Content Area container. --}}
                {{-- It will be pushed down by the 'flex-1' property on the <main> tag. --}}
                <footer class="text-white py-4" style="background-color: #040629;" dir="ltr">
                    <div class="container mx-auto flex flex-col md:flex-row items-center justify-between px-4">
                        <div class="mb-2 md:mb-0">
                            <a href="https://facebook.com/ZetaExa" target="_blank" rel="noopener noreferrer">
                                <img src="{{ asset('img/ZetaExa.png') }}" alt="Zeta Exa Logo" class="h-8">
                            </a>
                        </div>
                        <div class="text-center mb-2 md:mb-0">
                            <p>Copyright &copy; {{ date('Y') }} Zeta Exa</p>
                        </div>
                        <div class="text-center mb-2 md:mb-0">
                            <p>Developed By <a href="https://www.linkedin.com/in/mina-hawarei" class="text-blue-400 hover:underline" target="_blank" rel="noopener noreferrer">Mina Hawarei</a></p>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>
</body>
</html>
