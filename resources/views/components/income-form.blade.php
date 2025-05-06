{{-- AnimalFormComponent.blade.php --}}



<div id="income-form" class="fixed inset-0 z-50 bg-black bg-opacity-50 {{ $isVisible ? '' : 'hidden' }} flex items-center justify-center">
    <div class="bg-white max-w-4xl mx-auto rounded-lg shadow-lg p-6 relative w-3/4">
        <h3 class="text-xl font-semibold text-gray-800 mb-6">{{ $title }}</h3>
        <form action="{{ route('income.store') }}" method="POST" id="income_form">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- العمود الأول --}}
                <div class="space-y-3">
                    <!-- الفئة الرئيسية -->
                    <div>
                        <label class="block text-gray-700 mb-1">فئة الإيرادات<span class="text-red-500">*</span></label>
                        <select id="income_mainCategory" name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-center" required>
                            <option value="">اختر فئة الإيراد</option>
                            <option value="Product Sales">بيع منتجات</option>
                            <option value="Animal Sales">بيع بهائم</option>
                            <option value="Equipment Sales">بيع معدات أو أثاث</option>
                            <option value="Rent Income">إيجار</option>
                            <option value="Collections">تحصيل ديون</option>
                            <option value="Other">أخرى</option>
                        </select>
                    </div>

                    <!-- التوزيع الفرعي -->
                    <div class="mt-4">
                        <label class="block text-gray-700 mb-1">نوع الايراد<span class="text-red-500">*</span></label>
                        <select id="income_subCategory" name="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-center">
                            <option value="">اختر التوزيع الفرعي</option>
                        </select>
                    </div>

                    <!-- حقل أخرى -->
                    <div id="income_otherSubCategoryContainer" class="hidden mt-4">
                        <label class="block text-gray-700 mb-1">التوزيع الفرعي الآخر<span class="text-red-500">*</span></label>
                        <input type="text" id="income_otherSubCategory" name="other_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="اكتب التوزيع الفرعي هنا">
                    </div>

                    <!-- باقي الحقول -->
                    <div>
                        <label class="block text-gray-700 mb-1">تفاصيل<span class="text-red-500">*</span></label>
                        <input type="text" name="description" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-1">التاريخ<span class="text-red-500">*</span></label>
                        <input type="date" name="date" max="{{ date('Y-m-d') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-1">اسم العميل<span class="text-red-500">*</span></label>
                        <input type="text" name="buyer_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-1">الرقم التعريفي للعميل<span class="text-red-500">*</span></label>
                        <input type="number" name="buyer_id" min="1" step="1" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
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
                    إضافة
                </button>
                <button type="button" onclick="incomeForm()" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    إلغاء
                </button>
            </div>
        </form>
    </div>
</div>

<script>

    const income_subCategoriesData = {
        "Product Sales": [
            { value: "Buffalo Milk", text: "لبن جاموس" },
            { value: "Cow Milk", text: "لبن بقري" },
            { value: "eggs", text: "بيض" },
            { value: "ghee", text: "سمن" },
            { value: "Cheese", text: "جبن" },
            { value: "dates", text: "بلح" },
            { value: "clover", text: "برسيم" },
            { value: "fertilizer", text: "سماد حيواني" },
        ],
        "Animal Sales": [
            { value: "Buffalo Sales", text: "بيع الجاموس" },
            { value: "Cow Sales", text: "بيع الأبقار" },
            { value: "Chicken Sales", text: "بيع الدجاج" }
        ],
        "Equipment Sales": [
            { value: "Machinery Sales", text: "بيع الماكينات" },
            { value: "Furniture Sales", text: "بيع الأثاث" }
        ],
        "Rent Income": [
            { value: "Land Rent", text: "تأجير أراضي" },
            { value: "Equipment Rent", text: "تأجير معدات" }
        ],
        "Collections": [
            { value: "Debt Collection", text: "تحصيل ديون" },
            { value: "Installment Collection", text: "تحصيل أقساط" }
        ],
        "Other": [
            { value: "Other", text: "أخرى" }
        ]
    };

    const income_mainCategory = document.getElementById('income_mainCategory');
    const income_subCategory = document.getElementById('income_subCategory');
    const income_otherSubCategoryContainer = document.getElementById('income_otherSubCategoryContainer');
    const income_otherSubCategory = document.getElementById('income_otherSubCategory');

    // عند تغيير الفئة الرئيسية
    income_mainCategory.addEventListener('change', function () {
        const selectedCategory = income_mainCategory.value;

        income_subCategory.innerHTML = '<option value="">اختر التوزيع الفرعي</option>';
        income_otherSubCategoryContainer.classList.add('hidden');
        income_otherSubCategory.value = '';

        if (income_subCategoriesData[selectedCategory]) {
            income_subCategoriesData[selectedCategory].forEach(sub => {
                const option = document.createElement('option');
                option.value = sub.value;
                option.textContent = sub.text;
                income_subCategory.appendChild(option);
            });
        }
    });

    // عند اختيار "أخرى" بالتوزيع الفرعي
    income_subCategory.addEventListener('change', function () {
        if (income_subCategory.value === "Other") {
            income_otherSubCategoryContainer.classList.remove('hidden');
        } else {
            income_otherSubCategoryContainer.classList.add('hidden');
            income_otherSubCategory.value = '';
        }
    });

    // قبل إرسال الفورم، لو تم اختيار "أخرى"
    document.getElementById('income_form').addEventListener('submit', function(e) {
        if (income_subCategory.value === "Other") {
            if (income_otherSubCategory.value.trim() !== '') {
                income_subCategory.value = income_otherSubCategory.value.trim();
            }
        }
    });
</script>
