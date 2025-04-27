{{-- AnimalFormComponent.blade.php --}}
<div id="daily-consumptions-form" class="fixed inset-0 z-50 bg-black bg-opacity-50 {{ $isVisible ? '' : 'hidden' }} flex items-center justify-center">
    <div class="bg-white max-w-4xl mx-auto rounded-lg shadow-lg p-6 relative w-3/4">
        <h3 class="text-xl font-semibold text-gray-800 mb-6">{{ $title }}</h3>
        <form action="{{ route('DailyConsumption.store') }}" method="POST">
            dailyExpenseForm
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- العمود الأول --}}
                <div class="space-y-3">
                    <div>
                        <label class="block text-gray-700 mb-1">تبن (كجم)<span class="text-red-500">*</span></label>
                        <input type="number" name="hay" min="0" step="0.1" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-1">علف (كجم)<span class="text-red-500">*</span></label>
                        <input type="number" name="feed" min="0" step="0.1" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-1">برسيم (كجم)<span class="text-red-500">*</span></label>
                        <input type="number" name="clover" min="0" step="0.1" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-1">التاريخ<span class="text-red-500">*</span></label>
                        <input type="date" name="consumptions_date" max="{{ date('Y-m-d') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    </div>
                </div>
                {{-- العمود الثاني --}}
                <div class="space-y-3">
                    <div>
                        <label class="block text-gray-700 mb-1">بنزين (لتر) <span class="text-red-500">*</span></label>
                        <input type="number" name="gasoline" min="0" step="1" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-1"> سولار (لتر) <span class="text-red-500">*</span></label>
                        <input type="number" name="gas" min="0" step="1" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-1">ملاحظات<span class="text-red-500">*</span></label>
                        <input type="text" name="notes" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                </div>

            </div>
            {{-- أزرار --}}
            <div class="mt-8 flex justify-end gap-3">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                    اضافة
                </button>
                <button type="button" onclick="dailyConsumptionsForm()" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">إلغاء</button>
            </div>
        </form>
    </div>
</div>
