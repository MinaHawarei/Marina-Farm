{{-- NAVBAR: Fixed at Top --}}
<nav class="app-navbar" dir="rtl">
    <div class="h-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-full">

            {{-- Left Side: Toggle Buttons + Logo --}}
            <div class="flex items-center gap-2">
                {{-- Mobile Menu Button (visible on mobile only) --}}
                <button @click="toggleMobileMenu()"
                        class="mobile-menu-btn p-2 rounded-lg text-gray-300 hover:text-white hover:bg-white/10 transition-colors focus:outline-none focus:ring-2 focus:ring-brand-500"
                        aria-label="فتح القائمة">
                    <i class="fas" :class="mobileMenuOpen ? 'fa-times' : 'fa-bars'" class="text-xl"></i>
                </button>

                {{-- Logo --}}
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group ms-2">
                    <div class="w-10 h-10 rounded-xl bg-brand-500/20 flex items-center justify-center border border-brand-500/30 group-hover:bg-brand-500/30 transition-colors">
                        <i class="fas fa-cow text-brand-400 text-lg"></i>
                    </div>
                    <h1 class="text-xl font-bold text-white font-tajawal tracking-wide hidden sm:block">مزارع ساره</h1>
                </a>
            </div>

            {{-- Right Side: User Menu --}}
            <div class="flex items-center">
                <x-dropdown align="left" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 px-3 py-2 text-sm leading-4 font-medium rounded-full text-gray-200 hover:text-white hover:bg-white/10 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-brand-500">
                            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center text-white font-bold shadow-lg shadow-brand-500/20">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="hidden md:block font-tajawal">{{ Auth::user()->name }}</div>
                            <i class="fas fa-chevron-down text-xs opacity-75 hidden md:block"></i>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        {{-- Account Header --}}
                        <div class="px-4 py-3 border-b border-gray-100 bg-gray-50/50">
                            <p class="text-sm font-semibold text-gray-900 font-tajawal">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                        </div>

                        <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-3 hover:bg-gray-50 font-tajawal">
                            <i class="fas fa-user-circle text-gray-400 w-5 text-center"></i>
                            {{ __('الملف الشخصي') }}
                        </x-dropdown-link>

                        <div class="border-t border-gray-100"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                             onclick="event.preventDefault(); this.closest('form').submit();"
                                             class="flex items-center gap-3 text-red-600 hover:bg-red-50 hover:text-red-700 font-tajawal">
                                <i class="fas fa-sign-out-alt w-5 text-center"></i>
                                {{ __('تسجيل الخروج') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>
