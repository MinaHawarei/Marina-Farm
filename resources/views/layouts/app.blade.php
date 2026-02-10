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
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="180x113" href="{{ asset('img/zeta-exa.png') }}">

    <!-- Charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-tajawal antialiased" 
      x-data="appShell()" 
      :class="{ 'drawer-open': mobileMenuOpen }">
    
    {{-- Flash Messages --}}
    @if(session('error'))
        <script>alert("{{ session('error') }}");</script>
    @endif

    {{-- App Shell Container --}}
    <div class="app-shell">
        
        {{-- NAVBAR: Fixed at Top --}}
        @include('layouts.navigation')

        {{-- BODY: Sidebar + Main Content --}}
        <div class="app-body">
            
            {{-- Mobile Overlay --}}
            <div class="sidebar-overlay lg:hidden" 
                 :class="{ 'active': mobileMenuOpen }" 
                 @click="closeMobileMenu()"></div>
            
            {{-- SIDEBAR: Fixed Position --}}
            <aside class="app-sidebar" 
                   :class="{ 'collapsed': sidebarCollapsed, 'open': mobileMenuOpen }"
                   @keydown.escape.window="closeMobileMenu()">
                {{-- Sidebar Header with Toggle (inside sidebar) --}}
                <div class="hidden lg:flex items-center justify-between px-4 py-3 border-b border-white/5">
                    <span class="sidebar-text text-white/60 text-sm font-tajawal">القائمة</span>
                    <button @click="toggleSidebar()" 
                            class="sidebar-toggle w-8 h-8"
                            :class="{ 'rotated': sidebarCollapsed }"
                            aria-label="طي الشريط الجانبي">
                        <i class="fas fa-chevron-right text-sm"></i>
                    </button>
                </div>
                
                {{-- Sidebar Navigation Content --}}
                <div class="app-sidebar-content">
                    @include('layouts.sidebar')
                </div>
            </aside>

            {{-- MAIN CONTENT: The Only Scrolling Area --}}
            <div class="app-main" :class="{ 'sidebar-collapsed': sidebarCollapsed }">
                {{-- Scrollable Content --}}
                <main class="app-content">
                    <div class="app-content-body">
                        {{ $slot }}
                    </div>

                    {{-- Footer: Scrolls with page content --}}
                    <footer class="app-footer" dir="ltr">
                        <div class="flex flex-col md:flex-row items-center justify-between text-sm gap-2">
                            <a href="https://facebook.com/ZetaExa" target="_blank" rel="noopener noreferrer">
                                <img src="{{ asset('img/ZetaExa.png') }}" alt="Zeta Exa Logo" class="h-6">
                            </a>
                            <p class="text-gray-400">Copyright &copy; {{ date('Y') }} Zeta Exa</p>
                            <p class="text-gray-400">Developed By <a href="https://www.linkedin.com/in/mina-hawarei" class="text-brand-400 hover:underline" target="_blank" rel="noopener noreferrer">Mina Hawarei</a></p>
                        </div>
                    </footer>
                </main>
            </div>
        </div>
    </div>

    {{-- App Shell Alpine.js Component --}}
    <script>
        function appShell() {
            return {
                // State
                sidebarCollapsed: localStorage.getItem('sidebar_collapsed') === 'true',
                mobileMenuOpen: false,
                
                // Initialize
                init() {
                    // Watch for window resize to close mobile menu on desktop
                    window.addEventListener('resize', () => {
                        if (window.innerWidth >= 1025 && this.mobileMenuOpen) {
                            this.closeMobileMenu();
                        }
                    });
                },
                
                // Toggle sidebar collapse (desktop)
                toggleSidebar() {
                    this.sidebarCollapsed = !this.sidebarCollapsed;
                    localStorage.setItem('sidebar_collapsed', this.sidebarCollapsed);
                },
                
                // Toggle mobile menu
                toggleMobileMenu() {
                    this.mobileMenuOpen = !this.mobileMenuOpen;
                },
                
                // Close mobile menu
                closeMobileMenu() {
                    this.mobileMenuOpen = false;
                },
            }
        }
    </script>
</body>
</html>
