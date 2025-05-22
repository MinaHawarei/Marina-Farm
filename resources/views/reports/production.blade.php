<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Tool Management') }}
        </h2>
    </x-slot>

    <div class="p-6">
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded">
                <div class="flex justify-between items-center">
                    <p>{{ session('success') }}</p>
                    <button onclick="this.parentElement.parentElement.remove()" class="text-green-700">&times;</button>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded">
                <div class="flex justify-between items-center">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button onclick="this.parentElement.parentElement.remove()" class="text-red-700">&times;</button>
                </div>
            </div>
        @endif

        <h1 class="text-2xl font-bold mb-4">تقارير الانتاج</h1>
        <form method="GET" action="{{ route('reports.production') }}" class="mb-6">
            <div class="flex items-center gap-2">
                <h2>الشهر:</h2>
                <input type="month" id="month" name="month"
                    value="{{ request('month', $month_view) }}"
                    class="border rounded p-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    عرض
                </button>
            </div>
        </form>

        <div class="flex gap-2 my-4">
            <a href="{{ route('reports.production.export', ['month' => request('month', $month_view)]) }}"
            class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                تصدير Excel
            </a>
        </div>

        {{-- قسم عرض الإجمالي الشهري للشهر المحدد --}}
        <h2 class="text-xl font-bold mb-3 mt-6">إجمالي الإنتاج للشهر المحدد ({{ $month_view }})</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
            <div class="bg-gray-100 p-4 rounded shadow">
                <p class="font-semibold">إجمالي لبن جاموس:</p>
                <p>{{ $totalProduction['buffaloMilk'] }}</p>
            </div>
            <div class="bg-gray-100 p-4 rounded shadow">
                <p class="font-semibold">إجمالي لبن بقري:</p>
                <p>{{ $totalProduction['cowMilk'] }}</p>
            </div>
            <div class="bg-gray-100 p-4 rounded shadow">
                <p class="font-semibold">إجمالي بيض:</p>
                <p>{{ $totalProduction['eggs'] }}</p>
            </div>
            <div class="bg-gray-100 p-4 rounded shadow">
                <p class="font-semibold">إجمالي جبنة:</p>
                <p>{{ $totalProduction['cheese'] }}</p>
            </div>
            <div class="bg-gray-100 p-4 rounded shadow">
                <p class="font-semibold">إجمالي سمنة:</p>
                <p>{{ $totalProduction['ghee'] }}</p>
            </div>
            <div class="bg-gray-100 p-4 rounded shadow">
                <p class="font-semibold">إجمالي بلح:</p>
                <p>{{ $totalProduction['dates'] }}</p>
            </div>
        </div>

        <table class="w-full border border-gray-400 text-center bg-white" id="tool-table">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border px-2 py-1">اليوم</th>
                    <th class="border px-2 py-1">لبن جاموس</th>
                    <th class="border px-2 py-1">لبن بقري</th>
                    <th class="border px-2 py-1">بيض</th>
                    <th class="border px-2 py-1">جبنة</th>
                    <th class="border px-2 py-1">سمنة</th>
                    <th class="border px-2 py-1">بلح</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr>
                        <td class="border px-2 py-1">{{ $item->production_date }}</td>
                        <td class="border px-2 py-1">{{ $item->buffaloMilk }}</td>
                        <td class="border px-2 py-1">{{ $item->cowMilk }}</td>
                        <td class="border px-2 py-1">{{ $item->eggs }}</td>
                        <td class="border px-2 py-1">{{ $item->cheese }}</td>
                        <td class="border px-2 py-1">{{ $item->ghee }}</td>
                        <td class="border px-2 py-1">{{ $item->dates }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- قسم الرسم البياني الجديد (مقارنة الإجمالي الشهري) --}}
        <h2 class="text-xl font-bold mb-3 mt-8">مقارنة إجمالي الإنتاج الشهري</h2>
        <div class="bg-white p-4 rounded shadow">
            <canvas id="monthlyProductionChart" style="max-height: 600px; height: 500px;"></canvas>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('monthlyProductionChart').getContext('2d');

            var chartLabels = @json($chartLabels);
            var chartData = @json($chartData);

            var monthlyProductionChart = new Chart(ctx, {
                type: 'line', // 'bar' لو عايز أعمدة، 'line' للمقارنة الزمنية أفضل
                data: {
                    labels: chartLabels,
                    datasets: [
                        {
                            label: 'إجمالي لبن جاموس',
                            data: chartData.buffaloMilk,
                            borderColor: 'rgba(255, 99, 132, 1)',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            fill: false,
                            tension: 0.1
                        },
                        {
                            label: 'إجمالي لبن بقري',
                            data: chartData.cowMilk,
                            borderColor: 'rgba(54, 162, 235, 1)',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            fill: false,
                            tension: 0.1
                        },
                        {
                            label: 'إجمالي بيض',
                            data: chartData.eggs,
                            borderColor: 'rgba(255, 206, 86, 1)',
                            backgroundColor: 'rgba(255, 206, 86, 0.2)',
                            fill: false,
                            tension: 0.1
                        },
                        {
                            label: 'إجمالي جبنة',
                            data: chartData.cheese,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            fill: false,
                            tension: 0.1
                        },
                        {
                            label: 'إجمالي سمنة',
                            data: chartData.ghee,
                            borderColor: 'rgba(153, 102, 255, 1)',
                            backgroundColor: 'rgba(153, 102, 255, 0.2)',
                            fill: false,
                            tension: 0.1
                        },
                        {
                            label: 'إجمالي بلح',
                            data: chartData.dates,
                            borderColor: 'rgba(255, 159, 64, 1)',
                            backgroundColor: 'rgba(255, 159, 64, 0.2)',
                            fill: false,
                            tension: 0.1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'الكمية الإجمالية'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'الشهر'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                            rtl: true
                        },
                        title: {
                            display: true,
                            text: 'مقارنة إجمالي الإنتاج الشهري لكل صنف'
                        }
                    },
                    rtl: true
                }
            });
        });
    </script>
</x-app-layout>
