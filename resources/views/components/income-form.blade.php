{{-- income-form.blade.php (التعديل لضمان إرسال buyer_name) --}}

<div id="income-form" class="fixed inset-0 z-50 bg-black bg-opacity-50 {{ $isVisible ? '' : 'hidden' }} flex items-center justify-center p-4 overflow-y-auto">
    <div class="bg-white max-w-4xl mx-auto rounded-lg shadow-lg p-6 relative w-3/4">
        <h3 class="text-xl font-semibold text-gray-800 mb-6">{{ $title }}</h3>
        <form action="{{ route('income.store') }}" method="POST" id="income_form">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- العمود الأول --}}
                <div class="space-y-3">
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

                    <div class="mt-4">
                        <label class="block text-gray-700 mb-1">نوع الايراد<span class="text-red-500">*</span></label>
                        <select id="income_subCategory" name="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-center">
                            <option value="">اختر التوزيع الفرعي</option>
                        </select>
                    </div>
                    {{-- **بداية إضافة حقول اختيار الحيوانات** --}}
                    <div id="animal_buffalo_select_container" class="mt-4 hidden">
                        <label class="block text-gray-700 mb-1">اسم الجاموس<span class="text-red-500">*</span></label>
                        <select id="animal_buffalo_select" name="animal_code" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-center">
                            <option value="">اختر الجاموس</option>
                            @isset($buffaloes) {{-- $buffaloes تم إرسالها من الكنترولر --}}
                                @foreach($buffaloes as $animal)
                                    <option value="{{ $animal->animal_code }}" data-name="{{ $animal->animal_code }}">{{ $animal->animal_code }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>

                    <div id="animal_cow_select_container" class="mt-4 hidden">
                        <label class="block text-gray-700 mb-1">اسم البقرة<span class="text-red-500">*</span></label>
                        <select id="animal_cow_select" name="animal_code" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-center">
                            <option value="">اختر البقرة</option>
                            @isset($cows) {{-- $cows تم إرسالها من الكنترولر --}}
                                @foreach($cows as $animal)
                                    <option value="{{ $animal->animal_code }}" data-name="{{ $animal->animal_code }}">{{ $animal->animal_code }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>

                    {{-- حقل مخفي لحفظ اسم الحيوان، سيتم ملؤه بواسطة JavaScript --}}
                    <input type="hidden" id="animal_name_hidden_field" name="animal_code">
                    {{-- **نهاية إضافة حقول اختيار الحيوانات** --}}


                    <div id="income_otherSubCategoryContainer" class="hidden mt-4">
                        <label class="block text-gray-700 mb-1">التوزيع الفرعي الآخر<span class="text-red-500">*</span></label>
                        <input type="text" id="income_otherSubCategory" name="other_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="اكتب التوزيع الفرعي هنا">
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-1">تفاصيل<span class="text-red-500">*</span></label>
                        <input type="text" name="description" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-1">التاريخ<span class="text-red-500">*</span></label>
                        <input type="date" name="date" max="{{ date('Y-m-d') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    </div>

                    {{-- حقل اسم العميل (Droplist) --}}
                    <div>
                        <label class="block text-gray-700 mb-1">اسم العميل<span class="text-red-500">*</span></label>
                        <select id="buyer_select" name="buyer_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-center" required>
                            <option value="">اختر العميل</option>
                            @isset($buyers)
                                @foreach($buyers as $buyer)
                                    {{-- نستخدم data-name لتخزين اسم العميل كاملاً --}}
                                    <option value="{{ $buyer->id }}" data-name="{{ $buyer->name }}">{{ $buyer->name }} (كود: {{ $buyer->id }})</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>

                    {{-- حقل اسم العميل المخفي ليتم إرساله مع النموذج --}}
                    <input type="hidden" id="buyer_name_hidden_field" name="buyer_name">

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

    // **بداية إضافة عناصر الحيوانات الجديدة**
    const animalBuffaloSelectContainer = document.getElementById('animal_buffalo_select_container');
    const animalBuffaloSelect = document.getElementById('animal_buffalo_select');
    const animalCowSelectContainer = document.getElementById('animal_cow_select_container');
    const animalCowSelect = document.getElementById('animal_cow_select');
    const animalNameHiddenField = document.getElementById('animal_name_hidden_field');
    // **نهاية إضافة عناصر الحيوانات الجديدة**

    // دالة جديدة لإخفاء جميع حقول الحيوانات ومسح قيمها وإزالة خاصية required
    function hideAndClearAllAnimalFields() {
        animalBuffaloSelectContainer.classList.add('hidden');
        animalCowSelectContainer.classList.add('hidden');
        animalBuffaloSelect.removeAttribute('required');
        animalCowSelect.removeAttribute('required');
        animalBuffaloSelect.value = ''; // مسح القيمة المختارة
        animalCowSelect.value = '';     // مسح القيمة المختارة
        animalNameHiddenField.value = ''; // مسح اسم الحيوان المخفي
    }

    income_mainCategory.addEventListener('change', function () {
        const selectedCategory = income_mainCategory.value;
        income_subCategory.innerHTML = '<option value="">اختر التوزيع الفرعي</option>';
        income_otherSubCategoryContainer.classList.add('hidden');
        income_otherSubCategory.value = '';
        income_otherSubCategory.removeAttribute('required'); // إزالة required إذا لم تكن "أخرى"

        // أخفِ حقول الحيوانات عند تغيير الفئة الرئيسية
        hideAndClearAllAnimalFields();

        if (income_subCategoriesData[selectedCategory]) {
            income_subCategoriesData[selectedCategory].forEach(sub => {
                const option = document.createElement('option');
                option.value = sub.value;
                option.textContent = sub.text;
                income_subCategory.appendChild(option);
            });
        }
    });

    income_subCategory.addEventListener('change', function () {
        const selectedSubCategory = income_subCategory.value;

        // أولاً: أخفِ جميع حقول الحيوانات والـ "أخرى" ومسح قيمها
        income_otherSubCategoryContainer.classList.add('hidden');
        income_otherSubCategory.value = '';
        income_otherSubCategory.removeAttribute('required');

        hideAndClearAllAnimalFields(); // استدعاء الدالة الجديدة لإخفاء الحيوانات

        // ثم أظهر الحقل المناسب بناءً على الاختيار
        if (selectedSubCategory === "Other") {
            income_otherSubCategoryContainer.classList.remove('hidden');
            income_otherSubCategory.setAttribute('required', 'true');
        } else if (selectedSubCategory === "Buffalo Sales") {
            animalBuffaloSelectContainer.classList.remove('hidden');
            animalBuffaloSelect.setAttribute('required', 'true');
        } else if (selectedSubCategory === "Cow Sales") {
            animalCowSelectContainer.classList.remove('hidden');
            animalCowSelect.setAttribute('required', 'true');
        }
    });

    // الدالة المسؤولة عن تحديث الحقل المخفي لاسم الحيوان
    function updateAnimalNameHiddenField() {
        let selectedOption = null;
        if (!animalBuffaloSelectContainer.classList.contains('hidden')) {
            // إذا كانت قائمة الجاموس ظاهرة، استخدمها
            selectedOption = animalBuffaloSelect.options[animalBuffaloSelect.selectedIndex];
        } else if (!animalCowSelectContainer.classList.contains('hidden')) {
            // إذا كانت قائمة الأبقار ظاهرة، استخدمها
            selectedOption = animalCowSelect.options[animalCowSelect.selectedIndex];
        }

        if (selectedOption && selectedOption.dataset.name) {
            animalNameHiddenField.value = selectedOption.dataset.name;
        } else {
            animalNameHiddenField.value = ''; // مسح القيمة إذا لم يتم تحديد حيوان
        }
        console.log('Animal Name Hidden Field Value:', animalNameHiddenField.value); // للتصحيح
    }

    // استمع لحدث التغيير على قوائم الحيوانات المنسدلة لتحديث الحقل المخفي
    animalBuffaloSelect.addEventListener('change', updateAnimalNameHiddenField);
    animalCowSelect.addEventListener('change', updateAnimalNameHiddenField);


    // الكود الخاص بتحديث اسم العميل (الكود الأصلي الخاص بك)
    const buyerSelect = document.getElementById('buyer_select');
    const buyerNameHiddenField = document.getElementById('buyer_name_hidden_field');

    // **الدالة المسؤولة عن تحديث الحقل المخفي لاسم العميل**
    function updateBuyerNameHiddenField() {
        const selectedOption = buyerSelect.options[buyerSelect.selectedIndex];
        if (selectedOption && selectedOption.dataset.name) {
            buyerNameHiddenField.value = selectedOption.dataset.name;
        } else {
            buyerNameHiddenField.value = '';
        }
        console.log('Buyer Name Hidden Field Value:', buyerNameHiddenField.value); // للتصحيح
    }

    // استمع لحدث التغيير على الـ droplist
    buyerSelect.addEventListener('change', updateBuyerNameHiddenField);

    // **مهم جداً: استدعاء الدالة عند تحميل الصفحة**
    document.addEventListener('DOMContentLoaded', updateBuyerNameHiddenField);


    // قبل إرسال الفورم، لو تم اختيار "أخرى"
    document.getElementById('income_form').addEventListener('submit', function(e) {
        // تأكد من تحديث اسم العميل قبل الإرسال مباشرة
        updateBuyerNameHiddenField();

        // **تحديث اسم الحيوان قبل الإرسال مباشرة**
        updateAnimalNameHiddenField();

        // منطق حقل "أخرى"
        if (income_subCategory.value === "Other") {
            if (income_otherSubCategory.value.trim() === '') {
                e.preventDefault(); // منع الإرسال
                alert('يرجى إدخال التوزيع الفرعي الآخر.');
                income_otherSubCategory.focus();
                return false;
            } else {
                income_subCategory.value = income_otherSubCategory.value.trim();
            }
        }

        // **الشرط الجديد: التحقق من اختيار الحيوان إذا كانت الفئة "Buffalo Sales" أو "Cow Sales"**
        const selectedSubCategory = income_subCategory.value;
        if (selectedSubCategory === "Buffalo Sales") {
            if (animalBuffaloSelect.value === '') {
                e.preventDefault(); // منع الإرسال
                alert('يرجى اختيار اسم الجاموس.');
                animalBuffaloSelect.focus();
                return false;
            }
        } else if (selectedSubCategory === "Cow Sales") {
            if (animalCowSelect.value === '') {
                e.preventDefault(); // منع الإرسال
                alert('يرجى اختيار اسم البقرة.');
                animalCowSelect.focus();
                return false;
            }
        }
    });

    // مهم جداً: عند تحميل الصفحة، تأكد من إخفاء حقول الحيوانات بشكل افتراضي
    document.addEventListener('DOMContentLoaded', function() {
        hideAndClearAllAnimalFields();
    });
</script>
