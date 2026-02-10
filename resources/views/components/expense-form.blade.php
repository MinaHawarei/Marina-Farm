{{-- ExpenseFormComponent.blade.php --}}
<div id="expense-form" class="fixed inset-0 z-50 {{ $isVisible ? '' : 'hidden' }} overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-900/75 backdrop-blur-sm transition-opacity"></div>

    <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
        <!-- Modal Panel -->
        <div class="relative transform overflow-hidden rounded-2xl bg-white text-right shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-4xl border border-gray-100">
            
            <!-- Header -->
            <div class="bg-gray-50/50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-900 font-tajawal flex items-center gap-2" id="modal-title">
                    <div class="w-8 h-8 rounded-lg bg-orange-100 flex items-center justify-center">
                        <i class="fas fa-receipt text-orange-600"></i>
                    </div>
                    {{ $title }}
                </h3>
                <button type="button" onclick="dailyExpenseForm()" class="text-gray-400 hover:text-gray-500 transition-colors focus:outline-none">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Form -->
            <form action="{{ route('expense.store') }}" method="POST" id="expense_create_form" class="p-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Column 1 --}}
                    <div class="space-y-5">

                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">فئة المصروفات<span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select id="mainCategory" name="category" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none appearance-none" required>
                                    <option value="">اختر نوع المصروفات</option>
                                    <option value="Feed Costs">مصاريف التغذية</option>
                                    <option value="Veterinary Expenses">مصاريف الرعاية البيطرية</option>
                                    <option value="Labor Wages">مصاريف العمالة</option>
                                    <option value="Operational Costs">مصاريف التشغيل</option>
                                    <option value="Machinery Purchase">شراء الآلات</option>
                                    <option value="Equipment Maintenance">صيانة المعدات والبنية التحتية</option>
                                    <option value="Agricultural Supplies">مصاريف الزراعة</option>
                                    <option value="Transportation Costs">مصاريف النقل</option>
                                    <option value="Buying Animals">شراء حيوانات جديدة</option>
                                    <option value="Administrative Expenses">المصاريف الإدارية</option>
                                    <option value="Emergency Costs">تكاليف طارئة</option>
                                    <option value="Other">أخرى</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-4 text-gray-500">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">نوع المصروفات<span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select id="subCategory" name="type" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none appearance-none">
                                    <option value="">اختر المصروف</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-4 text-gray-500">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <div id="otherSubCategoryContainer" class="hidden relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">التوزيع الفرعي الآخر<span class="text-red-500">*</span></label>
                            <input type="text" id="otherSubCategory" name="other_type" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" placeholder="اكتب التوزيع الفرعي هنا">
                        </div>

                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">تفاصيل<span class="text-red-500">*</span></label>
                            <input type="text" name="description" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none">
                        </div>

                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">التاريخ<span class="text-red-500">*</span></label>
                            <input type="date" name="date" max="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" required>
                        </div>

                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">اسم المورد<span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select id="supplier_select" name="supplier_id" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none appearance-none" required>
                                    <option value="">اختر المورد</option>
                                    @isset($suppliers)
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}" data-name="{{ $supplier->name }}">{{ $supplier->name }} (كود: {{ $supplier->id }})</option>
                                        @endforeach
                                    @endisset
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-4 text-gray-500">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        {{-- Hidden field for supplier name --}}
                        <input type="hidden" id="supplier_name_hidden_field" name="supplier_name">

                    </div>
                    
                    {{-- Column 2 --}}
                    <div class="space-y-5">
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">الكمية<span class="text-red-500">*</span></label>
                            <input type="number" name="quantity" min="0" step="1" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" required>
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">سعر الوحدة<span class="text-red-500">*</span></label>
                            <input type="number" name="unit_price" min="0" step="1" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" required>
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">القيمة<span class="text-red-500">*</span></label>
                            <input type="number" name="amount" min="0" step="1" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" required>
                        </div>

                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">المدفوع<span class="text-red-500">*</span></label>
                            <input type="number" name="paid" min="0" step="1" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" required>
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">الباقي<span class="text-red-500">*</span></label>
                            <input type="number" name="remaining" min="0" step="1" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" required>
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">تاريخ تحصيل الباقي <span class="text-red-500">*</span></label>
                            <input type="date" name="payment_due_date" min="{{ date('Y-m-d') }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none">
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-8 pt-4 border-t border-gray-100 flex justify-end gap-3">
                    <button type="button" onclick="dailyExpenseForm()" class="px-6 py-2.5 border border-gray-200 rounded-xl text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 font-medium font-tajawal">إلغاء</button>
                    
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
    // البيانات الخاصة بالتوزيعات الفرعية (كما هي)
    const subCategoriesData = {
        "Feed Costs": [
            { value: "Hay", text: "تبن" },
            { value: "clover Feed", text: "برسيم" },
            { value: "Corn", text: "ذرة" },
            { value: "Soybean", text: "فول الصويا" },
            { value: "Soybean Hulls", text: "قشور فول الصويا" },
            { value: "Bran", text: "ردة" },
            { value: "Silage", text: "سيلاج" },
            { value: "Concentrates", text: "المركزات" }
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
            { value: "Tools and Equipment", "text": "العدد والأدوات" }
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

    // عناصر حقول المورد
    const supplierSelect = document.getElementById('supplier_select');
    const supplierNameHiddenField = document.getElementById('supplier_name_hidden_field');

    // عند تغيير الفئة الرئيسية
    mainCategory.addEventListener('change', function () {
        const selectedCategory = mainCategory.value;
        subCategory.innerHTML = '<option value="">اختر التوزيع الفرعي</option>';
        otherSubCategoryContainer.classList.add('hidden');
        otherSubCategory.value = '';

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
            otherSubCategoryContainer.classList.remove('hidden');
        } else {
            otherSubCategoryContainer.classList.add('hidden');
            otherSubCategory.value = '';
        }
    });

    // **الدالة المسؤولة عن تحديث حقل اسم المورد المخفي**
    function updateSupplierNameHiddenField() {
        const selectedOption = supplierSelect.options[supplierSelect.selectedIndex];
        if (selectedOption && selectedOption.dataset.name) {
            supplierNameHiddenField.value = selectedOption.dataset.name;
        } else {
            supplierNameHiddenField.value = ''; // مسح القيمة إذا لم يتم تحديد مورد
        }
        console.log('Supplier Name Hidden Field Value:', supplierNameHiddenField.value); // للتصحيح
    }

    // استمع لحدث التغيير على الـ droplist للموردين
    supplierSelect.addEventListener('change', updateSupplierNameHiddenField);

    // **مهم جداً: استدعاء الدالة عند تحميل الصفحة**
    document.addEventListener('DOMContentLoaded', updateSupplierNameHiddenField);


    // قبل إرسال الفورم، لو تم اختيار "أخرى"
    document.getElementById('expense_create_form').addEventListener('submit', function(e) {
        // تأكد من تحديث اسم المورد قبل الإرسال مباشرة
        updateSupplierNameHiddenField(); // استدعاء الدالة مرة أخرى قبل الإرسال

        if (subCategory.value === "Other") {
            if (otherSubCategory.value.trim() !== '') {
                subCategory.value = otherSubCategory.value.trim();
            }
        }
    });
</script>
