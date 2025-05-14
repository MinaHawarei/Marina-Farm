<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="p-6 space-y-6">
        {{-- نظرة عامة --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        </div>

       <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mt-8">

            {{-- برسيم (clover) --}}
            <div class="bg-gradient-to-r from-lime-400 to-lime-600 text-white p-6 rounded-xl shadow-lg text-center transition-transform duration-300 hover:scale-105 hover:shadow-xl"
                style="background-image: linear-gradient(to right, #A3E635, #65A30D);">
                <h3 class="text-xl font-bold">برسيم</h3>
                <p class="text-3xl font-semibold mt-2">{{ number_format($clover_net) }} كيلو</p>
            </div>

            {{-- تبن (hay) --}}
            <div class="bg-gradient-to-r from-amber-400 to-amber-600 text-white p-6 rounded-xl shadow-lg text-center transition-transform duration-300 hover:scale-105 hover:shadow-xl"
                style="background-image: linear-gradient(to right, #FBBF24, #D97706);">
                <h3 class="text-xl font-bold">تبن</h3>
                <p class="text-3xl font-semibold mt-2">{{ number_format($hay_net) }} كيلو</p>
            </div>

            {{-- ذرة (corn) --}}
            <div class="bg-gradient-to-r from-yellow-400 to-yellow-600 text-white p-6 rounded-xl shadow-lg text-center transition-transform duration-300 hover:scale-105 hover:shadow-xl"
                style="background-image: linear-gradient(to right, #FACC15, #CA8A04);">
                <h3 class="text-xl font-bold">ذرة</h3>
                <p class="text-3xl font-semibold mt-2">{{ number_format($corn_net) }} كيلو</p>
            </div>

            {{-- صويا (soybean) --}}
            <div class="bg-gradient-to-r from-emerald-400 to-emerald-600 text-white p-6 rounded-xl shadow-lg text-center transition-transform duration-300 hover:scale-105 hover:shadow-xl"
                style="background-image: linear-gradient(to right, #34D399, #059669);">
                <h3 class="text-xl font-bold">صويا</h3>
                <p class="text-3xl font-semibold mt-2">{{ number_format($soybean_net) }} كيلو</p>
            </div>

            {{-- قشر صويا (soybean_hulls) --}}
            <div class="bg-gradient-to-r from-teal-400 to-teal-600 text-white p-6 rounded-xl shadow-lg text-center transition-transform duration-300 hover:scale-105 hover:shadow-xl"
                style="background-image: linear-gradient(to right, #2DD4BF, #0D9488);">
                <h3 class="text-xl font-bold">قشر صويا</h3>
                <p class="text-3xl font-semibold mt-2">{{ number_format($soybean_hulls_net) }} كيلو</p>
            </div>

            {{-- ردة (bran) --}}
            <div class="bg-gradient-to-r from-stone-400 to-stone-600 text-white p-6 rounded-xl shadow-lg text-center transition-transform duration-300 hover:scale-105 hover:shadow-xl"
                style="background-image: linear-gradient(to right, #A8A29E, #57534E);">
                <h3 class="text-xl font-bold">ردة</h3>
                <p class="text-3xl font-semibold mt-2">{{ number_format($bran_net) }} كيلو</p>
            </div>

            {{-- سيلاج (silage) --}}
            <div class="bg-gradient-to-r from-fuchsia-400 to-fuchsia-600 text-white p-6 rounded-xl shadow-lg text-center transition-transform duration-300 hover:scale-105 hover:shadow-xl"
                style="background-image: linear-gradient(to right, #E879F9, #C026D3);">
                <h3 class="text-xl font-bold">سيلاج</h3>
                <p class="text-3xl font-semibold mt-2">{{ number_format($silage_net) }} كيلو</p>
            </div>

        </div>




    </div>

</x-app-layout>
