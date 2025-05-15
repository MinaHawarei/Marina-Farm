{{-- AnimalFormComponent.blade.php --}}
<div id="edit-milk-form" class="fixed inset-0 z-50 bg-black bg-opacity-50 {{ $isVisible ? '' : 'hidden' }} flex items-center justify-center p-4 overflow-y-auto">
    <div class="bg-white max-w-4xl mx-auto rounded-lg shadow-lg p-6 relative w-3/4">
        <h3 class="text-xl font-semibold text-gray-800 mb-6">{{ $title }}</h3>
        <form action="{{ $action }}" method="PUT">
            @csrf
            @if($milkRecord)  {{-- إذا كان في سجل موجود نضيف الـ method و الـ id --}}
                @method('PUT')
                <input type="hidden" name="id" value="{{ $milkRecord->id }}">
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- العمود الأول --}}
                <div class="space-y-3">

                    <div>
                        <label class="block text-gray-700 mb-1">اليوم<span class="text-red-500">*</span></label>
                        <input type="date" name="date" max="{{ date('Y-m-d') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" value="{{ $milkRecord->date ?? '' }}" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-1">ملاحظات</label>
                        <input type="text" name="notes" class="w-full px-4 py-2 border border-gray-300 rounded-lg" value="{{ $milkRecord->notes ?? '' }}">
                    </div>
                </div>
                {{-- العمود الثاني --}}
                <div class="space-y-3">
                    <div>
                        <label class="block text-gray-700 mb-1">الانتاج الصباحي <span class="text-red-500">*</span></label>
                        <input type="number" name="morning_milk" min="0" step="1" class="w-full px-4 py-2 border border-gray-300 rounded-lg" value="{{ $milkRecord->morning_milk ?? '' }}" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-1">الانتاج المسائي <span class="text-red-500">*</span></label>
                        <input type="number" name="evening_milk" min="0" step="1" class="w-full px-4 py-2 border border-gray-300 rounded-lg" value="{{ $milkRecord->evening_milk ?? '' }}" required>
                    </div>
                </div>
            </div>

            {{-- أزرار --}}
            <div class="mt-8 flex justify-end gap-3">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                    {{ $milkRecord ? 'تعديل' : 'إضافة' }}  {{-- تغيير النص حسب الوضع --}}
                </button>
                <button type="button" onclick="milkForm(false)" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">إلغاء</button>
            </div>
        </form>
    </div>
</div>
