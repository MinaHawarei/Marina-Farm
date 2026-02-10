{{-- AnimalFormComponent.blade.php --}}
<div id="{{ $modalId }}" class="fixed inset-0 z-50 {{ $isVisible ? '' : 'hidden' }} overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-900/75 backdrop-blur-sm transition-opacity"></div>

    <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
        <!-- Modal Panel -->
        <div class="relative transform overflow-hidden rounded-2xl bg-white text-right shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-4xl border border-gray-100">
            
            <!-- Header -->
            <div class="bg-gray-50/50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-900 font-tajawal flex items-center gap-2" id="modal-title">
                    <div class="w-8 h-8 rounded-lg bg-brand-100 flex items-center justify-center">
                        <i class="fas fa-cow text-brand-600"></i>
                    </div>
                    {{ $title }}
                </h3>
                <button type="button" 
                    @if ($modalId === 'edit-form')
                        onclick="closeForm('{{ $modalId }}')"
                    @else
                        onclick="toggleForm()"
                    @endif
                    class="text-gray-400 hover:text-gray-500 transition-colors focus:outline-none">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Form -->
            <form action="{{ $formAction }}" method="POST" class="p-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Column 1 --}}
                    <div class="space-y-5">
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">كود الحيوان <span class="text-red-500">*</span></label>
                            <input type="text" name="animal_code" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" placeholder="مثال: A-123" required>
                        </div>

                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">النوع <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select name="type" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none appearance-none" required>
                                    <option value="">اختر النوع</option>
                                    <option value="Buffalo">جاموس</option>
                                    <option value="Cow">بقر</option>
                                    <option value="Chekeen">دجاج</option>
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
                                    <option value="طبيعي">طبيعي</option>
                                    <option value="صناعي">صناعي</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-4 text-gray-500">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">العمر (بالسنين) <span class="text-red-500">*</span></label>
                            <input type="number" name="age" min="0" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" required>
                        </div>

                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">الوزن (كجم) <span class="text-red-500">*</span></label>
                            <input type="number" name="weight" min="0" step="0.1" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" required>
                        </div>

                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">الحظيرة <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select name="pen_id" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none appearance-none" required>
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
                                    <option value="جيدة">جيدة</option>
                                    <option value="متوسطة">متوسطة</option>
                                    <option value="سيئة">سيئة</option>
                                    <option value="تحت العلاج">تحت العلاج</option>
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
                                    <option value="ذكر">ذكر</option>
                                    <option value="انثي">أنثى</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-4 text-gray-500">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">كود الام (او المورد) <span class="text-red-500">*</span></label>
                            <input type="text" name="origin" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" required>
                        </div>

                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">تاريخ الوصول <span class="text-red-500">*</span></label>
                            <input type="date" name="arrival_date" max="{{ date('Y-m-d') }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" required>
                        </div>

                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">الحالة <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select name="status" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none appearance-none" required>
                                    <option value="">اختر الحالة</option>
                                    <option value="dairy">حلاب</option>
                                    <option value="calf">مواليد</option>
                                    <option value="fattening">تسمين</option>
                                    <option value="pregnant">عشار</option>
                                    <option value="bull">طور</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-4 text-gray-500">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">إذا كانت عشار - نوع التلقيح</label>
                            <div class="relative">
                                <select name="insemination_type" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none appearance-none">
                                    <option value="غير ملقحة">غير ملقحة</option>
                                    <option value="طبيعي">طبيعي</option>
                                    <option value="صناعي">صناعي</option>
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
                    @if ($modalId === 'edit-form')
                        <button type="button" onclick="closeForm('{{ $modalId }}')" class="px-6 py-2.5 border border-gray-200 rounded-xl text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 font-medium font-tajawal">إلغاء</button>
                    @else
                        <button type="button" onclick="toggleForm()" class="px-6 py-2.5 border border-gray-200 rounded-xl text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 font-medium font-tajawal">إلغاء</button>
                    @endif
                    
                    <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white px-8 py-2.5 rounded-xl shadow-lg shadow-brand-500/20 transition-all duration-200 font-medium font-tajawal flex items-center gap-2 transform active:scale-95">
                        <i class="fas fa-save"></i>
                        حفظ البيانات
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
