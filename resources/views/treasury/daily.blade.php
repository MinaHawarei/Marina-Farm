<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="flex-1 overflow-y-auto p-8">
        {{-- رسائل التنبيه --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded">
                <div class="flex justify-between items-center">
                    <p>{{ session('success') }}</p>
                    <button onclick="this.parentElement.parentElement.remove()" class="text-green-700">&times;</button>
                </div>
            </div>
        @endif
        <h3 class="text-lg font-bold mb-4">اليومية : </h3>

        <form method="GET" action="{{ route('treasury.daily') }}" class="mb-6">
            <label for="date" class="block text-sm font-medium text-gray-700 mb-1">اختر التاريخ:</label>
            <div class="flex items-center gap-2">
                <h2>اليوم : </h2>
                <input type="date" id="date" name="date"
                       value="{{ request('date') }}"
                       class="border rounded p-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    عرض
                </button>
            </div>
        </form>



        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-green-100 p-4 rounded shadow">
                <h3 class="text-lg font-bold text-green-800">إجمالي الإيرادات</h3>
                <p class="text-2xl font-semibold mt-2 text-green-700"> {{ number_format($total_income) }} ج.م</p>
            </div>

            <div class="bg-red-100 p-4 rounded shadow">
                <h3 class="text-lg font-bold text-red-800">إجمالي المصروفات</h3>
                <p class="text-2xl font-semibold mt-2 text-red-700"> {{ number_format($total_expense) }} ج.م</p>
            </div>
            <div>
                <table class="table-auto w-full text-sm border border-gray-300 table-fixed m-0 p-0">
                        <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2">رقم العملية</th>
                            <th class="px-4 py-2">الفئة</th>
                            <th class="px-4 py-2">النوع</th>
                            <th class="px-4 py-2">المبلغ</th>
                            <th class="px-4 py-2">المدفوع</th>
                            <th class="px-4 py-2">اجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                            @forelse($income as $item)

                                <tr class="border-t">
                                    <td class="px-4 py-2">{{ $item->id }}</td>
                                    <td class="px-4 py-2">{{ $item->category }}</td>
                                    <td class="px-4 py-2">{{ $item->type }}</td>
                                    <td class="px-4 py-2">{{ $item->amount }}</td>
                                    <td class="px-4 py-2">{{ $item->paid }}</td>

                                    <td class="px-4 py-2 text-center">
                                        <div class="flex space-x-2">
                                            <button onclick="openEditForm({{ $item->id }})" class="bg-blue-600 text-white px-2 py-2 rounded-lg hover:bg-blue-700 flex items-center">
                                                i
                                            </button>

                                            <form action="{{ route('income.destroy', $item->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا السجل؟');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-2 py-2 rounded-lg transition duration-200 flex items-center">
                                                    x
                                                </button>
                                            </form>
                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center text-gray-500 py-4">لا يوجد بيانات</td>
                                </tr>
                            @endforelse

                    </tbody>
                </table>
            </div>
            <div>
                <table class="table-auto w-full text-sm border border-gray-300 table-fixed m-0 p-0">
                        <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2">رقم العملية</th>
                            <th class="px-4 py-2">الفئة</th>
                            <th class="px-4 py-2">النوع</th>
                            <th class="px-4 py-2">المبلغ</th>
                            <th class="px-4 py-2">المدفوع</th>
                            <th class="px-4 py-2">اجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                            @forelse($expense as $item)

                                <tr class="border-t">
                                    <td class="px-4 py-2">{{ $item->id }}</td>
                                    <td class="px-4 py-2">{{ $item->category }}</td>
                                    <td class="px-4 py-2">{{ $item->type }}</td>
                                    <td class="px-4 py-2">{{ $item->amount }}</td>
                                    <td class="px-4 py-2">{{ $item->paid }}</td>

                                    <td class="px-4 py-2 text-center">
                                         <div class="flex space-x-2">
                                            <button onclick="openEditForm({{ $item->id }})" class="bg-blue-600 text-white px-2 py-2 rounded-lg hover:bg-blue-700 flex items-center">
                                                i
                                            </button>

                                            <form action="{{ route('expense.destroy', $item->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا السجل؟');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-2 py-2 rounded-lg transition duration-200 flex items-center">
                                                    x
                                                </button>
                                            </form>
                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center text-gray-500 py-4">لا يوجد بيانات</td>
                                </tr>
                            @endforelse

                    </tbody>
                </table>
            </div>
        </div>


        <!-- كمبونينت تعديل الحيوان -->
        @include('components.edit-income-form',[
            'isVisible' => false,
        ])
    </div>

    <script>

            function openEditForm(id) {
                const modal = document.getElementById('edit-form');

                fetch(`/income/${id}/edit`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('فشل في تحميل بيانات الدخل.');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // إظهار النموذج
                        document.getElementById('edit-form').classList.remove('hidden');

                        // تعبئة الحقول
                        document.querySelector('select[name="category"]').value = data.category;
                        document.querySelector('input[name="description"]').value = data.description;
                        modal.querySelector('input[name="date"]').value = data.date ?? '';
                        modal.querySelector('input[name="payment_due_date"]').value = data.payment_due_date ?? '';
                        document.querySelector('input[name="buyer_name"]').value = data.buyer_name || '';
                        document.querySelector('input[name="quantity"]').value = data.quantity;
                        document.querySelector('input[name="unit_price"]').value = data.unit_price;
                        document.querySelector('input[name="amount"]').value = data.amount;
                        document.querySelector('input[name="paid"]').value = data.paid;
                        document.querySelector('input[name="remaining"]').value = data.remaining;
                        document.querySelector('input[name="buyer_id"]').value = data.buyer_id || '';

                        // أولاً نختار الفئة
                        document.getElementById('income_mainCategory').value = data.category;
                        // ثم نطلق الحدث لتحديث التوزيع الفرعي
                        document.getElementById('income_mainCategory').dispatchEvent(new Event('change'));

                        // تأخير بسيط لتضمن تحميل القيم قبل اختيار النوع
                        setTimeout(() => {
                            document.getElementById('income_subCategory').value = data.type;

                            // إذا كان النوع "أخرى"، املأ الحقل الخاص به
                            if (data.type === 'Other') {
                                document.getElementById('income_otherSubCategory').value = data.other_type || '';
                                document.getElementById('income_otherSubCategoryContainer').classList.remove('hidden');
                            }
                        }, 200);

                        // تعديل الفورم ليرسل البيانات إلى الرابط الصحيح
                        document.querySelector('#edit-form form').action = `/income/${id}`;
                    })
                    .catch(error => {
                        alert(error.message);
                    });
            }




        function closeForm(id) {
            document.getElementById('edit-form').classList.add('hidden');
        }

        // إغلاق عند الضغط خارج المودال
        document.addEventListener('click', function (e) {
            const modal = document.getElementById('edit-form');
            const formBox = modal.querySelector('form');

            if (!modal.classList.contains('hidden') && !formBox.contains(e.target) && !e.target.closest('button')) {
                closeForm();
            }
        });

        // إغلاق بزر ESC
        document.addEventListener('keydown', function (e) {
            if (e.key === "Escape") {
                const modal = document.getElementById('edit-form');
                if (!modal.classList.contains('hidden')) {
                    closeForm();
                }
            }
        });

    </script>
</x-app-layout>
