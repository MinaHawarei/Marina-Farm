<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Tool Schedule') }}
        </h2>
    </x-slot>

    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">جدول الصيانة لشهر : {{$month_view}}</h1>

        <form method="GET" action="{{ route('tools.schedule') }}" class="mb-6">
            <div class="flex items-center gap-2">
                <h2>الشهر:</h2>
                <input type="month" id="month" name="month"
                    value="{{ request('month') }}"
                    class="border rounded p-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    عرض
                </button>
            </div>
        </form>

        <table class="w-full border border-gray-400 text-center bg-white" id="tool-table">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border px-2 py-1">كود</th>
                    <th class="border px-2 py-1">الاسم</th>
                    <th class="border px-2 py-1">الوصف</th>
                    <th class="border px-2 py-1">الفئة</th>
                    <th class="border px-2 py-1">اخر صيانة</th>
                    <th class="border px-2 py-1">معدل الصيانة (شهور)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tools as $tool)
                    <tr>
                        <td class="border px-2 py-1">{{ $tool->id }}</td>
                        <td class="border px-2 py-1">{{ $tool->name }}</td>
                        <td class="border px-2 py-1">{{ $tool->description }}</td>
                        <td class="border px-2 py-1">{{ $tool->category }}</td>
                        <td class="border px-2 py-1">{{ $tool->last_maintenance_at }}</td>
                        <td class="border px-2 py-1">{{ $tool->maintenance_frequency }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
