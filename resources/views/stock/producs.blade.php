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

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            <div class="bg-gradient-to-r from-green-400 to-green-600 text-white p-6 rounded-xl shadow-lg text-center transition-transform duration-300 hover:scale-105 hover:shadow-xl"
                style="background-image: linear-gradient(to right, #34D399, #059669);">
                <h3 class="text-xl font-bold">لبن جاموس</h3>
                <p class="text-3xl font-semibold mt-2">{{ number_format($Buffalo_Milk_net) }} كيلو</p>
            </div>

            <div class="bg-gradient-to-r from-blue-400 to-blue-600 text-white p-6 rounded-xl shadow-lg text-center transition-transform duration-300 hover:scale-105 hover:shadow-xl"
                style="background-image: linear-gradient(to right, #60A5FA, #2563EB);">
                <h3 class="text-xl font-bold">لبن بقري</h3>
                <p class="text-3xl font-semibold mt-2">{{ number_format($Cow_Milk_net) }} كيلو</p>
            </div>

            <div class="bg-gradient-to-r from-yellow-400 to-yellow-600 text-white p-6 rounded-xl shadow-lg text-center transition-transform duration-300 hover:scale-105 hover:shadow-xl"
                style="background-image: linear-gradient(to right, #FACC15, #CA8A04);">
                <h3 class="text-xl font-bold">بيض</h3>
                <p class="text-3xl font-semibold mt-2">{{ number_format($eggs_net) }} بيضة</p>
            </div>

            <div class="bg-gradient-to-r from-orange-400 to-orange-600 text-white p-6 rounded-xl shadow-lg text-center transition-transform duration-300 hover:scale-105 hover:shadow-xl"
                style="background-image: linear-gradient(to right, #FB923C, #EA580C);">
                <h3 class="text-xl font-bold">بلح</h3>
                <p class="text-3xl font-semibold mt-2">{{ number_format($dates_net) }} كيلو</p>
            </div>

            <div class="bg-gradient-to-r from-purple-400 to-purple-600 text-white p-6 rounded-xl shadow-lg text-center transition-transform duration-300 hover:scale-105 hover:shadow-xl"
                style="background-image: linear-gradient(to right, #C084FC, #7C3AED);">
                <h3 class="text-xl font-bold">جبنة</h3>
                <p class="text-3xl font-semibold mt-2">{{ number_format($cheese_net) }} كيلو</p>
            </div>

            <div class="bg-gradient-to-r from-pink-400 to-pink-600 text-white p-6 rounded-xl shadow-lg text-center transition-transform duration-300 hover:scale-105 hover:shadow-xl"
                style="background-image: linear-gradient(to right, #F472B6, #DB2777);">
                <h3 class="text-xl font-bold">سمنة</h3>
                <p class="text-3xl font-semibold mt-2">{{ number_format($ghee_net) }} كيلو</p>
            </div>
        </div>



    </div>

</x-app-layout>
