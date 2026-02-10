{{-- AnimalFormComponent.blade.php --}}
<div id="edit-form" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-900/75 backdrop-blur-sm transition-opacity"></div>

    <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
        <!-- Modal Panel -->
        <div class="relative transform overflow-hidden rounded-2xl bg-white text-right shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-4xl border border-gray-100">
            
            <!-- Header -->
            <div class="bg-gray-50/50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-900 font-tajawal flex items-center gap-2" id="modal-title">
                    <div class="w-8 h-8 rounded-lg bg-orange-100 flex items-center justify-center">
                        <i class="fas fa-edit text-orange-600"></i>
                    </div>
                    تحديث البيانات
                </h3>
                <button type="button" onclick="closeForm('edit-form')" class="text-gray-400 hover:text-gray-500 transition-colors focus:outline-none">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            @if(isset($animal))
            <form action="{{ route('animals.update', $animal->id) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Column 1 --}}
                    <div class="space-y-5">
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">كود الحيوان <span class="text-red-500">*</span></label>
                            <input type="text" name="animal_code" value="{{ $animal->animal_code }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" required>
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">النوع <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select name="type" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none appearance-none" required>
                                    <option value="">اختر النوع</option>
                                    <option value="Buffalo" {{ $animal->type == 'Buffalo' ? 'selected' : '' }}>جاموس</option>
                                    <option value="Cow" {{ $animal->type == 'Cow' ? 'selected' : '' }}>بقر</option>
                                    <option value="Chekeen" {{ $animal->type == 'Chekeen' ? 'selected' : '' }}>دجاج</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-4 text-gray-500">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">السلالة</label>
                            <div class="relative">
                                <select name="breed" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none appearance-none">
                                    <option value="">اختر السلالة</option>
                                    <option value="طبيعي" {{ $animal->breed == 'طبيعي' ? 'selected' : '' }}>طبيعي</option>
                                    <option value="صناعي" {{ $animal->breed == 'صناعي' ? 'selected' : '' }}>صناعي</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-4 text-gray-500">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">العمر (بالسنين) <span class="text-red-500">*</span></label>
                            <input type="number" name="age" value="{{ $animal->age }}" min="0" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" required>
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">الوزن (كجم) <span class="text-red-500">*</span></label>
                            <input type="number" name="weight" value="{{ $animal->weight }}" min="0" step="0.1" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" required>
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">الحظيرة <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select name="pen_id" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none appearance-none" required>
                                    <option value="">اختر الحظيرة</option>
                                    <option value="رضاعة" {{ $animal->pen_id == 'رضاعة' ? 'selected' : '' }}>رضاعة</option>
                                    <option value="فطام" {{ $animal->pen_id == 'فطام' ? 'selected' : '' }}>فطام</option>
                                    <option value="تحت التلقيح" {{ $animal->pen_id == 'تحت التلقيح' ? 'selected' : '' }}>تحت التلقيح</option>
                                    <option value="عشار" {{ $animal->pen_id == 'عشار' ? 'selected' : '' }}>عشار</option>
                                    <option value="انتظار ولادة" {{ $animal->pen_id == 'انتظار ولادة' ? 'selected' : '' }}>انتظار ولادة</option>
                                    <option value="حلاب" {{ $animal->pen_id == 'حلاب' ? 'selected' : '' }}>حلاب</option>
                                    <option value="جفاف" {{ $animal->pen_id == 'جفاف' ? 'selected' : '' }}>جفاف</option>
                                    <option value="دجاج" {{ $animal->pen_id == 'دجاج' ? 'selected' : '' }}>دجاج</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-4 text-gray-500">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Column 2 --}}
                    <div class="space-y-5">
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">الحالة الصحية</label>
                            <div class="relative">
                                <select name="health_status" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none appearance-none">
                                    <option value="جيدة" {{ $animal->health_status == 'جيدة' ? 'selected' : '' }}>جيدة</option>
                                    <option value="متوسطة" {{ $animal->health_status == 'متوسطة' ? 'selected' : '' }}>متوسطة</option>
                                    <option value="سيئة" {{ $animal->health_status == 'سيئة' ? 'selected' : '' }}>سيئة</option>
                                    <option value="تحت العلاج" {{ $animal->health_status == 'تحت العلاج' ? 'selected' : '' }}>تحت العلاج</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-4 text-gray-500">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">الجنس <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select name="gender" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none appearance-none" required>
                                    <option value="">اختر الجنس</option>
                                    <option value="ذكر" {{ $animal->gender == 'ذكر' ? 'selected' : '' }}>ذكر</option>
                                    <option value="انثي" {{ $animal->gender == 'انثي' ? 'selected' : '' }}>أنثى</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-4 text-gray-500">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">كود الام (او المورد)<span class="text-red-500">*</span></label>
                            <input type="text" name="origin" value="{{ $animal->origin }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" required>
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">تاريخ الوصول <span class="text-red-500">*</span></label>
                            <input type="date" name="arrival_date" value="{{ $animal->arrival_date }}" max="{{ date('Y-m-d') }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" required>
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">الحالة <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select name="status" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none appearance-none" required>
                                    <option value="">اختر الحالة</option>
                                    <option value="dairy" {{ $animal->status == 'dairy' ? 'selected' : '' }}>حلاب</option>
                                    <option value="calf" {{ $animal->status == 'calf' ? 'selected' : '' }}>مواليد</option>
                                    <option value="fattening" {{ $animal->status == 'fattening' ? 'selected' : '' }}>تسمين</option>
                                    <option value="pregnant" {{ $animal->status == 'pregnant' ? 'selected' : '' }}>عشار</option>
                                    <option value="bull" {{ $animal->status == 'bull' ? 'selected' : '' }}>طور</option>
                                    <option value="Paid" {{ $animal->status == 'Paid' ? 'selected' : '' }}>مباع</option>
                                    <option value="Death" {{ $animal->status == 'Death' ? 'selected' : '' }}>وفاة</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-4 text-gray-500">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal"> -اذا كانت عشار -نوع التلقيح</label>
                            <div class="relative">
                                <select name="insemination_type" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none appearance-none">
                                    <option value="غير ملقحة" {{ $animal->insemination_type == 'غير ملقحة' ? 'selected' : '' }}>غير ملقحة</option>
                                    <option value="طبيعي" {{ $animal->insemination_type == 'طبيعي' ? 'selected' : '' }}>طبيعي</option>
                                    <option value="صناعي" {{ $animal->insemination_type == 'صناعي' ? 'selected' : '' }}>صناعي</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-4 text-gray-500">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-8 pt-4 border-t border-gray-100 flex justify-end gap-3">
                    <button type="button" onclick="closeForm('edit-form')" class="px-6 py-2.5 border border-gray-200 rounded-xl text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 font-medium font-tajawal">إلغاء</button>
                    
                    <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white px-8 py-2.5 rounded-xl shadow-lg shadow-brand-500/20 transition-all duration-200 font-medium font-tajawal flex items-center gap-2 transform active:scale-95">
                        <i class="fas fa-save"></i>
                        حفظ البيانات
                    </button>
                </div>
            </form>
            @endif
        </div>
    </div>
</div>
