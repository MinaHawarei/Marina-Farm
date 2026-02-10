{{-- HealthReportFormComponent.blade.php --}}
<div id="health-form" class="fixed inset-0 z-50 {{ $isVisible ? '' : 'hidden' }} overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-900/75 backdrop-blur-sm transition-opacity"></div>

    <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
        <!-- Modal Panel -->
        <div class="relative transform overflow-hidden rounded-2xl bg-white text-right shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-4xl border border-gray-100">
            
            <!-- Header -->
            <div class="bg-gray-50/50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-900 font-tajawal flex items-center gap-2" id="modal-title">
                    <div class="w-8 h-8 rounded-lg bg-purple-100 flex items-center justify-center">
                        <i class="fas fa-heartbeat text-purple-600"></i>
                    </div>
                    إضافة تقرير صحي
                </h3>
                <button type="button" onclick="toggleHealthForm()" class="text-gray-400 hover:text-gray-500 transition-colors focus:outline-none">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Form -->
            <form action="{{ route('health.store') }}" method="POST" id="health_form" class="p-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- نوع العلاج --}}
                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">نوع العلاج<span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select name="treatment_type" id="treatment_type" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none appearance-none" required>
                                <option value="">اختر نوع العلاج</option>
                                <option value="فحص دوري">فحص دوري</option>
                                <option value="علاج إصابة">علاج إصابة</option>
                                <option value="تطعيم عام">تطعيم عام</option>
                                <option value="تطعيم خاص">تطعيم خاص</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-4 text-gray-500">
                                <i class="fas fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </div>

                    {{-- التاريخ --}}
                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">التاريخ<span class="text-red-500">*</span></label>
                        <input type="date" name="date" max="{{ date('Y-m-d') }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" required>
                    </div>

                    {{-- حقل اختيار الحيوان أو النوع --}}
                    <div id="animal_id_container" class="relative">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">الحيوان<span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select name="animal_id" id="animal_id" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none appearance-none">
                                <option value="">اختر الحيوان</option>
                                @foreach($animals as $animal)
                                    <option value="{{ $animal->id }}">{{ $animal->type }} - {{ $animal->animal_code }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-4 text-gray-500">
                                <i class="fas fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </div>

                    <div id="animal_type_container" class="hidden relative">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">نوع الحيوان<span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select name="animal_type" id="animal_type" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none appearance-none">
                                <option value="">اختر النوع</option>
                                <option value="Buffalo">جاموس</option>
                                <option value="Cow">بقر</option>
                                <option value="Chicken">دجاج</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-4 text-gray-500">
                                <i class="fas fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </div>

                    {{-- اسم الطبيب البيطري --}}
                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">اسم الطبيب البيطري</label>
                        <input type="text" name="veterinarian_name" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none">
                    </div>

                    {{-- ملاحظات --}}
                    <div class="md:col-span-2 relative">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">تفاصيل</label>
                        <textarea name="notes" rows="3" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none"></textarea>
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-8 pt-4 border-t border-gray-100 flex justify-end gap-3">
                    <button type="button" onclick="toggleHealthForm()" class="px-6 py-2.5 border border-gray-200 rounded-xl text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 font-medium font-tajawal">إلغاء</button>
                    
                    <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white px-8 py-2.5 rounded-xl shadow-lg shadow-brand-500/20 transition-all duration-200 font-medium font-tajawal flex items-center gap-2 transform active:scale-95">
                        <i class="fas fa-save"></i>
                        اضافة
                    </button>
                </div>
            </form>
        </div>
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
