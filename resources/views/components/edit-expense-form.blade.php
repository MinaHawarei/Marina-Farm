
<div id="edit-form" class="fixed inset-0 z-50 {{ $isVisible ? '' : 'hidden' }} overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
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
                    تعديل مصروف
                </h3>
                <button type="button" onclick="closeForm('edit-form')" class="text-gray-400 hover:text-gray-500 transition-colors focus:outline-none">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            @if(isset($item))
            <form action="{{ route('income.edit' , $item->id) }}" method="POST" id="edit_expense_form" class="p-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Column 1 --}}
                    <div class="space-y-5">

                        <!-- النوع الرئيسي -->
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">فئة المصروفات<span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select id="mainCategory" name="category" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none appearance-none" required>
                                    <option value="">اختر نوع المصروفات</option>
                                    <option value="Feed Costs" {{ $item->category == 'Feed Costs' ? 'selected' : '' }}>مصاريف التغذية</option>
                                    <option value="Veterinary Expenses" {{ $item->category == 'Veterinary Expenses' ? 'selected' : '' }}>مصاريف الرعاية البيطرية</option>
                                    <option value="Labor Wages" {{ $item->category == 'Labor Wages' ? 'selected' : '' }}>مصاريف العمالة</option>
                                    <option value="Operational Costs" {{ $item->category == 'Operational Costs' ? 'selected' : '' }}>مصاريف التشغيل</option>
                                    <option value="Machinery Purchase" {{ $item->category == 'Machinery Purchase' ? 'selected' : '' }}>شراء الآلات</option>
                                    <option value="Equipment Maintenance" {{ $item->category == 'Equipment Maintenance' ? 'selected' : '' }}>صيانة المعدات والبنية التحتية</option>
                                    <option value="Agricultural Supplies" {{ $item->category == 'Agricultural Supplies' ? 'selected' : '' }}>مصاريف الزراعة</option>
                                    <option value="Transportation Costs" {{ $item->category == 'Transportation Costs' ? 'selected' : '' }}>مصاريف النقل</option>
                                    <option value="Buying Animals" {{ $item->category == 'Buying Animals' ? 'selected' : '' }}>شراء حيوانات جديدة</option>
                                    <option value="Administrative Expenses" {{ $item->category == 'Administrative Expenses' ? 'selected' : '' }}>المصاريف الإدارية</option>
                                    <option value="Emergency Costs" {{ $item->category == 'Emergency Costs' ? 'selected' : '' }}>تكاليف طارئة</option>
                                    <option value="Other" {{ $item->category == 'Other' ? 'selected' : '' }}>أخرى</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-4 text-gray-500">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <!-- التوزيعات الفرعية -->
                        <div class="relative mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">نوع المصروفات<span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select id="subCategory" name="type" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none appearance-none">
                                    <option value="">اختر المصروف</option>
                                    {{-- JS populates this, but we might want to pre-populate if possible, or let JS handle it on load if we add script for it. For now, assuming JS handles it or user re-selects --}}
                                    <option value="{{ $item->type }}" selected>{{ $item->type }}</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-4 text-gray-500">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <!-- الحقل النصي الخاص بـ "أخرى" -->
                        <div id="otherSubCategoryContainer" class="hidden mt-4 relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">التوزيع الفرعي الآخر<span class="text-red-500">*</span></label>
                            <input type="text" id="otherSubCategory" name="other_type" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" placeholder="اكتب التوزيع الفرعي هنا">
                        </div>

                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">تفاصيل<span class="text-red-500">*</span></label>
                            <input type="text" name="description" value="{{ $item->description }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none">
                        </div>

                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">التاريخ<span class="text-red-500">*</span></label>
                            <input type="date" name="date" value="{{ $item->date }}" max="{{ date('Y-m-d') }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" required>
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">اسم المورد<span class="text-red-500">*</span></label>
                            <input type="text" name="supplier_name" value="{{ $item->supplier_name }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none">
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">الرقم التعريفي للمورد<span class="text-red-500">*</span></label>
                            <input type="number" name="supplier_id" value="{{ $item->supplier_id }}" min="1" step="1" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none">
                        </div>
                    </div>
                   
                    {{-- Column 2 --}}
                    <div class="space-y-5">
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">الكمية<span class="text-red-500">*</span></label>
                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="0" step="1" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" required>
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">سعر الوحدة<span class="text-red-500">*</span></label>
                            <input type="number" name="unit_price" value="{{ $item->unit_price }}" min="0" step="1" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" required>
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">القيمة<span class="text-red-500">*</span></label>
                            <input type="number" name="amount" value="{{ $item->amount }}" min="0" step="1" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" required>
                        </div>

                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">المدفوع<span class="text-red-500">*</span></label>
                            <input type="number" name="paid" value="{{ $item->paid }}" min="0" step="1" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" required>
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">الباقي<span class="text-red-500">*</span></label>
                            <input type="number" name="remaining" value="{{ $item->remaining }}" min="0" step="1" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" required>
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">تاريخ تحصيل الباقي <span class="text-red-500">*</span></label>
                            <input type="date" name="payment_due_date" value="{{ $item->payment_due_date }}" min="{{ date('Y-m-d') }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none">
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

<script>
    // البيانات الخاصة بالتوزيعات الفرعية
    const subCategoriesData = {
        "Feed Costs": [
            { value: "Hay", text: "تبن" },
            { value: "Concentrates", text: "المركزات" },
            { value: "Feed", text: "علف" },
            { value: "clover Feed", text: "برسيم" },
        ],
        "Veterinary Expenses": [
            { value: "Medicines and Vaccines", text: "الأدوية البيطرية واللقاحات" },
            { value: "Veterinarian Visits", text: "زيارات الأطباء البيطريين" }
        ],
        "Labor Wages": [
            { value: "Worker Salaries", text: "رواتب العمال" },
            { value: "Worker Daily Salaries", text: "عمال باليومية" },
            { value: "Bonuses", text: "مكافآت" }
        ],
        "Operational Costs": [
            { value: "Electricity Bills", text: "فواتير الكهرباء" },
            { value: "Water Bills", text: "فواتير المياه" },
            { value: "Cleaning Supplies", text: "أدوات النظافة" },
            { value: "Tools and Equipment", text: "العدد والأدوات" }
        ],
        "Machinery Purchase": [
            { value: "Agricultural Machinery", text: "ماكينات زراعية" },
            { value: "Milking Machines", text: "ماكينات حلب" },
            { value: "Feeding Systems", text: "أنظمة التغذية" },
            { value: "Water Troughs", text: "أحواض شرب المياه" },
            { value: "Cooling Fans", text: "مراوح تبريد للحظائر" },
            { value: "Manure Spreaders", text: "موزعات السماد العضوي" },
            { value: "Livestock Scales", text: "موازين قياس" },
            { value: "Poultry Feeders", text: "مغذيات الدواجن" },
            { value: "Poultry Drinkers", text: "مشربيات الدواجن" },
            { value: "Incubators", text: "ماكينات تفريخ" },
            { value: "Brooder Equipment", text: "معدات التدفئة" },
            { value: "Ventilation Systems", text: "أنظمة تهوية" },
            { value: "Egg Collectors", text: "ماكينات جمع البيض" },
            { value: "Poultry Cages", text: "أقفاص الدواجن" }

        ],
        "Equipment Maintenance": [
            { value: "Barn Maintenance", text: "صيانة الحظائر" },
            { value: "Equipment Repair", text: "إصلاح المعدات الزراعية" },
            { value: "Plumbing Work", text: "أعمال السباكة" },
            { value: "Brick Work", text: "أعمال الطوب" }
        ],
        "Agricultural Supplies": [
            { value: "Seeds", text: "البذور" },
            { value: "Fertilizers", text: "الأسمدة" },
            { value: "Pesticides", text: "مكافحة الآفات" }
        ],
        "Transportation Costs": [
            { value: "Animal Transport", text: "نقل الحيوانات" },
            { value: "Vehicle Maintenance", text: "صيانة وسائل النقل" },
            { value: "Vehicle Buying", text: "شراء وسائل نقل" }
        ],
        "Buying Animals": [
            { value: "Buffalo", text: "جاموس" },
            { value: "Cow", text: "ابقار" },
            { value: "Chekeen", text: "دجاج" }
        ],
        "Administrative Expenses": [
            { value: "Bills and Taxes", text: "الفواتير والضرائب" },
            { value: "Licenses and Paperwork", text: "الأوراق والتراخيص" },
            { value: "Furniture Purchase", text: "شراء أثاث" },
            { value: "Office Supplies Purchase", text: "شراء أدوات مكتبية" },
            { value: "Furniture Maintenance", text: "صيانة أثاث" }
        ],
        "Emergency Costs": [
            { value: "Emergency Cases", text: "حالات الطوارئ" }
        ],
        "Other": [
            { value: "Tips", text: "إكراميات" },
            { value: "Other", text: "أخرى" }
        ]
    };

    const mainCategory = document.getElementById('mainCategory');
    const subCategory = document.getElementById('subCategory');
    const otherSubCategoryContainer = document.getElementById('otherSubCategoryContainer');
    const otherSubCategory = document.getElementById('otherSubCategory');

    // تغيير محتويات التوزيعات الفرعية بناءً على الاختيار
    mainCategory.addEventListener('change', function () {
        const selectedCategory = mainCategory.value;

        // تفريغ الخيارات القديمة
        subCategory.innerHTML = '<option value="">اختر التوزيع الفرعي</option>';
        otherSubCategoryContainer.classList.add('hidden'); // إخفاء الحقل النصي
        otherSubCategory.value = ''; // تفريغ القيمة النصية

        // إضافة الخيارات الجديدة إذا كانت موجودة
        if (subCategoriesData[selectedCategory]) {
            subCategoriesData[selectedCategory].forEach(sub => {
                const option = document.createElement('option');
                option.value = sub.value;
                option.textContent = sub.text;
                subCategory.appendChild(option);
            });
        }
    });

    // مراقبة اختيار "أخرى" في التوزيعات الفرعية
    subCategory.addEventListener('change', function () {
        if (subCategory.value === "Other") {
            otherSubCategoryContainer.classList.remove('hidden'); // إظهار الحقل النصي
        } else {
            otherSubCategoryContainer.classList.add('hidden'); // إخفاء الحقل النصي
            otherSubCategory.value = ''; // تفريغ القيمة النصية
        }
    });
    document.querySelector('form').addEventListener('submit', function(e) {
        if (subCategory.value === "Other") {
            if (otherSubCategory.value.trim() !== '') {
                subCategory.value = otherSubCategory.value.trim();
            }
        }
    });
</script>
