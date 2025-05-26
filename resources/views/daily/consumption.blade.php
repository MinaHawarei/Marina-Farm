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
        <h3 class="text-lg font-bold mb-4">الاستهلاك اليومي : </h3>

        <form method="GET" action="{{ route('daily.consumption') }}" class="mb-6">
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
                    <th class="px-4 py-2">اليوم</th>
                    <th class="px-4 py-2">تبن</th>
                    <th class="px-4 py-2">برسيم</th>
                    <th class="px-4 py-2">ذرة</th>
                    <th class="px-4 py-2">صويا</th>
                    <th class="px-4 py-2">قشر صويا</th>
                    <th class="px-4 py-2">ردة</th>
                    <th class="px-4 py-2">سيلاج</th>
                    <th class="px-4 py-2">بنزين</th>
                    <th class="px-4 py-2">سولار</th>
                    <th class="px-4 py-2">تمت الاضافة بواسطة</th>
                    <th class="px-4 py-2">ملاحظات</th>
                    <th class="px-4 py-2">تعديل</th>
                    <th class="px-4 py-2">حذف</th>
                </tr>
            </thead>
            <tbody>
                    @forelse($daily_consumption as $production)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $production->consumptions_date }}</td>
                            <td class="px-4 py-2">{{ $production->hay }}</td>
                            <td class="px-4 py-2">{{ $production->clover }}</td>
                            <td class="px-4 py-2">{{ $production->corn }}</td>
                            <td class="px-4 py-2">{{ $production->soybean }}</td>
                            <td class="px-4 py-2">{{ $production->soybean_hulls }}</td>
                            <td class="px-4 py-2">{{ $production->bran }}</td>
                            <td class="px-4 py-2">{{ $production->silage }}</td>
                            <td class="px-4 py-2">{{ $production->gasoline }}</td>
                            <td class="px-4 py-2">{{ $production->solar }}</td>
                            <td class="px-4 py-2">{{ $production->created_by }}</td>
                            <td class="px-4 py-2">{{ $production->notes ?? 'غير محددة' }}</td>
                            <td class="px-4 py-2 text-center">
                                <button onclick="openEditForm({{ $production->id }})" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">تعديل</button>
                            </td>
                            <td class="px-4 py-2 text-center">
                                <form action="{{ route('daily-consumption.destroy', $production->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا السجل؟');">
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
        @include('components.edit-daily-consumptions-form')
    </div>

    <script>
        function toggleModal() {
            const modal = document.getElementById('healthModal');
            modal.classList.toggle('hidden');
        }

        function openEditForm(Id) {

            const modal = document.getElementById('edit-form');
            modal.classList.remove('hidden');


            fetch(`/daily/consumption/${Id}/edit`)
            .then(res => res.json())
                .then(data => {
                    modal.querySelector('form').action = `/daily/consumption/${Id}`;
                    modal.querySelector('input[name="hay"]').value = data.hay;
                    modal.querySelector('input[name="clover"]').value = data.clover;
                    modal.querySelector('input[name="consumptions_date"]').value = data.consumptions_date ;
                    modal.querySelector('input[name="corn"]').value = data.corn;
                    modal.querySelector('input[name="soybean"]').value = data.soybean;
                    modal.querySelector('input[name="soybean_hulls"]').value = data.soybean_hulls;
                    modal.querySelector('input[name="bran"]').value = data.bran;
                    modal.querySelector('input[name="silage"]').value = data.silage;
                    modal.querySelector('input[name="gasoline"]').value = data.gasoline;
                    modal.querySelector('input[name="solar"]').value = data.solar;
                    modal.querySelector('input[name="notes"]').value = data.notes ?? '';

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
