{{-- AnimalFormComponent.blade.php --}}
<div id="daily-prodection-form" class="fixed inset-0 z-50 bg-black bg-opacity-50 {{ $isVisible ? '' : 'hidden' }} flex items-center justify-center">
    <div class="bg-white max-w-4xl mx-auto rounded-lg shadow-lg p-6 relative w-3/4">
        <h3 class="text-xl font-semibold text-gray-800 mb-6">{{ $title }}</h3>
        <form action="{{ route('dailyProdection.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- العمود الأول --}}
                <div class="space-y-3">
                    <div>
                        <label class="block text-gray-700 mb-1">لبن جاموس (كيلو)<span class="text-red-500">*</span></label>
                        <input type="number" name="buffaloMilk" min="0" step="0.1" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-1">لبن بقري (كيلو) <span class="text-red-500">*</span></label>
                        <input type="number" name="cowMilk" min="0" step="0.1" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-1">جبنة (كيلو) <span class="text-red-500">*</span></label>
                        <input type="number" name="cheese" min="0" step="0.1" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-1"> سمنة (كيلو) <span class="text-red-500">*</span></label>
                        <input type="number" name="ghee" min="0" step="0.1" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-1">اليوم<span class="text-red-500">*</span></label>
                        <input type="date" name="production_date" max="{{ date('Y-m-d') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    </div>
                </div>
                {{-- العمود الثاني --}}
                <div class="space-y-3">
                    <div>
                        <label class="block text-gray-700 mb-1">بيض <span class="text-red-500">*</span></label>
                        <input type="number" name="eggs" min="0" step="1" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-1">بلح (كجم) <span class="text-red-500">*</span></label>
                        <input type="number" name="dates" min="0" step="1" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-1">برسيم (كجم) <span class="text-red-500">*</span></label>
                        <input type="number" name="clover" min="0" step="1" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
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
                <button type="button" onclick="dailyProdectionForm()" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">إلغاء</button>
            </div>
        </form>
    </div>
</div>
