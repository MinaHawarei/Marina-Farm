<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="p-6 space-y-6">
        {{-- نظرة عامة --}}

       <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mt-8">

    {{-- بنزين (Gasoline) --}}
    <div class="bg-gradient-to-r from-rose-400 to-rose-600 text-white p-6 rounded-xl shadow-lg text-center transition-transform duration-300 hover:scale-105 hover:shadow-xl"
         style="background-image: linear-gradient(to right, #FB7185, #BE123C);">
        <h3 class="text-xl font-bold">بنزين</h3>
        <p class="text-3xl font-semibold mt-2">{{ number_format($gasoline_net) }} لتر</p>
    </div>

    {{-- سولار (Solar) --}}
    <div class="bg-gradient-to-r from-sky-400 to-sky-600 text-white p-6 rounded-xl shadow-lg text-center transition-transform duration-300 hover:scale-105 hover:shadow-xl"
         style="background-image: linear-gradient(to right, #38BDF8, #0284C7);">
        <h3 class="text-xl font-bold">سولار</h3>
        <p class="text-3xl font-semibold mt-2">{{ number_format($solar_net) }} لتر</p>
    </div>

</div>




    </div>

</x-app-layout>
