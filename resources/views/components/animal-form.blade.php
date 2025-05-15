{{-- AnimalFormComponent.blade.php --}}
<div id="{{ $modalId }}" class="fixed inset-0 z-50 bg-black bg-opacity-50 {{ $isVisible ? '' : 'hidden' }} flex items-center justify-center p-4 overflow-y-auto">
    <div class="bg-white max-w-4xl mx-auto rounded-lg shadow-lg p-6 relative w-3/4">
        <h3 class="text-xl font-semibold text-gray-800 mb-6">{{ $title }}</h3>
        <form action="{{ $formAction }}" method="POST">
            @csrf


            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- العمود الأول --}}
                <div class="space-y-10">
                    <div>
                        <label class="block text-gray-700 mb-1">كود الحيوان <span class="text-red-500">*</span></label>
                        <input type="text" name="animal_code" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-1">النوع <span class="text-red-500">*</span></label>
                        <select name="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-center" required>
                            <option value="">اختر النوع</option>
                            <option value="Buffalo">جاموس</option>
                            <option value="Cow">بقر</option>
                            <option value="Chekeen">دجاج</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-1">السلالة</label>
                        <select name="breed" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-center">
                            <option value="">اختر السلالة</option>
                            <option value="طبيعي">طبيعي</option>
                            <option value="صناعي">صناعي</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-1">العمر (بالسنين) <span class="text-red-500">*</span></label>
                        <input type="number" name="age" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-1">الوزن (كجم) <span class="text-red-500">*</span></label>
                        <input type="number" name="weight" min="0" step="0.1" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-1">الحظيرة <span class="text-red-500">*</span></label>
                        <select name="pen_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-center" required>
                            <option value="">اختر الحظيرة</option>
                            <option value="رضاعة">رضاعة</option>
                            <option value="فطام">فطام</option>
                            <option value="تحت التلقيح">تحت التلقيح</option>
                            <option value="عشار">عشار</option>
                            <option value="انتظار ولادة">انتظار ولادة</option>
                            <option value="حلاب">حلاب</option>
                            <option value="جفاف">جفاف</option>
                            <option value="دجاج">دجاج</option>
                        </select>
                    </div>
                </div>
                {{-- العمود الثاني --}}
                <div class="space-y-10">
                    <div>
                        <label class="block text-gray-700 mb-1">الحالة الصحية</label>
                        <select name="health_status" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-center">
                            <option value="جيدة">جيدة</option>
                            <option value="متوسطة">متوسطة</option>
                            <option value="سيئة">سيئة</option>
                            <option value="تحت العلاج">تحت العلاج</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-1">الجنس <span class="text-red-500">*</span></label>
                        <select name="gender" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-center" required>
                            <option value="">اختر الجنس</option>
                            <option value="ذكر">ذكر</option>
                            <option value="انثي">أنثى</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-1">كود الام (او المورد) <span class="text-red-500">*</span></label>
                        <input type="text" name="origin" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-1">تاريخ الوصول <span class="text-red-500">*</span></label>
                        <input type="date" name="arrival_date" max="{{ date('Y-m-d') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-1">الحالة <span class="text-red-500">*</span></label>
                        <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-center" required>
                            <option value="">اختر الحالة</option>
                            <option value="dairy">حلاب</option>
                            <option value="calf">مواليد</option>
                            <option value="fattening">تسمين</option>
                            <option value="pregnant">عشار</option>
                            <option value="bull">طور</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-1"> -اذا كانت عشار -نوع التلقيح</label>
                        <select name="insemination_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-center">
                            <option value="غير ملقحة">غير ملقحة</option>
                            <option value="طبيعي">طبيعي</option>
                            <option value="صناعي">صناعي</option>
                        </select>
                    </div>
                </div>
            </div>
            {{-- أزرار --}}
            <div class="mt-8 flex justify-end gap-3">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                    حفظ البيانات
                </button>
                @if ($modalId === 'edit-form')
                    <button type="button" onclick="closeForm('{{ $modalId }}')" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">إلغاء</button>
                @else
                    <button type="button" onclick="toggleForm()" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">إلغاء</button>
                @endif
            </div>
        </form>
    </div>
</div>
