<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('إدارة الحيوانات') }}
        </h2>
    </x-slot>

    <div class="flex-1 overflow-y-auto p-8">
        <!-- رسائل التنبيه -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- الزر لإضافة سجل جديد -->
        <div class="mb-8">
            <button onclick="toggleForm()"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:outline-none">
                + إضافة حيوان جديد
            </button>
        </div>

        <!-- فورم إدخال البيانات -->
        <div id="add-form" class="bg-white rounded-lg shadow-md p-6 mb-8 hidden">
            <h3 class="text-xl font-semibold mb-4">إضافة حيوان جديد</h3>
            <form action="{{ route('animals.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- العمود الأول -->
                    <div>
                        <div class="mb-4">
                            <label class="block text-gray-700">كود الحيوان: <span class="text-red-500">*</span></label>
                            <input type="text" name="animal_code" class="border px-4 py-2 rounded-lg w-full" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">النوع: <span class="text-red-500">*</span></label>
                            <select name="type" class="border px-4 py-2 rounded-lg w-full" required>
                                <option value="">اختر النوع</option>
                                <option value="Buffalo">جاموس</option>
                                <option value="Cow">بقر</option>
                                <option value="Chekeen">دجاج</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">السلالة:</label>
                            <select name="breed" class="border px-4 py-2 rounded-lg w-full" required>
                                <option value="">اختر السلالة</option>
                                <option value="Natural">تلقيح طبيعي</option>
                                <option value="Artificial">تلقيح صناعي</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">العمر (بالسنين): <span class="text-red-500">*</span></label>
                            <input type="number" name="age" min="0" class="border px-4 py-2 rounded-lg w-full" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">الوزن (كجم): <span class="text-red-500">*</span></label>
                            <input type="number" step="0.1" name="weight" min="0" class="border px-4 py-2 rounded-lg w-full" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">الحظيرة:</label>
                            <select name="pen_id" class="border px-4 py-2 rounded-lg w-full" required>
                                <option value="">اختر الحظيرة</option>
                                <option value="Lactation">رضاعة</option>
                                <option value="Weaning">فطام</option>
                                <option value="Breeding">تحت التلقيح</option>
                                <option value="Pregnant">عشار</option>
                                <option value="Pre-Calving">انتظار ولادة</option>
                                <option value="dairy">حلاب</option>
                                <option value="Dry-Off">جفاف</option>
                                <option value="chickens">دجاج</option>
                            </select>
                        </div>
                    </div>

                    <!-- العمود الثاني -->
                    <div>
                        <div class="mb-4">
                            <label class="block text-gray-700">الحالة الصحية:</label>
                            <select name="health_status" class="border px-4 py-2 rounded-lg w-full">
                                <option value="Good">جيدة</option>
                                <option value="Moderate">متوسطة</option>
                                <option value="Bad">سيئة</option>
                                <option value="Treatment">تحت العلاج</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">الجنس: <span class="text-red-500">*</span></label>
                            <select name="gender" class="border px-4 py-2 rounded-lg w-full" required>
                                <option value="">اختر الجنس</option>
                                <option value="Male">ذكر</option>
                                <option value="Female">أنثى</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">المنشأ(المورد): <span class="text-red-500">*</span></label>
                            <input type="text" name="origin" class="border px-4 py-2 rounded-lg w-full" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">تاريخ الوصول: <span class="text-red-500">*</span></label>
                            <input type="date" name="arrival_date" max="{{ date('Y-m-d') }}" class="border px-4 py-2 rounded-lg w-full" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">الحالة: <span class="text-red-500">*</span></label>
                            <select name="status" class="border px-4 py-2 rounded-lg w-full" required>
                                <option value="">اختر الحالة</option>
                                <option value="dairy">حلوب</option>
                                <option value="calf">بطش</option>
                                <option value="fattening">تسمين</option>
                                <option value="pregnant">عشار</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">نوع التلقيح: <span class="text-red-500">*</span></label>
                            <select name="insemination_type" class="border px-4 py-2 rounded-lg w-full" required>
                                <option value="">اختر نوع التلقيح</option>
                                <option value="Natural">تلقيح طبيعي</option>
                                <option value="Artificial">تلقيح صناعي</option>
                                <option value="Not Insemination">غير ملقح</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                        حفظ البيانات
                    </button>
                    <button type="button" onclick="toggleForm()" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 ml-2">
                        إلغاء
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleForm() {
            const form = document.getElementById('add-form');
            form.classList.toggle('hidden');
        }
    </script>
</x-app-layout>
