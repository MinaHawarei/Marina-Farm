<!-- Sidebar -->
<div class="w-64" style="background-color: #040629;"> <!-- لون خلفية القائمة -->

        <!-- رابط الرئيسية -->
        <a href="{{ route('dashboard') }}"
        class="flex justify-between items-center px-6 py-3 font-bold border-r-4 transition duration-200"
        style="{{ request()->routeIs('dashboard') ? 'background-color: #f4f4f4; color: #2c3e50; border-color: transparent; border-radius: 0 15px 15px 0;' : 'color: #cccccc;' }}">
         <div class="flex items-center">
             <i class="fas fa-tachometer-alt ml-2"></i>
             <span class="mr-2">الرئيسية</span>
         </div>
        </a>

        <!-- قسم الجاموس مع القائمة المنسدلة -->
        <div x-data="{ isOpen: {{ request()->routeIs('buffalo.*') ? 'true' : 'false' }} }" class="relative">
            <!-- زر القسم الرئيسي -->
            <button @click="isOpen = !isOpen"
            class="flex justify-between items-center w-full px-6 py-3 font-bold border-r-4 transition duration-200
                {{ request()->routeIs('suppliers.*') ? 'bg-gray-100 text-blue-800 border-blue-500' : 'text-white hover:text-blue-800' }}">
                <div class="flex items-center">
                    <i class="fas fa-cow ml-2"></i>
                    <span class="mr-2">الجاموس</span>
                </div>
                <div class="flex items-center">
                    <span class="bg-blue-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center mr-2">
                        {{ $sidebarBuffaloCount ?? 0 }}
                    </span>
                    <i x-show="!isOpen" class="fas fa-chevron-down text-xs"></i>
                    <i x-show="isOpen" class="fas fa-chevron-up text-xs"></i>
                </div>
            </button>

            <!-- القائمة المنسدلة -->
            <div x-show="isOpen" x-collapse class="pr-6" style="background-color: #040629;"
            >
                <a href="{{ route('buffalo.index') }}"
                class="flex justify-between items-center px-6 py-3 font-bold border-r-4 transition duration-200"
                style="{{ request()->routeIs('buffalo.index') ? 'background-color: #f4f4f4; color: #2c3e50; border-color: transparent; border-radius: 0 15px 15px 0;' : 'color: #cccccc;' }}">
                <div class="flex items-center">
                    <i class="fas fa-tachometer-alt ml-2"></i>
                    <span class="mr-2">الرئيسية</span>
                </div>
                <span class="bg-blue-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                    {{ $sidebarBuffaloCount ?? 0 }}
                </span>
                </a>
                <a href="{{ route('buffalo.pregnant') }}"
                class="flex justify-between items-center px-6 py-3 font-bold border-r-4 transition duration-200"
                style="{{ request()->routeIs('buffalo.pregnant') ? 'background-color: #f4f4f4; color: #2c3e50; border-color: transparent; border-radius: 0 15px 15px 0;' : 'color: #cccccc;' }}">
                <div class="flex items-center">
                    <i class="fas fa-tachometer-alt ml-2"></i>
                    <span class="mr-2">عشار</span>
                </div>
                <span class="bg-blue-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                    {{ $pregnantBuffaloCount ?? 0 }}
                </span>
                </a>
                <a href="{{ route('buffalo.dairy') }}"
                class="flex justify-between items-center px-6 py-3 font-bold border-r-4 transition duration-200"
                style="{{ request()->routeIs('buffalo.dairy') ? 'background-color: #f4f4f4; color: #2c3e50; border-color: transparent; border-radius: 0 15px 15px 0;' : 'color: #cccccc;' }}">
                <div class="flex items-center">
                    <i class="fas fa-tachometer-alt ml-2"></i>
                    <span class="mr-2">حلاب</span>
                </div>
                <span class="bg-blue-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                    {{ $dairyBuffaloCount ?? 0 }}
                </span>
                </a>
                <a href="{{ route('buffalo.fattening') }}"
                class="flex justify-between items-center px-6 py-3 font-bold border-r-4 transition duration-200"
                style="{{ request()->routeIs('buffalo.fattening') ? 'background-color: #f4f4f4; color: #2c3e50; border-color: transparent; border-radius: 0 15px 15px 0;' : 'color: #cccccc;' }}">
                <div class="flex items-center">
                    <i class="fas fa-tachometer-alt ml-2"></i>
                    <span class="mr-2">تسمين</span>
                </div>
                <span class="bg-blue-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                    {{ $fatteningBuffaloCount ?? 0 }}

                </span>
                </a>
                <a href="{{ route('buffalo.calf') }}"
                class="flex justify-between items-center px-6 py-3 font-bold border-r-4 transition duration-200"
                style="{{ request()->routeIs('buffalo.calf') ? 'background-color: #f4f4f4; color: #2c3e50; border-color: transparent; border-radius: 0 15px 15px 0;' : 'color: #cccccc;' }}">
                <div class="flex items-center">
                    <i class="fas fa-tachometer-alt ml-2"></i>
                    <span class="mr-2">مواليد</span>
                </div>
                <span class="bg-blue-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                    {{ $calfBuffaloCount ?? 0 }}

                </span>
                </a>
            </div>
        </div>
        <!-- قسم الابقار مع القائمة المنسدلة -->
        <div x-data="{ isOpen: {{ request()->routeIs('cow.*') ? 'true' : 'false' }} }" class="relative">
            <!-- زر القسم الرئيسي -->
            <button @click="isOpen = !isOpen"
            class="flex justify-between items-center w-full px-6 py-3 font-bold border-r-4 transition duration-200
                {{ request()->routeIs('suppliers.*') ? 'bg-gray-100 text-blue-800 border-blue-500' : 'text-white hover:text-blue-800' }}">
                <div class="flex items-center">
                    <i class="fas fa-cow ml-2"></i>
                    <span class="mr-2">الابقار</span>
                </div>
                <div class="flex items-center">
                    <span class="bg-blue-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center mr-2">
                        {{ $cowCount ?? 0 }}
                    </span>
                    <i x-show="!isOpen" class="fas fa-chevron-down text-xs"></i>
                    <i x-show="isOpen" class="fas fa-chevron-up text-xs"></i>
                </div>
            </button>

            <!-- القائمة المنسدلة -->
            <div x-show="isOpen" x-collapse class="pr-6" style="background-color: #040629;"
            >
                <a href="{{ route('cow.index') }}"
                class="flex justify-between items-center px-6 py-3 font-bold border-r-4 transition duration-200"
                style="{{ request()->routeIs('cow.index') ? 'background-color: #f4f4f4; color: #2c3e50; border-color: transparent; border-radius: 0 15px 15px 0;' : 'color: #cccccc;' }}">
                <div class="flex items-center">
                    <i class="fas fa-tachometer-alt ml-2"></i>
                    <span class="mr-2">الرئيسية</span>
                </div>
                <span class="bg-blue-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                    {{ $cowCount ?? 0 }}
                </span>
                </a>
                <a href="{{ route('cow.pregnant') }}"
                class="flex justify-between items-center px-6 py-3 font-bold border-r-4 transition duration-200"
                style="{{ request()->routeIs('cow.pregnant') ? 'background-color: #f4f4f4; color: #2c3e50; border-color: transparent; border-radius: 0 15px 15px 0;' : 'color: #cccccc;' }}">
                <div class="flex items-center">
                    <i class="fas fa-tachometer-alt ml-2"></i>
                    <span class="mr-2">عشار</span>
                </div>
                <span class="bg-blue-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                    {{ $pregnantCow ?? 0 }}
                </span>
                </a>
                <a href="{{ route('cow.dairy') }}"
                class="flex justify-between items-center px-6 py-3 font-bold border-r-4 transition duration-200"
                style="{{ request()->routeIs('cow.dairy') ? 'background-color: #f4f4f4; color: #2c3e50; border-color: transparent; border-radius: 0 15px 15px 0;' : 'color: #cccccc;' }}">
                <div class="flex items-center">
                    <i class="fas fa-tachometer-alt ml-2"></i>
                    <span class="mr-2">حلاب</span>
                </div>
                <span class="bg-blue-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                    {{ $dairyCow ?? 0 }}
                </span>
                </a>
                <a href="{{ route('cow.fattening') }}"
                class="flex justify-between items-center px-6 py-3 font-bold border-r-4 transition duration-200"
                style="{{ request()->routeIs('cow.fattening') ? 'background-color: #f4f4f4; color: #2c3e50; border-color: transparent; border-radius: 0 15px 15px 0;' : 'color: #cccccc;' }}">
                <div class="flex items-center">
                    <i class="fas fa-tachometer-alt ml-2"></i>
                    <span class="mr-2">تسمين</span>
                </div>
                <span class="bg-blue-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                    {{ $fatteningCow ?? 0 }}

                </span>
                </a>
                <a href="{{ route('cow.calf') }}"
                class="flex justify-between items-center px-6 py-3 font-bold border-r-4 transition duration-200"
                style="{{ request()->routeIs('cow.calf') ? 'background-color: #f4f4f4; color: #2c3e50; border-color: transparent; border-radius: 0 15px 15px 0;' : 'color: #cccccc;' }}">
                <div class="flex items-center">
                    <i class="fas fa-tachometer-alt ml-2"></i>
                    <span class="mr-2">مواليد</span>
                </div>
                <span class="bg-blue-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                    {{ $calfCow ?? 0 }}

                </span>
                </a>
            </div>
        </div>

        <!-- قسم اليومية مع القائمة المنسدلة -->
        <div x-data="{ isOpen: {{ request()->routeIs('daily.*') ? 'true' : 'false' }} }" class="relative">
            <!-- زر القسم الرئيسي -->
            <button @click="isOpen = !isOpen"
            class="flex justify-between items-center w-full px-6 py-3 font-bold border-r-4 transition duration-200
                {{ request()->routeIs('suppliers.*') ? 'bg-gray-100 text-blue-800 border-blue-500' : 'text-white hover:text-blue-800' }}">
                <div class="flex items-center">
                    <i class="fas fa-cow ml-2"></i>
                    <span class="mr-2">اليومية</span>
                </div>
                <div class="flex items-center">
                    <i x-show="!isOpen" class="fas fa-chevron-down text-xs"></i>
                    <i x-show="isOpen" class="fas fa-chevron-up text-xs"></i>
                </div>
            </button>

            <!-- القائمة المنسدلة -->
            <div x-show="isOpen" x-collapse class="pr-6" style="background-color: #040629;"
            >
                <a href="{{ route('daily.index') }}"
                    class="flex justify-between items-center px-6 py-3 font-bold border-r-4 transition duration-200"
                    style="{{ request()->routeIs('cow.index') ? 'background-color: #f4f4f4; color: #2c3e50; border-color: transparent; border-radius: 0 15px 15px 0;' : 'color: #cccccc;' }}">
                    <div class="flex items-center">
                        <i class="fas fa-tachometer-alt ml-2"></i>
                        <span class="mr-2">الرئيسية</span>
                    </div>

                </a>
                    <a href="{{ route('daily.production') }}"
                    class="flex justify-between items-center px-6 py-3 font-bold border-r-4 transition duration-200"
                    style="{{ request()->routeIs('daily.production') ? 'background-color: #f4f4f4; color: #2c3e50; border-color: transparent; border-radius: 0 15px 15px 0;' : 'color: #cccccc;' }}">
                    <div class="flex items-center">
                        <i class="fas fa-tachometer-alt ml-2"></i>
                        <span class="mr-2">الانتاج اليومي</span>
                    </div>

                </a>
                <a href="{{ route('daily.consumption') }}"
                    class="flex justify-between items-center px-6 py-3 font-bold border-r-4 transition duration-200"
                    style="{{ request()->routeIs('daily.consumption') ? 'background-color: #f4f4f4; color: #2c3e50; border-color: transparent; border-radius: 0 15px 15px 0;' : 'color: #cccccc;' }}">
                    <div class="flex items-center">
                        <i class="fas fa-tachometer-alt ml-2"></i>
                        <span class="mr-2">الاستهلاك اليومي</span>
                    </div>

                </a>

            </div>
        </div>
        <!-- قسم الخزينة مع القائمة المنسدلة -->
        <div x-data="{ isOpen: {{ request()->routeIs('treasury.*') ? 'true' : 'false' }} }" class="relative">
            <!-- زر القسم الرئيسي -->
            <button @click="isOpen = !isOpen"
            class="flex justify-between items-center w-full px-6 py-3 font-bold border-r-4 transition duration-200
                {{ request()->routeIs('suppliers.*') ? 'bg-gray-100 text-blue-800 border-blue-500' : 'text-white hover:text-blue-800' }}">
                <div class="flex items-center">
                    <i class="fas fa-cow ml-2"></i>
                    <span class="mr-2">الخزينة</span>
                </div>
                <div class="flex items-center">
                    <i x-show="!isOpen" class="fas fa-chevron-down text-xs"></i>
                    <i x-show="isOpen" class="fas fa-chevron-up text-xs"></i>
                </div>
            </button>

            <!-- القائمة المنسدلة -->
            <div x-show="isOpen" x-collapse class="pr-6" style="background-color: #040629;"
            >
                <a href="{{ route('treasury.index') }}"
                    class="flex justify-between items-center px-6 py-3 font-bold border-r-4 transition duration-200"
                    style="{{ request()->routeIs('treasury.index') ? 'background-color: #f4f4f4; color: #2c3e50; border-color: transparent; border-radius: 0 15px 15px 0;' : 'color: #cccccc;' }}">
                    <div class="flex items-center">
                        <i class="fas fa-tachometer-alt ml-2"></i>
                        <span class="mr-2">الرئيسية</span>
                    </div>

                </a>
                    <a href="{{ route('treasury.expense') }}"
                    class="flex justify-between items-center px-6 py-3 font-bold border-r-4 transition duration-200"
                    style="{{ request()->routeIs('treasury.expense') ? 'background-color: #f4f4f4; color: #2c3e50; border-color: transparent; border-radius: 0 15px 15px 0;' : 'color: #cccccc;' }}">
                    <div class="flex items-center">
                        <i class="fas fa-tachometer-alt ml-2"></i>
                        <span class="mr-2">مصروفات</span>
                    </div>

                </a>
                <a href="{{ route('treasury.income') }}"
                    class="flex justify-between items-center px-6 py-3 font-bold border-r-4 transition duration-200"
                    style="{{ request()->routeIs('treasury.income') ? 'background-color: #f4f4f4; color: #2c3e50; border-color: transparent; border-radius: 0 15px 15px 0;' : 'color: #cccccc;' }}">
                    <div class="flex items-center">
                        <i class="fas fa-tachometer-alt ml-2"></i>
                        <span class="mr-2">ايرادات</span>
                    </div>
                </a>
                <a href="{{ route('daily.consumption') }}"
                    class="flex justify-between items-center px-6 py-3 font-bold border-r-4 transition duration-200"
                    style="{{ request()->routeIs('daily.consumption') ? 'background-color: #f4f4f4; color: #2c3e50; border-color: transparent; border-radius: 0 15px 15px 0;' : 'color: #cccccc;' }}">
                    <div class="flex items-center">
                        <i class="fas fa-tachometer-alt ml-2"></i>
                        <span class="mr-2">مديونات</span>
                    </div>
                </a>
                <a href="{{ route('daily.consumption') }}"
                    class="flex justify-between items-center px-6 py-3 font-bold border-r-4 transition duration-200"
                    style="{{ request()->routeIs('daily.consumption') ? 'background-color: #f4f4f4; color: #2c3e50; border-color: transparent; border-radius: 0 15px 15px 0;' : 'color: #cccccc;' }}">
                    <div class="flex items-center">
                        <i class="fas fa-tachometer-alt ml-2"></i>
                        <span class="mr-2">تحصيلات</span>
                    </div>
                </a>

            </div>
        </div>


    </nav>
</div>
