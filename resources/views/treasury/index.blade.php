<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('الخزينة') }}
        </h2>
    </x-slot>

    <div class="p-6 space-y-6">
        {{-- نظرة عامة --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-green-100 p-4 rounded shadow">
                <h3 class="text-lg font-bold text-green-800">إجمالي الإيرادات</h3>
                <p class="text-2xl font-semibold mt-2 text-green-700">{{ number_format($total_income) }} ج.م</p>
            </div>
            <div class="bg-red-100 p-4 rounded shadow">
                <h3 class="text-lg font-bold text-red-800">إجمالي المصروفات</h3>
                <p class="text-2xl font-semibold mt-2 text-red-700">{{ number_format($total_expense) }} ج.م</p>
            </div>
            <div class="bg-yellow-100 p-4 rounded shadow">
                <h3 class="text-lg font-bold text-yellow-800">إجمالي المديونيات</h3>
                <p class="text-2xl font-semibold mt-2 text-yellow-700">{{ number_format($total_debt) }} ج.م</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-blue-100 p-4 rounded shadow">
                <h3 class="text-lg font-bold text-blue-800">التحصيلات المتوقعة</h3>
                <p class="text-2xl font-semibold mt-2 text-blue-700">{{ number_format($expected_collections) }} ج.م</p>
            </div>
            <div class="bg-gray-100 p-4 rounded shadow">
                <h3 class="text-lg font-bold text-gray-800">الرصيد الحالي</h3>
                <p class="text-2xl font-semibold mt-2 text-gray-700">{{ number_format($current_balance) }} ج.م</p>
            </div>
        </div>

        {{-- آخر العمليات --}}
        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-lg font-bold mb-4">آخر العمليات</h3>
            <table class="w-full table-auto text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-2 py-1">النوع</th>
                        <th class="px-2 py-1">الوصف</th>
                        <th class="px-2 py-1">المبلغ</th>
                        <th class="px-2 py-1">التاريخ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($latest_transactions as $transaction)
                        <tr class="border-t">
                            <td class="px-2 py-1">{{ $transaction->type }}</td>
                            <td class="px-2 py-1">{{ $transaction->description ?? '-' }}</td>
                            <td class="px-2 py-1">{{ number_format($transaction->amount) }} ج.م</td>
                            <td class="px-2 py-1">{{ $transaction->date }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{-- الرسم البياني للإيرادات والمصروفات --}}
<div class="bg-white p-4 rounded shadow">
    <h3 class="text-lg font-bold mb-4">الإيرادات مقابل المصروفات (شهريًا)</h3>
    <canvas id="financeChart" height="100"></canvas>
</div>
<script>
    const ctx = document.getElementById('financeChart').getContext('2d');

    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(collect($monthly_data)->pluck('month')->map(fn($m) => \Carbon\Carbon::create()->month($m)->format('F'))) !!},
            datasets: [
                {
                    label: 'الإيرادات',
                    data: {!! json_encode(collect($monthly_data)->pluck('income')) !!},
                    backgroundColor: 'rgba(34, 197, 94, 0.7)',
                    borderColor: 'rgba(34, 197, 94, 1)',
                    borderWidth: 1
                },
                {
                    label: 'المصروفات',
                    data: {!! json_encode(collect($monthly_data)->pluck('expense')) !!},
                    backgroundColor: 'rgba(239, 68, 68, 0.7)',
                    borderColor: 'rgba(239, 68, 68, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>


</x-app-layout>
