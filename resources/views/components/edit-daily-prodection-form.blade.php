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
                    <div class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center">
                        <i class="fas fa-edit text-green-600"></i>
                    </div>
                    تحديث البيانات
                </h3>
                <button type="button" onclick="closeForm('edit-form')" class="text-gray-400 hover:text-gray-500 transition-colors focus:outline-none">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            @if(isset($production))
            <form action="{{ route('daily-production.update', $production->id) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Column 1 --}}
                    <div class="space-y-5">
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">لبن جاموس (كيلو)<span class="text-red-500">*</span></label>
                            <input type="number" name="buffaloMilk" value="{{ $production->buffaloMilk }}" min="0" step="0.1" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" required>
                        </div>

                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">لبن بقري (كيلو) <span class="text-red-500">*</span></label>
                            <input type="number" name="cowMilk" value="{{ $production->cowMilk }}" min="0" step="0.1" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" required>
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">جبنة (كيلو) <span class="text-red-500">*</span></label>
                            <input type="number" name="cheese" value="{{ $production->cheese }}" min="0" step="0.1" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" required>
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal"> سمنة (كيلو) <span class="text-red-500">*</span></label>
                            <input type="number" name="ghee" value="{{ $production->ghee }}" min="0" step="0.1" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" required>
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">اليوم<span class="text-red-500">*</span></label>
                            <input type="date" name="production_date" value="{{ $production->production_date }}" max="{{ date('Y-m-d') }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" required>
                        </div>
                    </div>
                    {{-- Column 2 --}}
                    <div class="space-y-5">
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">بيض <span class="text-red-500">*</span></label>
                            <input type="number" name="eggs" value="{{ $production->eggs }}" min="0" step="1" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" required>
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">بلح (كجم) <span class="text-red-500">*</span></label>
                            <input type="number" name="dates" value="{{ $production->dates }}" min="0" step="1" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" required>
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">برسيم (كجم) <span class="text-red-500">*</span></label>
                            <input type="number" name="clover" value="{{ $production->clover }}" min="0" step="1" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" required>
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">ملاحظات<span class="text-red-500">*</span></label>
                            <input type="text" name="notes" value="{{ $production->notes }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none">
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
