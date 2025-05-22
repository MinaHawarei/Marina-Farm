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
        <h3 class="text-lg font-bold mb-4">البهائم الجاموس وحالتهم تسمين:</h3>

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

        <!-- كمبونينت تعديل الحيوان -->
        @include('components.animal-edit-form')
    </div>

    <script>
        function toggleModal() {
            const modal = document.getElementById('healthModal');
            modal.classList.toggle('hidden');
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

        // إغلاق عند الضغط خارج المودال
        document.addEventListener('click', function (e) {
            const modal = document.getElementById('edit-form');
            const formBox = modal.querySelector('form');

            if (!modal.classList.contains('hidden') && !formBox.contains(e.target) && !e.target.closest('button[onclick="toggleForm()"]')) {
                toggleForm();
            }
        });

        // إغلاق بزر ESC
        document.addEventListener('keydown', function (e) {
            if (e.key === "Escape") {
                const modal = document.getElementById('edit-form');
                if (!modal.classList.contains('hidden')) {
                    toggleForm();
                }
            }
        });
    </script>
</x-app-layout>
