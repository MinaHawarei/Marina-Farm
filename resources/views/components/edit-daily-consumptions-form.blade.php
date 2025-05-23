{{-- AnimalFormComponent.blade.php --}}
<div id="edit-form" class="fixed inset-0 z-50 bg-black bg-opacity-50 hidden flex items-center justify-center p-4 overflow-y-auto">
    <div class="bg-white max-w-4xl mx-auto rounded-lg shadow-lg p-6 relative w-3/4">
        <h3 class="text-xl font-semibold text-gray-800 mb-6"> تحديث البيانات </h3>
        @if(isset($production))
        <form action="{{ route('daily-consumption.update', $production->id) }}" method="POST">
            @csrf
            @method('PUT') <!-- لازم تبقى PATCH أو PUT مش POST -->

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                 {{-- العمود الأول --}}
                 <div class="space-y-3">
                    <div>
                        <label class="block text-gray-700 mb-1">تبن (كجم)<span class="text-red-500">*</span></label>
                        <input type="number" name="hay" min="0" step="0.1" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-1">ذرة (كجم)<span class="text-red-500">*</span></label>
                        <input type="number" name="corn" min="0" step="0.1" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-1">ردة (كجم)<span class="text-red-500">*</span></label>
                        <input type="number" name="bran" min="0" step="0.1" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-1">سيلاج (كجم)<span class="text-red-500">*</span></label>
                        <input type="number" name="silage" min="0" step="0.1" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    </div>



                    <div>
                        <label class="block text-gray-700 mb-1">التاريخ<span class="text-red-500">*</span></label>
                        <input type="date" name="consumptions_date" max="{{ date('Y-m-d') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    </div>
                </div>
                {{-- العمود الثاني --}}
                <div class="space-y-3">
                    <div>
                        <label class="block text-gray-700 mb-1">صويا (كجم)<span class="text-red-500">*</span></label>
                        <input type="number" name="soybean" min="0" step="0.1" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-1">قشر صويا (كجم)<span class="text-red-500">*</span></label>
                        <input type="number" name="soybean_hulls" min="0" step="0.1" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-1">برسيم (كجم)<span class="text-red-500">*</span></label>
                        <input type="number" name="clover" min="0" step="0.1" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-1">بنزين (لتر) <span class="text-red-500">*</span></label>
                        <input type="number" name="gasoline" min="0" step="1" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-1"> سولار (لتر) <span class="text-red-500">*</span></label>
                        <input type="number" name="solar" min="0" step="1" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
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
                    حفظ البيانات
                </button>
                    <button type="button" onclick="closeForm('edit-form')" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">إلغاء</button>
            </div>
        </form>
        @else
            <form action="#" method="POST">
        @endif

    </div>
</div>
