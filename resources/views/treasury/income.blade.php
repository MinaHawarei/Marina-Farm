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
        <h3 class="text-lg font-bold mb-4">الايرادات : </h3>

        <form method="GET" action="{{ route('treasury.income') }}" class="mb-6">
            <label for="date" class="block text-sm font-medium text-gray-700 mb-1">اختر التاريخ:</label>
            <div class="flex items-center gap-2">
                <h2>من : </h2>
                <input type="date" id="date" name="datefrom"
                       value="{{ request('datefrom') }}"
                       class="border rounded p-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <h2>إلى : </h2>
                <input type="date" id="date" name="dateto"
                       value="{{ request('dateto') }}"
                       class="border rounded p-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    عرض
                </button>
            </div>
        </form>
        <table class="table-auto w-full text-sm border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">رقم العملية</th>
                    <th class="px-4 py-2">الفئة</th>
                    <th class="px-4 py-2">النوع</th>
                    <th class="px-4 py-2">الكمية</th>
                    <th class="px-4 py-2">سعر الوحدة</th>
                    <th class="px-4 py-2">المبلغ الكلي</th>
                    <th class="px-4 py-2">المدفوع</th>
                    <th class="px-4 py-2">المتبقي</th>
                    <th class="px-4 py-2">التاريخ</th>
                    <th class="px-4 py-2">نقطة البيع</th>
                    <th class="px-4 py-2">اسم المشتري</th>
                    <th class="px-4 py-2">كود المشتري</th>
                    <th class="px-4 py-2">الوصف</th>
                    <th class="px-4 py-2">تمت الإضافة بواسطة</th>
                    <th class="px-4 py-2">تعديل</th>
                    <th class="px-4 py-2">حذف</th>
                </tr>
            </thead>
            <tbody>
                    @forelse($income as $item)

                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $item->id }}</td>
                            <td class="px-4 py-2">{{ $item->category }}</td>
                            <td class="px-4 py-2">{{ $item->type }}</td>
                            <td class="px-4 py-2">{{ $item->quantity }}</td>
                            <td class="px-4 py-2">{{ $item->unit_price }}</td>
                            <td class="px-4 py-2">{{ $item->amount }}</td>
                            <td class="px-4 py-2">{{ $item->paid }}</td>
                            <td class="px-4 py-2">{{ $item->remaining }}</td>
                            <td class="px-4 py-2">{{ $item->date }}</td>
                            <td class="px-4 py-2">{{ $item->sales_point }}</td>
                            <td class="px-4 py-2">{{ $item->buyer_name }}</td>
                            <td class="px-4 py-2">{{ $item->buyer_id }}</td>
                            <td class="px-4 py-2">{{ $item->description ?? 'غير محددة' }}</td>
                            <td class="px-4 py-2">{{ $item->created_by }}</td>

                            <td class="px-4 py-2 text-center">
                                <button onclick="openEditForm({{ $item->id }})" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">تعديل</button>
                            </td>
                            <td class="px-4 py-2 text-center">
                                <form action="{{ route('income.destroy', $item->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا السجل؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition duration-200">
                                        حذف
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center text-gray-500 py-4">لا يوجد بيانات</td>
                        </tr>
                    @endforelse

            </tbody>
        </table>



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

                        setTimeout(() => {
                        // تعبئة الحقول
                        document.querySelector('select[name="category"]').value = data.category || '';
                        document.querySelector('input[name="description"]').value = data.description || '';
                        document.querySelector('input[name="date"]').value = (new Date(data.date)).toISOString().split('T')[0];
                        document.querySelector('input[name="payment_due_date"]').value = (new Date(data.payment_due_date)).toISOString().split('T')[0];
                        document.querySelector('input[name="buyer_name"]').value = data.buyer_name || '';
                        document.querySelector('input[name="quantity"]').value = data.quantity || '';
                        document.querySelector('input[name="unit_price"]').value = data.unit_price || '';
                        document.querySelector('input[name="amount"]').value = data.amount || '';
                        document.querySelector('input[name="paid"]').value = data.paid || '';
                        document.querySelector('input[name="remaining"]').value = data.remaining || '';
                        document.querySelector('input[name="buyer_id"]').value = data.buyer_id || '';

                        // أولاً نختار الفئة
                        document.getElementById('income_mainCategory').value = data.category || '';
                        // ثم نطلق الحدث لتحديث التوزيع الفرعي
                        document.getElementById('income_mainCategory').dispatchEvent(new Event('change'));

                        // تأخير بسيط لتضمن تحميل القيم قبل اختيار النوع
                        setTimeout(() => {
                            document.getElementById('income_subCategory').value = data.type || '';

                            // إذا كان النوع "أخرى"، املأ الحقل الخاص به
                            if (data.type === 'Other') {
                                document.getElementById('income_otherSubCategory').value = data.other_type || '';
                                document.getElementById('income_otherSubCategoryContainer').classList.remove('hidden');
                            }
                        }, 100);

                        // تعديل الفورم ليرسل البيانات إلى الرابط الصحيح
                        document.querySelector('#edit-form form').action = `/income/${id}`;
                        }, 150);
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
