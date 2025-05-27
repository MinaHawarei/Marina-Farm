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

    {{-- Favicon Links - Start --}}
    {{-- تأكد من وجود هذه الملفات في public/images/favicons --}}

    <link rel="icon" type="image/png" sizes="180x113" href="{{ asset('img/zeta exa new2-01.png') }}">

    {{-- <link rel="manifest" href="{{ asset('site.webmanifest') }}"> --}} {{-- إذا كنت تستخدم ملف manifest --}}
    {{-- <meta name="msapplication-TileColor" content="#da532c"> --}} {{-- ألوان للمتصفحات القديمة / ويندوز --}}
    {{-- <meta name="theme-color" content="#ffffff"> --}} {{-- لون شريط العنوان في بعض المتصفحات على الجوال --}}
    {{-- Favicon Links - End --}}

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
    @if(session('error'))
        <script>
            alert("{{ session('error') }}");
        </script>
    @endif
<body class="bg-gray-100 font-sans">
    @include('layouts.navigation')

    <div class="flex h-screen">
        <!-- Navbar -->

        @include('layouts.sidebar')

        <!-- Main Content -->
        <div class="flex-1 overflow-y-auto p-8">

            <main class="p-1">
                {{ $slot }}
            </main>
        </div>
    </div>

</body>
<footer class="text-white py-4" style="background-color: #040629;"> {{-- ملاحظة: mt-8 أفضل من mt-0 ليكون فيه مسافة من المحتوى --}}
    <div class="container mx-auto flex flex-col md:flex-row items-center justify-between px-4">
        {{-- العنصر الأول (Developed By) - سيظهر على اليسار في وضع LTR --}}
        <div class="text-center mb-2 md:mb-0"> {{-- mb-2 md:mb-0 للحفاظ على المسافات في وضع الـ column --}}
            <p>Developed By <a href="https://www.linkedin.com/in/mina-hawarei" class="text-blue-400 hover:underline" target="_blank" rel="noopener noreferrer">Mina Hawarei</a></p>
        </div>

        {{-- العنصر الثاني (جميع الحقوق محفوظة) - سيظهر في المنتصف --}}
        <div class="text-center mb-2 md:mb-0">
            <p>Copyright &copy; {{ date('Y') }} Zeta Exa</p>
        </div>

        {{-- العنصر الثالث (اللوجو) - سيظهر على اليمين في وضع LTR --}}
        <div class="mb-2 md:mb-0">
            <a href="https://facebook.com/ZetaExa" target="_blank" rel="noopener noreferrer">
                <img src="{{ asset('img/ZetaExa.png') }}" alt="Zeta Exa Logo" class="h-8">
            </a>
        </div>
    </div>
</footer>

</html>
