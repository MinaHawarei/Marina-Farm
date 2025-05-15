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
        <h3 class="text-lg font-bold mb-4">البهائم الابقار وحالتهم حلوب:</h3>
        <div class="flex items-center gap-2">
            <form method="GET" action="{{ route('Cowmilk.index') }}" class="mb-6">
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

            <div class="mb-6 flex items-center gap-4 ">
                <button onclick="milkForm()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    اضافة انتاج الحليب
                </button>
            </div>
        </div>


        <table class="table-auto w-full text-sm border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">الكود</th>
                    <th class="px-4 py-2">السلالة</th>
                    <th class="px-4 py-2">العمر</th>
                    <th class="px-4 py-2">الوزن (كجم)</th>
                    <th class="px-4 py-2">الجنس</th>
                    <th class="px-4 py-2">المنشأ</th>
                    <th class="px-4 py-2">تاريخ الوصول</th>
                    <th class="px-4 py-2">مكان الحظيرة</th>
                    <th class="px-4 py-2">الحالة الصحية</th>
                    <th class="px-4 py-2">اجمالي انتاج اللبن</th>
                    <th class="px-4 py-2">التاريخ الصحي</th>
                    <th class="px-4 py-2">تعديل</th>
                </tr>
            </thead>
            <tbody>
                @forelse($animals as $animal)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $animal->animal_code }}</td>
                        <td class="px-4 py-2">{{ $animal->breed ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $animal->age }}</td>
                        <td class="px-4 py-2">{{ $animal->weight }}</td>
                        <td class="px-4 py-2">{{ $animal->gender }}</td>
                        <td class="px-4 py-2">{{ $animal->origin }}</td>
                        <td class="px-4 py-2">{{ $animal->arrival_date }}</td>
                        <td class="px-4 py-2">{{ $animal->pen_id }}</td>
                        <td class="px-4 py-2">{{ $animal->health_status ?? 'غير محددة' }}</td>
                        <td class="px-4 py-2">{{ $animal->total_milk ?? '0' }}
                            <button onclick="openMilkModal({{ $animal->id }})" class="text-blue-500 underline ml-2">تفاصيل</button>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <button onclick="fetchHealthRecords({{ $animal->id }})" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">عرض</button>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <button onclick="openEditForm({{ $animal->id }})" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">تعديل</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="text-center text-gray-500 py-4">لا توجد بهائم مطابقة</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- مودال عرض التقارير الصحية -->
        <div id="healthModal" class="fixed inset-0 z-50 bg-black bg-opacity-50 hidden items-center justify-center p-4 overflow-y-auto">
            <div class="bg-white w-full max-w-4xl mx-auto rounded-lg shadow-lg p-6 relative">
                <button onclick="toggleModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
                <h3 class="text-xl font-semibold mb-6 text-center">التقارير الصحية</h3>
                <table class="table-auto w-full border border-gray-300 text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2">التاريخ</th>
                            <th class="px-4 py-2">نوع العلاج</th>
                            <th class="px-4 py-2">اسم الطبيب</th>
                            <th class="px-4 py-2">التكلفة</th>
                            <th class="px-4 py-2">ملاحظات</th>
                        </tr>
                    </thead>
                    <tbody id="healthRecordsTable"></tbody>
                </table>
            </div>
        </div>
        <!-- مودال عرض انتاج اللبن -->
        <div id="MilkModal" class="fixed inset-0 z-50 bg-black bg-opacity-50 hidden flex items-center justify-center">
            <div class="bg-white w-full max-w-4xl mx-auto rounded-lg shadow-lg p-6 relative" style="max-height: 80vh; overflow-y:auto;">
                <button onclick="document.getElementById('MilkModal').classList.add('hidden')" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
                <h3 class="text-xl font-semibold mb-6 text-center">انتاج اللبن</h3>
                <table class="table-auto w-full border border-gray-300 text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2">التاريخ</th>
                            <th class="px-4 py-2">انتاج صباحي</th>
                            <th class="px-4 py-2">انتاج مسائي</th>
                            <th class="px-4 py-2">اجمالي الانتاج</th>
                            <th class="px-4 py-2">ملاحظات</th>
                            <th class="px-4 py-2">تعديل</th>
                        </tr>
                    </thead>
                    <tbody id="MilkRecordsTable"></tbody>
                </table>
            </div>
        </div>



        <!-- كمبونينت تعديل الحيوان -->
        @include('components.animal-edit-form')
            {{-- مودال إضافة الحيوان --}}
        @include('components.milk-prodection-form', [
            'modalId' => 'milk-form',
            'title' => 'اضافة انتاج الحليب',
            'action' => route('milk.store'),
            'isVisible' => false,
            'milkRecord' => null, // هذا هو المطلوب لتفادي الخطأ
            'buttonText' => 'إضافة'
        ])


    </div>

    <script>

        function toggleModal() {
            const modal = document.getElementById('healthModal');
            modal.classList.toggle('hidden');
        }
        function milkForm() {
            const modal = document.getElementById('milk-form');
            modal.classList.toggle('hidden');
        }
        function openMilkEditForm() {
            const modal = document.getElementById('edit-milk-form');
            modal.classList.toggle('hidden');
        }

        function openMilkModal(animalId) {
            const modal = document.getElementById('MilkModal');
            modal.classList.remove('hidden');

            const tableBody = document.getElementById('MilkRecordsTable');
            tableBody.innerHTML = '<tr><td colspan="6" class="text-center">جارٍ التحميل...</td></tr>';

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(`/animals/${animalId}/milk-records`)
                .then(res => res.json())
                .then(data => {
                    tableBody.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(record => {
                            const total = (record.morning_milk || 0) + (record.evening_milk || 0);
                            tableBody.innerHTML += `
                                <tr class="border-t">
                                    <td colspan="6">
                                        <div class="block w-full">
                                        <form action="/milk-records/${record.id}" method="POST" class="flex justify-between items-center gap-2">
                                            <input type="hidden" name="_token" value="${csrfToken}">
                                            <input type="hidden" name="_method" value="PUT">

                                            <div class="basis-1/6">
                                                <input type="text" name="date" value="${record.date}" class="w-full p-1 border rounded bg-gray-100" style="max-width: 120px; readonly>
                                            </div>

                                            <!-- كل عنصر هنا ياخد 1/6 -->
                                            <div class="basis-1/6">
                                                <input type="number" name="morning_milk" value="${record.morning_milk || 0}"
                                                    class="w-full p-1 border rounded text-xl font-bold text-center"
                                                    style="max-width: 120px;" step="1">
                                            </div>
                                            <div class="basis-1/6">
                                                <input type="number" name="morning_milk" value="${record.evening_milk || 0}"
                                                    class="w-full p-1 border rounded text-xl font-bold text-center"
                                                    style="max-width: 120px;" step="1">
                                            </div>



                                            <div class="basis-1/6">
                                                <strong class="block w-full p-1 border rounded" style="font-size: 180%;"> ${total}</strong>
                                            </div>

                                            <div class="basis-1/6">
                                                <textarea name="notes" class="w-full p-1 border rounded" placeholder="ملاحظات">${record.notes || ''}</textarea>
                                            </div>

                                            <div class="basis-1/6">
                                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">حفظ</button>
                                            </div>
                                        </form>
                                    </div>

                                    </td>
                                </tr>
                            `;
                        });
                    } else {
                        tableBody.innerHTML = '<tr><td colspan="6" class="text-center text-gray-500">لا يوجد انتاج بعد.</td></tr>';
                    }
                });
        }

        function saveMilkRecord(button, id) {
            const row = button.closest('tr');
            const morning = parseFloat(row.querySelector('[data-field="morning_milk"]').value) || 0;
            const evening = parseFloat(row.querySelector('[data-field="evening_milk"]').value) || 0;
            const notes = row.querySelector('[data-field="notes"]').value;

            const data = {
                id: id,
                morning_milk: morning,
                evening_milk: evening,
                notes: notes
            };

            fetch(`/milk-records/${id}`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('تم التحديث بنجاح!');
                } else {
                    alert('حدث خطأ أثناء التحديث.');
                }
            })
            .catch(() => {
                alert('حدث خطأ في الاتصال بالخادم.');
            });
        }



        function fetchHealthRecords(animalId) {
            toggleModal();
            const tableBody = document.getElementById('healthRecordsTable');
            tableBody.innerHTML = '<tr><td colspan="5" class="text-center">جارٍ التحميل...</td></tr>';
            fetch(`/animals/${animalId}/health-records`)
                .then(res => res.json())
                .then(data => {
                    tableBody.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(record => {
                            tableBody.innerHTML += `
                                <tr class="border-t">
                                    <td class="px-4 py-2">${record.date}</td>
                                    <td class="px-4 py-2">${record.treatment_type}</td>
                                    <td class="px-4 py-2">${record.veterinarian_name}</td>
                                    <td class="px-4 py-2">${record.cost}</td>
                                    <td class="px-4 py-2">${record.notes ?? '-'}</td>
                                </tr>
                            `;
                        });
                    } else {
                        tableBody.innerHTML = '<tr><td colspan="5" class="text-center text-gray-500">لا توجد تقارير صحية.</td></tr>';
                    }
                })
                .catch(() => {
                    tableBody.innerHTML = '<tr><td colspan="5" class="text-center text-red-500">فشل في تحميل البيانات.</td></tr>';
                });
        }

        function openEditForm(animalId) {
            const modal = document.getElementById('edit-form');
            modal.classList.remove('hidden');

            fetch(`/animals/${animalId}/edit`)
                .then(res => res.json())
                .then(data => {
                    modal.querySelector('form').action = `/animals/${animalId}`;
                    modal.querySelector('input[name="animal_code"]').value = data.animal_code;
                    modal.querySelector('select[name="type"]').value = data.type;
                    modal.querySelector('select[name="breed"]').value = data.breed ?? '';
                    modal.querySelector('input[name="age"]').value = data.age;
                    modal.querySelector('input[name="weight"]').value = data.weight;
                    modal.querySelector('select[name="pen_id"]').value = data.pen_id;
                    modal.querySelector('select[name="health_status"]').value = data.health_status ?? '';
                    modal.querySelector('select[name="gender"]').value = data.gender;
                    modal.querySelector('input[name="origin"]').value = data.origin;
                    modal.querySelector('input[name="arrival_date"]').value = data.arrival_date;
                    modal.querySelector('select[name="status"]').value = data.status;
                    modal.querySelector('select[name="insemination_type"]').value = data.insemination_type ?? '';
                })
                .catch(() => {
                    alert('فشل في تحميل بيانات الحيوان.');
                });
                function closeEditForm() {
                    const modal = document.getElementById('edit-form');
                    modal.classList.add('hidden');
                }
        }


        function closeForm(modalId) {
            const modal = document.getElementById(modalId);
            if (modal && !modal.classList.contains('hidden')) {
                modal.classList.add('hidden');
            }
        }

        const modalIds = ['edit-form', 'milk-form', 'healthModal', 'MilkModal'];

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
                    const content = modal.querySelector('.bg-white, form');
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
