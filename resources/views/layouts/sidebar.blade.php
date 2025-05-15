
    <!-- روابط الخطوط -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Alpine JS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* تنسيقات عامة */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Tajawal', sans-serif;
        }
        /* أضف هذه الأنماط */
        @media (max-width: 767px) {
            .sidebar {
                position: fixed;
                left: -16rem;
                top: 0;
                bottom: 0;
                z-index: 1000;
                transition: left 0.3s ease;
            }

            .sidebar.open {
                left: 0;
            }

            .sidebar-overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0,0,0,0.5);
                z-index: 999;
                display: none;
            }
        }
        :root {
            --primary-dark: #040629;
            --primary-light: #070a2e;
            --active-bg: rgba(255, 255, 255, 0.05);
            --active-text: #ffffff;
            --hover-color: #3b82f6;
            --badge-bg: #3b82f6;
            --text-light: #cccccc;
            --text-white: #ffffff;
        }

        /* تنسيقات الـ Sidebar */
        .sidebar {
            background: linear-gradient(180deg, var(--primary-dark) 0%, var(--primary-light) 100%);
            width: 16rem;
            min-height: 100vh;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
            will-change: transform;
            backface-visibility: hidden;
        }

        /* عناصر القائمة */
        .sidebar-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 1.5rem;
            margin: 0.25rem 0;
            color: var(--text-light);
            font-weight: 600;
            border-right: 4px solid transparent;
            transition: all 0.25s ease;
            position: relative;
            overflow: hidden;
            cursor: pointer;
            text-decoration: none;
        }

        .sidebar-item:hover {
            color: var(--text-white);
            background-color: rgba(255, 255, 255, 0.05);
        }

        .sidebar-item.active {
            background-color: var(--active-bg);
            color: var(--active-text);
            border-radius: 0 15px 15px 0;
            border-right-color: var(--hover-color);
        }
        .sidebar-dropdown-item.active {
            background-color: var(--active-bg);
            color: var(--active-text);
            border-radius: 0 15px 15px 0;
            border-right-color: var(--hover-color);
        }

        .sidebar-dropdown-item.active:hover {
            background-color: var(--active-bg);
            color: var(--active-text);
        }

        /* الأيقونات */
        .sidebar-item i {
            transition: transform 0.2s ease;
            font-size: 0.9rem;
        }

        .sidebar-item:hover i {
            transform: scale(1.1);
        }

        /* العداد (Badge) */
        .sidebar-badge {
            background-color: var(--badge-bg);
            color: white;
            font-size: 0.65rem;
            font-weight: bold;
            border-radius: 9999px;
            height: 1.25rem;
            width: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .sidebar-item:hover .sidebar-badge {
            transform: scale(1.1);
            background-color: #2563eb;
        }
        .sidebar-dropdown-item:hover {
            color: var(--text-white);
            background-color: rgba(255, 255, 255, 0.05);
        }

        .sidebar-dropdown-item:hover i {
            transform: scale(1.1);
        }

        .sidebar-dropdown-item:hover .sidebar-badge {
            transform: scale(1.1);
            background-color: #2563eb;
        }

        .sidebar-dropdown-item::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--hover-color);
            transition: width 0.3s ease;
        }

        .sidebar-dropdown-item:hover::after {
            width: 100%;
        }

        /* القوائم المنسدلة */
        .sidebar-dropdown {
            transition: all 0.3s ease-out;
            overflow: hidden;
            color: white;
            background-color: rgba(4, 6, 41, 0.9);
        }

        .sidebar-dropdown-item {
            padding: 0.75rem 3.0rem 0.75rem 3rem;
            transition: all 0.2s ease;
            /* أضف هذه الخاصية */
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* تأثيرات متقدمة */
        .sidebar-item::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--hover-color);
            transition: width 0.3s ease;
        }

        .sidebar-item:hover::after {
            width: 100%;
        }

        /* Animation for dropdown */
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .sidebar-dropdown {
            animation: slideDown 0.3s ease-out forwards;
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            .sidebar-item.active {
                background-color: #1e293b;
                color: #f8fafc;
            }
        }
    </style>

    <!-- Sidebar -->

    <button id="mobile-menu-button" class="md:hidden p-2 text-white">
        <i class="fas fa-bars text-xl"></i>
    </button>
    <div class="sidebar">
        <!-- رابط الرئيسية -->
        <a href="{{ route('dashboard') }}" class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <div class="flex items-center">
                <i class="fas fa-tachometer-alt ml-2"></i>
                <span class="mr-2">الرئيسية</span>
            </div>
        </a>

        <!-- قسم الجاموس مع القائمة المنسدلة -->
        <div x-data="{ isOpen: {{ request()->routeIs('buffalo.*') ? 'true' : 'false' }} }" class="relative">
            <!-- زر القسم الرئيسي -->
            <button @click="isOpen = !isOpen" class="sidebar-item w-full text-left">
                <div class="flex items-center">
                    <i class="fas fa-cow ml-2"></i>
                    <span class="mr-2">الجاموس</span>
                </div>
                <div class="flex items-center">
                    <span class="sidebar-badge ml-2 mr-2 ">
                        {{ $sidebarBuffaloCount ?? 0 }}
                    </span>
                    <i x-show="!isOpen" class="fas fa-chevron-down text-xs"></i>
                    <i x-show="isOpen" class="fas fa-chevron-up text-xs"></i>
                </div>
            </button>

            <!-- القائمة المنسدلة -->
            <div x-show="isOpen" x-collapse class="sidebar-dropdown">
                <a href="{{ route('buffalo.index') }}" class="sidebar-dropdown-item {{ request()->routeIs('buffalo.index') ? 'active' : '' }}">
                    <div class="flex items-center">
                        <i class="fas fa-list ml-2"></i>
                        <span class="mr-2">الرئيسية</span>
                    </div>
                    <span class="sidebar-badge">
                        {{ $sidebarBuffaloCount ?? 0 }}
                    </span>
                </a>
                <a href="{{ route('buffalo.pregnant') }}" class="sidebar-dropdown-item {{ request()->routeIs('buffalo.pregnant') ? 'active' : '' }}">
                    <div class="flex items-center">
                        <i class="fas fa-baby ml-2"></i>
                        <span class="mr-2">عشار</span>
                    </div>
                    <span class="sidebar-badge">
                        {{ $pregnantBuffaloCount ?? 0 }}
                    </span>
                </a>
                <a href="{{ route('buffalo.dairy') }}" class="sidebar-dropdown-item {{ request()->routeIs('buffalo.dairy') ? 'active' : '' }}">
                    <div class="flex items-center">
                        <i class="fas fa-wine-bottle ml-2"></i>
                        <span class="mr-2">حلاب</span>
                    </div>
                    <span class="sidebar-badge">
                        {{ $dairyBuffaloCount ?? 0 }}
                    </span>
                </a>
                <a href="{{ route('buffalo.fattening') }}" class="sidebar-dropdown-item {{ request()->routeIs('buffalo.fattening') ? 'active' : '' }}">
                    <div class="flex items-center">
                        <i class="fas fa-weight ml-2"></i>
                        <span class="mr-2">تسمين</span>
                    </div>
                    <span class="sidebar-badge">
                        {{ $fatteningBuffaloCount ?? 0 }}
                    </span>
                </a>
                <a href="{{ route('buffalo.calf') }}" class="sidebar-dropdown-item {{ request()->routeIs('buffalo.calf') ? 'active' : '' }}">
                    <div class="flex items-center">
                        <i class="fas fa-paw ml-2"></i>
                        <span class="mr-2">مواليد</span>
                    </div>
                    <span class="sidebar-badge">
                        {{ $calfBuffaloCount ?? 0 }}
                    </span>
                </a>
            </div>
        </div>

        <!-- قسم الابقار مع القائمة المنسدلة -->
        <div x-data="{ isOpen: {{ request()->routeIs('cow.*') ? 'true' : 'false' }} }" class="relative">
            <!-- زر القسم الرئيسي -->
            <button @click="isOpen = !isOpen" class="sidebar-item w-full text-left">
                <div class="flex items-center">
                    <i class="fas fa-cow ml-2"></i>
                    <span class="mr-2">الابقار</span>
                </div>
                <div class="flex items-center">
                    <span class="sidebar-badge ml-2 mr-2">
                        {{ $cowCount ?? 0 }}
                    </span>
                    <i x-show="!isOpen" class="fas fa-chevron-down text-xs"></i>
                    <i x-show="isOpen" class="fas fa-chevron-up text-xs"></i>
                </div>
            </button>

            <!-- القائمة المنسدلة -->
            <div x-show="isOpen" x-collapse class="sidebar-dropdown">
                <a href="{{ route('cow.index') }}" class="sidebar-dropdown-item {{ request()->routeIs('cow.index') ? 'active' : '' }}">
                    <div class="flex items-center">
                        <i class="fas fa-list ml-2"></i>
                        <span class="mr-2">الرئيسية</span>
                    </div>
                    <span class="sidebar-badge">
                        {{ $cowCount ?? 0 }}
                    </span>
                </a>
                <a href="{{ route('cow.pregnant') }}" class="sidebar-dropdown-item {{ request()->routeIs('cow.pregnant') ? 'active' : '' }}">
                    <div class="flex items-center">
                        <i class="fas fa-baby ml-2"></i>
                        <span class="mr-2">عشار</span>
                    </div>
                    <span class="sidebar-badge">
                        {{ $pregnantCow ?? 0 }}
                    </span>
                </a>
                <a href="{{ route('cow.dairy') }}" class="sidebar-dropdown-item {{ request()->routeIs('cow.dairy') ? 'active' : '' }}">
                    <div class="flex items-center">
                        <i class="fas fa-wine-bottle ml-2"></i>
                        <span class="mr-2">حلاب</span>
                    </div>
                    <span class="sidebar-badge">
                        {{ $dairyCow ?? 0 }}
                    </span>
                </a>
                <a href="{{ route('cow.fattening') }}" class="sidebar-dropdown-item {{ request()->routeIs('cow.fattening') ? 'active' : '' }}">
                    <div class="flex items-center">
                        <i class="fas fa-weight ml-2"></i>
                        <span class="mr-2">تسمين</span>
                    </div>
                    <span class="sidebar-badge">
                        {{ $fatteningCow ?? 0 }}
                    </span>
                </a>
                <a href="{{ route('cow.calf') }}" class="sidebar-dropdown-item {{ request()->routeIs('cow.calf') ? 'active' : '' }}">
                    <div class="flex items-center">
                        <i class="fas fa-paw ml-2"></i>
                        <span class="mr-2">مواليد</span>
                    </div>
                    <span class="sidebar-badge">
                        {{ $calfCow ?? 0 }}
                    </span>
                </a>
            </div>
        </div>

        <!-- قسم اليومية مع القائمة المنسدلة -->
        <div x-data="{ isOpen: {{ request()->routeIs('daily.*') ? 'true' : 'false' }} }" class="relative">
            <!-- زر القسم الرئيسي -->
            <button @click="isOpen = !isOpen" class="sidebar-item w-full text-left">
                <div class="flex items-center">
                    <i class="fas fa-calendar-day ml-2"></i>
                    <span class="mr-2">اليومية</span>
                </div>
                <div class="flex items-center">
                    <i x-show="!isOpen" class="fas fa-chevron-down text-xs"></i>
                    <i x-show="isOpen" class="fas fa-chevron-up text-xs"></i>
                </div>
            </button>

            <!-- القائمة المنسدلة -->
            <div x-show="isOpen" x-collapse class="sidebar-dropdown">
                <a href="{{ route('daily.index') }}" class="sidebar-dropdown-item {{ request()->routeIs('daily.index') ? 'active' : '' }}">
                    <div class="flex items-center">
                        <i class="fas fa-home ml-2"></i>
                        <span class="mr-2">الرئيسية</span>
                    </div>
                </a>
                <a href="{{ route('daily.production') }}" class="sidebar-dropdown-item {{ request()->routeIs('daily.production') ? 'active' : '' }}">
                    <div class="flex items-center">
                        <i class="fas fa-industry ml-2"></i>
                        <span class="mr-2">الانتاج اليومي</span>
                    </div>
                </a>
                <a href="{{ route('daily.consumption') }}" class="sidebar-dropdown-item {{ request()->routeIs('daily.consumption') ? 'active' : '' }}">
                    <div class="flex items-center">
                        <i class="fas fa-utensils ml-2"></i>
                        <span class="mr-2">الاستهلاك اليومي</span>
                    </div>
                </a>
            </div>
        </div>

        <!-- قسم الخزينة مع القائمة المنسدلة -->
        <div x-data="{ isOpen: {{ request()->routeIs('treasury.*') ? 'true' : 'false' }} }" class="relative">
            <!-- زر القسم الرئيسي -->
            <button @click="isOpen = !isOpen" class="sidebar-item w-full text-left">
                <div class="flex items-center">
                    <i class="fas fa-piggy-bank ml-2"></i>
                    <span class="mr-2">الخزينة</span>
                </div>
                <div class="flex items-center">
                    <i x-show="!isOpen" class="fas fa-chevron-down text-xs"></i>
                    <i x-show="isOpen" class="fas fa-chevron-up text-xs"></i>
                </div>
            </button>

            <!-- القائمة المنسدلة -->
            <div x-show="isOpen" x-collapse class="sidebar-dropdown">
                <a href="{{ route('treasury.index') }}" class="sidebar-dropdown-item {{ request()->routeIs('treasury.index') ? 'active' : '' }}">
                    <div class="flex items-center">
                        <i class="fas fa-home ml-2"></i>
                        <span class="mr-2">الرئيسية</span>
                    </div>
                </a>
                <a href="{{ route('treasury.income') }}" class="sidebar-dropdown-item {{ request()->routeIs('treasury.income') ? 'active' : '' }}">
                    <div class="flex items-center">
                        <i class="fas fa-money-bill-wave ml-2"></i>
                        <span class="mr-2">ايرادات</span>
                    </div>
                </a>
                <a href="{{ route('treasury.expense') }}" class="sidebar-dropdown-item {{ request()->routeIs('treasury.expense') ? 'active' : '' }}">
                    <div class="flex items-center">
                        <i class="fas fa-receipt ml-2"></i>
                        <span class="mr-2">مصروفات</span>
                    </div>
                </a>
                <a href="{{ route('treasury.liabilities') }}" class="sidebar-dropdown-item {{ request()->routeIs('treasury.liabilities') ? 'active' : '' }}">
                    <div class="flex items-center">
                        <i class="fas fa-hand-holding-usd ml-2"></i>
                        <span class="mr-2">مديونات</span>
                    </div>
                </a>
                <a href="{{ route('treasury.receivables') }}" class="sidebar-dropdown-item {{ request()->routeIs('treasury.receivables') ? 'active' : '' }}">
                    <div class="flex items-center">
                        <i class="fas fa-hand-holding-heart ml-2"></i>
                        <span class="mr-2">تحصيلات</span>
                    </div>
                </a>
                <a href="{{ route('treasury.daily') }}" class="sidebar-dropdown-item {{ request()->routeIs('treasury.daily') ? 'active' : '' }}">
                    <div class="flex items-center">
                        <i class="fas fa-calendar-day ml-2"></i>
                        <span class="mr-2">يومية</span>
                    </div>
                </a>
            </div>
        </div>

        <!-- قسم المخزون مع القائمة المنسدلة -->
        <div x-data="{ isOpen: {{ request()->routeIs('stock.*') ? 'true' : 'false' }} }" class="relative">
            <!-- زر القسم الرئيسي -->
            <button @click="isOpen = !isOpen" class="sidebar-item w-full text-left">
                <div class="flex items-center">
                    <i class="fas fa-boxes ml-2"></i>
                    <span class="mr-2">المخزون</span>
                </div>
                <div class="flex items-center">
                    <i x-show="!isOpen" class="fas fa-chevron-down text-xs"></i>
                    <i x-show="isOpen" class="fas fa-chevron-up text-xs"></i>
                </div>
            </button>

            <!-- القائمة المنسدلة -->
            <div x-show="isOpen" x-collapse class="sidebar-dropdown">
                <a href="{{ route('stock.producs') }}" class="sidebar-dropdown-item {{ request()->routeIs('stock.producs') ? 'active' : '' }}">
                    <div class="flex items-center">
                        <i class="fas fa-box-open ml-2"></i>
                        <span class="mr-2">منتجات</span>
                    </div>
                </a>
                <a href="{{ route('stock.feeds') }}" class="sidebar-dropdown-item {{ request()->routeIs('stock.feeds') ? 'active' : '' }}">
                    <div class="flex items-center">
                        <i class="fas fa-haykal ml-2"></i>
                        <span class="mr-2">اعلاف</span>
                    </div>
                </a>
                <a href="{{ route('stock.other') }}" class="sidebar-dropdown-item {{ request()->routeIs('stock.other') ? 'active' : '' }}">
                    <div class="flex items-center">
                        <i class="fas fa-ellipsis-h ml-2"></i>
                        <span class="mr-2">اخري</span>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Script for micro-interactions -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Click effect
            document.querySelectorAll('.sidebar-item').forEach(item => {
                item.addEventListener('click', function(e) {
                    this.style.transform = 'scale(0.98)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 150);
                });
            });

            // Smooth scroll for sidebar
            const sidebar = document.querySelector('.sidebar');
            sidebar.style.transform = 'translateX(0)';
        });
        document.addEventListener('DOMContentLoaded', function() {
            const menuButton = document.getElementById('mobile-menu-button');
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.createElement('div');

            overlay.className = 'sidebar-overlay';
            document.body.appendChild(overlay);

            menuButton.addEventListener('click', function() {
                sidebar.classList.toggle('open');
                overlay.style.display = sidebar.classList.contains('open') ? 'block' : 'none';
            });

            overlay.addEventListener('click', function() {
                sidebar.classList.remove('open');
                overlay.style.display = 'none';
            });
        });
    </script>
