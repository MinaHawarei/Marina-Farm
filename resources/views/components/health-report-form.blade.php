<div id="health-form" class="fixed inset-0 z-50 bg-black bg-opacity-50 {{ $isVisible ? '' : 'hidden' }} flex items-center justify-center p-4 overflow-y-auto">
    <div class="bg-white max-w-4xl mx-auto rounded-lg shadow-lg p-6 relative w-3/4">
        <h3 class="text-xl font-semibold text-gray-800 mb-6">إضافة تقرير صحي</h3>

        <form action="{{ route('health.store') }}" method="POST" id="health_form">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- نوع العلاج --}}
                <div>
                    <label class="block text-gray-700 mb-1">نوع العلاج<span class="text-red-500">*</span></label>
                    <select name="treatment_type" id="treatment_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-center" required>
                        <option value="">اختر نوع العلاج</option>
                        <option value="فحص دوري">فحص دوري</option>
                        <option value="علاج إصابة">علاج إصابة</option>
                        <option value="تطعيم عام">تطعيم عام</option>
                        <option value="تطعيم خاص">تطعيم خاص</option>
                    </select>
                </div>

                {{-- التاريخ --}}
                <div>
                    <label class="block text-gray-700 mb-1">التاريخ<span class="text-red-500">*</span></label>
                    <input type="date" name="date" max="{{ date('Y-m-d') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                </div>

                {{-- حقل اختيار الحيوان أو النوع --}}
                <div id="animal_id_container">
                    <label class="block text-gray-700 mb-1">الحيوان<span class="text-red-500">*</span></label>
                    <select name="animal_id" id="animal_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-center">
                        <option value="">اختر الحيوان</option>
                        @foreach($animals as $animal)
                            <option value="{{ $animal->id }}">{{ $animal->type }} - {{ $animal->animal_code }}</option>
                        @endforeach
                    </select>
                </div>

                <div id="animal_type_container" class="hidden">
                    <label class="block text-gray-700 mb-1">نوع الحيوان<span class="text-red-500">*</span></label>
                    <select name="animal_type" id="animal_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-center">
                        <option value="">اختر النوع</option>
                        <option value="Buffalo">جاموس</option>
                        <option value="Cow">بقر</option>
                        <option value="Chicken">دجاج</option>
                    </select>
                </div>

                {{-- اسم الطبيب البيطري --}}
                <div>
                    <label class="block text-gray-700 mb-1">اسم الطبيب البيطري</label>
                    <input type="text" name="veterinarian_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>



                {{-- ملاحظات --}}
                <div class="md:col-span-2">
                    <label class="block text-gray-700 mb-1">تفاصيل</label>
                    <textarea name="notes" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg"></textarea>
                </div>
            </div>

            {{-- أزرار --}}
            <div class="mt-8 flex justify-end gap-3">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                    اضافة
                </button>
                <button type="button" onclick="toggleHealthForm()" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">إلغاء</button>
            </div>
        </form>
    </div>
</div>

<script>
    const treatmentType = document.getElementById('treatment_type');
    const animalIdContainer = document.getElementById('animal_id_container');
    const animalTypeContainer = document.getElementById('animal_type_container');

    treatmentType.addEventListener('change', function () {
        if (this.value === 'تطعيم عام') {
            animalIdContainer.classList.add('hidden');
            animalTypeContainer.classList.remove('hidden');
        } else {
            animalIdContainer.classList.remove('hidden');
            animalTypeContainer.classList.add('hidden');
        }
    });
</script>
