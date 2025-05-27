<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/">
                    <x-application-logo class="h-20 fill-current text-gray-500" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
            <footer class="text-black py-4" style="background-color: #ffffff;"> {{-- ملاحظة: mt-8 أفضل من mt-0 ليكون فيه مسافة من المحتوى --}}
    <div class="container mx-auto flex flex-col md:flex-row items-center justify-between px-4">
        {{-- العنصر الثاني (جميع الحقوق محفوظة) - سيظهر في المنتصف --}}
        <div class="text-center mb-2 md:mb-0">
            <p>Copyright &copy; {{ date('Y') }} Zeta Exa</p>
        </div>
        {{-- العنصر الأول (Developed By) - سيظهر على اليسار في وضع LTR --}}
        <div class="text-center mb-2 md:mb-0"> {{-- mb-2 md:mb-0 للحفاظ على المسافات في وضع الـ column --}}
            <p>Developed By <a href="https://www.linkedin.com/in/mina-hawarei" class="text-blue-400 hover:underline" target="_blank" rel="noopener noreferrer">Mina Hawarei</a></p>
        </div>

    </div>
</footer>
    </body>

</html>
