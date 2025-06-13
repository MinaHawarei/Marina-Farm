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

        <h2 class="text-xl font-bold mb-3 mt-6">إجمالي المبيعات الشهرية حسب الفئة ({{ $month_view }})</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
            @foreach($totalSalesByCategory as $category => $totalAmount)
                <div class="bg-gray-100 p-4 rounded shadow flex flex-col justify-between">
                    <div>
                        <p class="font-semibold">إجمالي {{ $categoryTranslations[$category] ?? $category }}:</p>
                        <p>{{ $totalAmount }}</p>
                    </div>
                    {{-- تم إزالة زر التفاصيل من هنا --}}
                </div>
            @endforeach
            @if($totalSalesByCategory->isEmpty())
                <p class="col-span-full text-gray-600">لا توجد مبيعات لهذا الشهر لعرضها.</p>
            @endif
        </div>

        ---

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
                        <td class="border px-2 py-1 text-center" style="position: relative;">
                            {{ $item->total_amount_daily_category ?? 0 }}
                            {{-- الزرار الجديد لفتح المودال في المبيعات اليومية --}}
                            <button
                                onclick="showDetails('{{ $item->sale_date }}', '{{ $item->category }}')"
                                style="color: blue; position: absolute; left: 5px; top: 50%; transform: translateY(-50%);"
                            >
                                تفاصيل
                            </button>
                        </td>
                    </tr>
                @endforeach
                @if($salesItemsGroupedByDayAndCategory->isEmpty())
                    <tr>
                        <td colspan="4" class="border px-2 py-1 text-gray-600">لا توجد بيانات مبيعات مجمعة لهذا الشهر لعرضها.</td>
                    </tr>
                @endif
            </tbody>
        </table>

        ---

        {{-- قسم الرسم البياني الجديد (مقارنة إجمالي المبيعات الشهرية حسب الفئة) --}}
        <h2 class="text-xl font-bold mb-3 mt-8">مقارنة إجمالي المبيعات الشهرية حسب الفئة</h2>
        <div class="bg-white p-4 rounded shadow">
            <canvas id="monthlySalesCategoryChart" style="max-height: 500px; height: 400px;"></canvas>
        </div>

    </div>

    <div id="DetailsModal" class="fixed inset-0 z-50 bg-black bg-opacity-50 hidden items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white w-full max-w-4xl mx-auto rounded-lg shadow-lg p-6 relative">
            <button onclick="toggleModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
            <h3 class="text-xl font-semibold mb-6 text-center">تفاصيل مبيعات الفئة: <span id="modal-category-name"></span> بتاريخ: <span id="modal-sale-date"></span></h3>
            <table class="table-auto w-full border border-gray-300 text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-right">الكود</th>
                        <th class="px-4 py-2 text-right">المنتج</th>
                        <th class="px-4 py-2 text-right">كود المنتج</th>
                        <th class="px-4 py-2 text-right">الكمية</th>
                        <th class="px-4 py-2 text-right">سعر الوحدة</th>
                        <th class="px-4 py-2 text-right">الاجمالي</th>
                        <th class="px-4 py-2 text-right">ملاحظات</th>
                    </tr>
                </thead>
                <tbody id="DetailsTable"></tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('monthlySalesCategoryChart').getContext('2d');

            var chartLabels = @json($chartLabels);
            var chartData = @json($chartData);
            var allCategoriesForChart = @json($allCategoriesForChart);
            var categoryTranslations = @json($categoryTranslations);

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

            var datasets = allCategoriesForChart.map(function(category, index) {
                var displayLabel = categoryTranslations[category] || category;

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

        function toggleModal() {
            const modal = document.getElementById('DetailsModal');
            modal.classList.toggle('hidden');
        }

        // تم تعديل الدالة showDetails لاستقبال تاريخ البيع والفئة
        function showDetails(saleDate, category) {
            toggleModal();
            const tableBody = document.getElementById('DetailsTable');
            const modalCategoryName = document.getElementById('modal-category-name');
            const modalSaleDate = document.getElementById('modal-sale-date');
            const categoryTranslations = @json($categoryTranslations); // أعد تحميل الترجمات في نطاق الدالة

            // تحديث عنوان المودال باسم الفئة والتاريخ المترجم
            modalCategoryName.textContent = categoryTranslations[category] || category;
            modalSaleDate.textContent = saleDate;


            tableBody.innerHTML = '<tr><td colspan="7" class="text-center">جارٍ التحميل...</td></tr>'; // 7 أعمدة

            // تعديل مسار الـ fetch ليستخدم تاريخ البيع والفئة
            // تأكد أن هذا المسار موجود في ملف routes/web.php ويؤدي إلى دالة في الكونترولر تجلب تفاصيل المبيعات.
            fetch(`/reports/sales/daily-details?sale_date=${encodeURIComponent(saleDate)}&category=${encodeURIComponent(category)}`)
                .then(res => {
                    if (!res.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return res.json();
                })
                .then(data => {
                    tableBody.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(record => {
                            tableBody.innerHTML += `
                                <tr class="border-t">
                                    <td class="px-4 py-2">${record.id}</td>
                                    <td class="px-4 py-2">${record.type}</td>
                                    <td class="px-4 py-2">${record.product_id}</td>
                                    <td class="px-4 py-2">${record.quantity}</td>
                                    <td class="px-4 py-2">${record.unit_price}</td>
                                    <td class="px-4 py-2">${record.amount}</td>
                                    <td class="px-4 py-2">${record.notes ?? '-'}</td>
                                </tr>
                            `;
                        });
                    } else {
                        tableBody.innerHTML = '<tr><td colspan="7" class="text-center text-gray-500">لا توجد بيانات.</td></tr>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching details:', error);
                    tableBody.innerHTML = '<tr><td colspan="7" class="text-center text-red-500">فشل في تحميل البيانات.</td></tr>';
                });
        }

        function closeForm(modalId) {
            const modal = document.getElementById(modalId);
            if (modal && !modal.classList.contains('hidden')) {
                modal.classList.add('hidden');
            }
        }

        const modalIds = ['DetailsModal'];

        function closeAllModals() {
            modalIds.forEach(id => {
                const el = document.getElementById(id);
                if (el && !el.classList.contains('hidden')) {
                    el.classList.add('hidden');
                }
            });
        }

        // إغلاق عند الضغط خارج المودال
        document.addEventListener('mousedown', function (e) {
            modalIds.forEach(id => {
                const modal = document.getElementById(id);
                if (modal && !modal.classList.contains('hidden')) {
                    const content = modal.querySelector('.bg-white');
                    if (content && !content.contains(e.target)) {
                        modal.classList.add('hidden');
                    }
                }
            });
        });

        // إغلاق بزر ESC
        document.addEventListener('keydown', function (e) {
            if (e.key === "Escape") {
                closeAllModals();
            }
        });
    </script>
</x-app-layout>
