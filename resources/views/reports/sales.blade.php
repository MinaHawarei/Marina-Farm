<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Sales Report by Category') }}
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

        <h1 class="text-2xl font-bold mb-4">تقارير المبيعات (حسب الفئة)</h1>
        <form method="GET" action="{{ route('reports.sales') }}" class="mb-6">
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
            <a href="{{ route('reports.sales.export', ['month' => request('month', $month_view)]) }}"
            class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                تصدير Excel
            </a>
        </div>

        {{-- قسم عرض الإجمالي الشهري للمبيعات حسب الفئة (Category) --}}
        <h2 class="text-xl font-bold mb-3 mt-6">إجمالي المبيعات الشهرية حسب الفئة ({{ $month_view }})</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
            @foreach($totalSalesByCategory as $category => $totalAmount)
                <div class="bg-gray-100 p-4 rounded shadow">
                    {{-- استخدام categoryTranslations لعرض الاسم العربي للفئة --}}
                    <p class="font-semibold">إجمالي {{ $categoryTranslations[$category] ?? $category }}:</p>
                    <p>{{ $totalAmount }}</p>
                </div>
            @endforeach
            @if($totalSalesByCategory->isEmpty())
                <p class="col-span-full text-gray-600">لا توجد مبيعات لهذا الشهر لعرضها.</p>
            @endif
        </div>

        <table class="w-full border border-gray-400 text-center bg-white" id="sales-category-table">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border px-2 py-1">التاريخ</th>
                    <th class="border px-2 py-1">الفئة</th>
                    <th class="border px-2 py-1">إجمالي المبلغ</th>
                </tr>
            </thead>
            <tbody>
                @foreach($salesItemsGroupedByDayAndCategory as $item)
                    <tr>
                        <td class="border px-2 py-1">{{ $item->sale_date }}</td>
                        {{-- استخدام categoryTranslations لعرض الاسم العربي للفئة --}}
                        <td class="border px-2 py-1">{{ $categoryTranslations[$item->category] ?? $item->category }}</td>
                        <td class="border px-2 py-1">{{ $item->total_amount_daily_category ?? 0 }}</td>
                    </tr>
                @endforeach
                @if($salesItemsGroupedByDayAndCategory->isEmpty())
                    <tr>
                        <td colspan="4" class="border px-2 py-1 text-gray-600">لا توجد بيانات مبيعات مجمعة لهذا الشهر لعرضها.</td>
                    </tr>
                @endif
            </tbody>
        </table>

        {{-- قسم الرسم البياني الجديد (مقارنة إجمالي المبيعات الشهرية حسب الفئة) --}}
        <h2 class="text-xl font-bold mb-3 mt-8">مقارنة إجمالي المبيعات الشهرية حسب الفئة</h2>
        <div class="bg-white p-4 rounded shadow">
            <canvas id="monthlySalesCategoryChart" style="max-height: 500px; height: 400px;"></canvas>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('monthlySalesCategoryChart').getContext('2d');

            var chartLabels = @json($chartLabels);
            var chartData = @json($chartData);
            var allCategoriesForChart = @json($allCategoriesForChart);
            var categoryTranslations = @json($categoryTranslations); // استقبال الترجمة

            var colors = [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(199, 199, 199, 1)',
                'rgba(83, 102, 255, 1)',
                'rgba(231, 233, 237, 1)'
            ];
            var backgroundColors = [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(199, 199, 199, 0.2)',
                'rgba(83, 102, 255, 0.2)',
                'rgba(231, 233, 237, 0.2)'
            ];

            // بناء الـ datasets ديناميكياً لكل category
            var datasets = allCategoriesForChart.map(function(category, index) {
                var displayLabel = categoryTranslations[category] || category; // استخدام الترجمة

                return {
                    label: 'إجمالي ' + displayLabel,
                    data: chartData[category] || [],
                    borderColor: colors[index % colors.length],
                    backgroundColor: backgroundColors[index % backgroundColors.length],
                    fill: false,
                    tension: 0.1
                };
            });

            var monthlySalesCategoryChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartLabels,
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'المبلغ الإجمالي (بالجنيه)'
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
                            text: 'مقارنة إجمالي المبيعات الشهرية حسب الفئة'
                        }
                    },
                    rtl: true
                }
            });
        });
    </script>
</x-app-layout>
