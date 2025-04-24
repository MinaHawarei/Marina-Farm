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

        <!-- قسم الأبقار مع القائمة المنسدلة -->
        <div x-data="{ isOpen: {{ request()->routeIs('suppliers.*') ? 'true' : 'false' }} }" class="relative">
            <!-- زر القسم الرئيسي -->
            <button @click="isOpen = !isOpen"
                    class="flex justify-between items-center w-full px-6 py-3 font-bold border-r-4 transition duration-200
                        {{ request()->routeIs('suppliers.*') ? 'bg-gray-100 text-blue-800 border-blue-500' : 'text-gray-600 hover:bg-gray-50' }}">
                <div class="flex items-center">
                    <i class="fas fa-cow ml-2"></i> <!-- تغيير الأيقونة -->
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
                <a href="{{ route('buffalo') }}"
                class="flex justify-between items-center px-6 py-3 font-bold border-r-4 transition duration-200"
                style="{{ request()->routeIs('buffalo') ? 'background-color: #f4f4f4; color: #2c3e50; border-color: transparent; border-radius: 0 15px 15px 0;' : 'color: #cccccc;' }}">
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
                    <span class="mr-2">حلوب</span>
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
                    <span class="mr-2">الابطاش</span>
                </div>
                <span class="bg-blue-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                    {{ $calfBuffaloCount ?? 0 }}

                </span>
                </a>
            </div>
        </div>

        <!-- suppliers -->
        <a href="{{ route('suppliers') }}"
        class="flex justify-between items-center px-6 py-3 font-bold border-r-4 transition duration-200"
        style="{{ request()->routeIs('suppliers') ? 'background-color: #f4f4f4; color: #2c3e50; border-color: transparent; border-radius: 0 15px 15px 0;' : 'color: #cccccc;' }}">
         <div class="flex items-center">
             <i class="fas fa-tachometer-alt ml-2"></i>
             <span class="mr-2">البقر</span>
         </div>
         <span class="bg-blue-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
            20
         </span>
        </a>
    </nav>
</div>
