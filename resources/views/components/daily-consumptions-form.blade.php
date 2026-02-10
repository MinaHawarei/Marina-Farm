{{-- AnimalFormComponent.blade.php --}}
<div id="daily-consumptions-form" class="fixed inset-0 z-50 {{ $isVisible ? '' : 'hidden' }} overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-900/75 backdrop-blur-sm transition-opacity"></div>

    <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
        <!-- Modal Panel -->
        <div class="relative transform overflow-hidden rounded-2xl bg-white text-right shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-4xl border border-gray-100">
            
            <!-- Header -->
            <div class="bg-gray-50/50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-900 font-tajawal flex items-center gap-2" id="modal-title">
                    <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center">
                        <i class="fas fa-utensils text-red-600"></i>
                    </div>
                    {{ $title }}
                </h3>
                <button type="button" onclick="dailyConsumptionsForm()" class="text-gray-400 hover:text-gray-500 transition-colors focus:outline-none">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Form -->
            <form action="{{ route('DailyConsumption.store') }}" method="POST" class="p-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Column 1 --}}
                    <div class="space-y-5">
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">تبن (كجم)<span class="text-red-500">*</span></label>
                            <input type="number" name="hay" min="0" step="0.1" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" required>
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">ذرة (كجم)<span class="text-red-500">*</span></label>
                            <input type="number" name="corn" min="0" step="0.1" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" required>
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">ردة (كجم)<span class="text-red-500">*</span></label>
                            <input type="number" name="bran" min="0" step="0.1" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" required>
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">سيلاج (كجم)<span class="text-red-500">*</span></label>
                            <input type="number" name="silage" min="0" step="0.1" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" required>
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">التاريخ<span class="text-red-500">*</span></label>
                            <input type="date" name="consumptions_date" max="{{ date('Y-m-d') }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" required>
                        </div>
                    </div>
                    
                    {{-- Column 2 --}}
                    <div class="space-y-5">
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">صويا (كجم)<span class="text-red-500">*</span></label>
                            <input type="number" name="soybean" min="0" step="0.1" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" required>
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">قشر صويا (كجم)<span class="text-red-500">*</span></label>
                            <input type="number" name="soybean_hulls" min="0" step="0.1" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" required>
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">برسيم (كجم)<span class="text-red-500">*</span></label>
                            <input type="number" name="clover" min="0" step="0.1" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" required>
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">بنزين (لتر) <span class="text-red-500">*</span></label>
                            <input type="number" name="gasoline" min="0" step="1" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" required>
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">سولار (لتر) <span class="text-red-500">*</span></label>
                            <input type="number" name="solar" min="0" step="1" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" required>
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">ملاحظات</label>
                            <textarea name="notes" rows="3" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-8 pt-4 border-t border-gray-100 flex justify-end gap-3">
                    <button type="button" onclick="dailyConsumptionsForm()" class="px-6 py-2.5 border border-gray-200 rounded-xl text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 font-medium font-tajawal">إلغاء</button>
                    
                    <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white px-8 py-2.5 rounded-xl shadow-lg shadow-brand-500/20 transition-all duration-200 font-medium font-tajawal flex items-center gap-2 transform active:scale-95">
                        <i class="fas fa-save"></i>
                        اضافة
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
