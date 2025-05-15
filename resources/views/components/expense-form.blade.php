{{-- AnimalFormComponent.blade.php --}}
<div id="expense-form" class="fixed inset-0 z-50 bg-black bg-opacity-50 {{ $isVisible ? '' : 'hidden' }} flex items-center justify-center p-4 overflow-y-auto">
    <div class="bg-white max-w-4xl mx-auto rounded-lg shadow-lg p-6 relative w-3/4">
        <h3 class="text-xl font-semibold text-gray-800 mb-6">{{ $title }}</h3>
        <form action="{{ route('expense.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- العمود الأول --}}
                <div class="space-y-3">

                    <!-- النوع الرئيسي -->
                    <div>
                        <label class="block text-gray-700 mb-1">فئة المصروفات<span class="text-red-500">*</span></label>
                        <select id="mainCategory" name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-center" required>
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
                    </div>


                    <!-- التوزيعات الفرعية -->
                    <div class="mt-4">
                        <label class="block text-gray-700 mb-1">نوع المصروفات<span class="text-red-500">*</span></label>
                        <select id="subCategory" name="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-center">
                            <option value="">اختر المصروف</option>
                        </select>
                    </div>



                    <!-- الحقل النصي الخاص بـ "أخرى" -->
                    <div id="otherSubCategoryContainer" class="hidden mt-4">
                        <label class="block text-gray-700 mb-1">التوزيع الفرعي الآخر<span class="text-red-500">*</span></label>
                        <input type="text" id="otherSubCategory" name="other_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="اكتب التوزيع الفرعي هنا">
                    </div>







                    <div>
                        <label class="block text-gray-700 mb-1">تفاصيل<span class="text-red-500">*</span></label>
                        <input type="text" name="description" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-1">التاريخ<span class="text-red-500">*</span></label>
                        <input type="date" name="date" max="{{ date('Y-m-d') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-1">اسم المورد<span class="text-red-500">*</span></label>
                        <input type="text" name="supplier_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-1">الرقم التعريفي للمورد<span class="text-red-500">*</span></label>
                        <input type="number" name="supplier_id" min="1" step="1" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                </div>
                {{-- العمود الثاني --}}
                <div class="space-y-3">
                    <div>
                        <label class="block text-gray-700 mb-1">الكمية<span class="text-red-500">*</span></label>
                        <input type="number" name="quantity" min="0" step="1" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-1">سعر الوحدة<span class="text-red-500">*</span></label>
                        <input type="number" name="unit_price" min="0" step="1" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-1">القيمة<span class="text-red-500">*</span></label>
                        <input type="number" name="amount" min="0" step="1" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-1">المدفوع<span class="text-red-500">*</span></label>
                        <input type="number" name="paid" min="0" step="1" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-1">الباقي<span class="text-red-500">*</span></label>
                        <input type="number" name="remaining" min="0" step="1" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-1">تاريخ تحصيل الباقي <span class="text-red-500">*</span></label>
                        <input type="date" name="payment_due_date" min="{{ date('Y-m-d') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>

                </div>

            </div>
            {{-- أزرار --}}
            <div class="mt-8 flex justify-end gap-3">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                    اضافة
                </button>
                <button type="button" onclick="dailyExpenseForm()" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">إلغاء</button>
            </div>
        </form>
    </div>
</div>
<script>
    // البيانات الخاصة بالتوزيعات الفرعية
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
