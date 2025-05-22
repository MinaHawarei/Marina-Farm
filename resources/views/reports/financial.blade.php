<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Financial Report') }}
        </h2>
    </x-slot>

    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">التقارير المالية</h1>

        <form method="GET" action="{{ route('reports.financial') }}" class="mb-6 bg-white p-4 rounded shadow">
            <div class="flex flex-wrap items-center gap-4">
                <div>
                    <label for="report_type" class="block text-sm font-medium text-gray-700">نوع التقرير:</label>
                    <select id="report_type" name="report_type"
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        <option value="monthly" {{ $reportType == 'monthly' ? 'selected' : '' }}>شهري</option>
                        <option value="annual" {{ $reportType == 'annual' ? 'selected' : '' }}>سنوي</option>
                    </select>
                </div>

                <div id="month-selector" class="{{ $reportType == 'monthly' ? '' : 'hidden' }}">
                    <label for="month" class="block text-sm font-medium text-gray-700">الشهر:</label>
                    <input type="month" id="month" name="month"
                        value="{{ $selectedMonth }}"
                        class="mt-1 block w-full border rounded p-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                <div id="year-selector" class="mb-4 {{ $reportType == 'annual' ? '' : 'hidden' }}">
                    <label for="year" class="block text-sm font-medium text-gray-700">السنة:</label>
                    <input type="number" id="year" name="year" min="2000" max="{{ date('Y') + 5 }}"
                           value="{{ $selectedYear }}"
                           class="mt-1 block w-full border rounded p-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition self-end">
                    عرض التقرير
                </button>
                <button type="submit" name="export_excel" value="1"
                   class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition self-end">
                    تصدير Excel
                </button>
            </div>
        </form>

        <h2 class="text-xl font-bold mb-3 mt-6">ملخص التقرير المالي {{ $reportType == 'monthly' ? 'لشهر ' . $selectedMonth : 'لسنة ' . $selectedYear }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="bg-green-100 p-4 rounded shadow">
                <p class="font-semibold text-green-700">إجمالي الإيرادات:</p>
                <p class="text-2xl font-bold text-green-800">{{ number_format($summary['total_revenues'], 2) }}</p>
            </div>
            <div class="bg-red-100 p-4 rounded shadow">
                <p class="font-semibold text-red-700">إجمالي المصروفات:</p>
                <p class="text-2xl font-bold text-red-800">{{ number_format($summary['total_expenses'], 2) }}</p>
            </div>
            <div class="p-4 rounded shadow {{ $summary['net_profit_loss'] >= 0 ? 'bg-blue-100' : 'bg-orange-100' }}">
                <p class="font-semibold {{ $summary['net_profit_loss'] >= 0 ? 'text-blue-700' : 'text-orange-700' }}">الربح / الخسارة الصافية:</p>
                <p class="text-2xl font-bold {{ $summary['net_profit_loss'] >= 0 ? 'text-blue-800' : 'text-orange-800' }}">{{ number_format($summary['net_profit_loss'], 2) }}</p>
            </div>
        </div>

        @if($reportType == 'monthly')
            <h2 class="text-xl font-bold mb-3 mt-6">تفاصيل الإيرادات والمصروفات حسب الفئة</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-4 rounded shadow">
                    <h3 class="text-lg font-semibold mb-2">الإيرادات</h3>
                    <table class="w-full border border-gray-300 text-sm">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border px-2 py-1 text-right">الفئة</th>
                                <th class="border px-2 py-1 text-left">المبلغ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($revenueDetails as $category => $amount)
                                <tr>
                                    <td class="border px-2 py-1 text-right">{{ $categoryTranslations[$category] ?? $category }}</td>
                                    <td class="border px-2 py-1 text-left">{{ number_format($amount, 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="2" class="border px-2 py-1 text-center text-gray-600">لا توجد إيرادات مسجلة.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="bg-white p-4 rounded shadow">
                    <h3 class="text-lg font-semibold mb-2">المصروفات</h3>
                    <table class="w-full border border-gray-300 text-sm">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border px-2 py-1 text-right">الفئة</th>
                                <th class="border px-2 py-1 text-left">المبلغ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($expenseDetails as $category => $amount)
                                <tr>
                                    <td class="border px-2 py-1 text-right">{{ $categoryTranslations[$category] ?? $category }}</td>
                                    <td class="border px-2 py-1 text-left">{{ number_format($amount, 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="2" class="border px-2 py-1 text-center text-gray-600">لا توجد مصروفات مسجلة.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        @if($reportType == 'annual')
            <h2 class="text-xl font-bold mb-3 mt-8">التقرير المالي الشهري التفصيلي لسنة {{ $selectedYear }}</h2>
            <div class="bg-white p-4 rounded shadow mb-8">
                <table class="w-full border border-gray-300 text-center">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border px-2 py-1">الشهر</th>
                            <th class="border px-2 py-1">إجمالي الإيرادات</th>
                            <th class="border px-2 py-1">إجمالي المصروفات</th>
                            <th class="border px-2 py-1">الربح / الخسارة الصافية</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($financialData as $data)
                            <tr>
                                <td class="border px-2 py-1">{{ $data['period'] }}</td>
                                <td class="border px-2 py-1 text-green-700">{{ number_format($data['total_revenues'], 2) }}</td>
                                <td class="border px-2 py-1 text-red-700">{{ number_format($data['total_expenses'], 2) }}</td>
                                <td class="border px-2 py-1 {{ $data['net_profit_loss'] >= 0 ? 'text-blue-700' : 'text-orange-700' }}">
                                    {{ number_format($data['net_profit_loss'], 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="border px-2 py-1 text-center text-gray-600">لا توجد بيانات مالية لهذه السنة.</td></tr>
                        @endforelse
                        <tr class="bg-gray-100 font-semibold">
                            <td class="border px-2 py-1">الإجمالي السنوي</td>
                            <td class="border px-2 py-1 text-green-700">{{ number_format($summary['total_revenues'], 2) }}</td>
                            <td class="border px-2 py-1 text-red-700">{{ number_format($summary['total_expenses'], 2) }}</td>
                            <td class="border px-2 py-1 {{ $summary['net_profit_loss'] >= 0 ? 'text-blue-700' : 'text-orange-700' }}">
                                {{ number_format($summary['net_profit_loss'], 2) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Chart for Annual Report --}}
            <h2 class="text-xl font-bold mb-3 mt-8">الرسم البياني للربح والخسارة السنوية</h2>
            <div class="bg-white p-4 rounded shadow">
                <canvas id="financialChart" style="max-height: 500px; height: 400px;"></canvas>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Logic for report type selector
            const reportTypeSelect = document.getElementById('report_type');
            const monthSelector = document.getElementById('month-selector');
            const yearSelector = document.getElementById('year-selector');

            function toggleSelectors() {
                if (reportTypeSelect.value === 'monthly') {
                    monthSelector.classList.remove('hidden');
                    yearSelector.classList.add('hidden');
                } else {
                    monthSelector.classList.add('hidden');
                    yearSelector.classList.remove('hidden');
                }
            }

            reportTypeSelect.addEventListener('change', toggleSelectors);
            toggleSelectors(); // Set initial state

            // Chart for Annual Report
            const reportType = @json($reportType);
            if (reportType === 'annual') {
                var ctx = document.getElementById('financialChart').getContext('2d');
                var chartLabels = @json($chartLabels);
                var chartRevenues = @json($chartRevenues);
                var chartExpenses = @json($chartExpenses);
                var chartNetProfitLoss = @json($chartNetProfitLoss);

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: chartLabels,
                        datasets: [
                            {
                                label: 'إجمالي الإيرادات',
                                data: chartRevenues,
                                borderColor: 'rgba(75, 192, 192, 1)',
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                fill: true,
                                tension: 0.1
                            },
                            {
                                label: 'إجمالي المصروفات',
                                data: chartExpenses,
                                borderColor: 'rgba(255, 99, 132, 1)',
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                fill: true,
                                tension: 0.1
                            },
                            {
                                label: 'الربح / الخسارة الصافية',
                                data: chartNetProfitLoss,
                                borderColor: 'rgba(54, 162, 235, 1)',
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                fill: true,
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
                                    text: 'المبلغ'
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
                                text: 'تطور الربح والخسارة شهرياً'
                            }
                        },
                        rtl: true
                    }
                });
            }
        });
    </script>
</x-app-layout>
