
<div id="edit-form" class="fixed inset-0 z-50 {{ $isVisible ? '' : 'hidden' }} overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
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
                    تعديل ايراد
                </h3>
                <button type="button" onclick="closeForm('edit-form')" class="text-gray-400 hover:text-gray-500 transition-colors focus:outline-none">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            @if(isset($item))
            <form action="{{ route('income.update' , $item->id) }}" method="POST" id="edit_income_form" class="p-6"> {{-- غيّرت الـ ID هنا لكي لا يتعارض مع الـ ID الخاص بـ div --}}
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- العمود الأول --}}
                    <div class="space-y-5">
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">فئة الإيرادات<span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select id="income_mainCategory_edit" name="category" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none appearance-none" required>
                                    <option value="">اختر فئة الإيراد</option>
                                    <option value="Product Sales" {{ $item->category == 'Product Sales' ? 'selected' : '' }}>بيع منتجات</option>
                                    <option value="Animal Sales" {{ $item->category == 'Animal Sales' ? 'selected' : '' }}>بيع بهائم</option>
                                    <option value="Equipment Sales" {{ $item->category == 'Equipment Sales' ? 'selected' : '' }}>بيع معدات أو أثاث</option>
                                    <option value="Rent Income" {{ $item->category == 'Rent Income' ? 'selected' : '' }}>إيجار</option>
                                    <option value="Collections" {{ $item->category == 'Collections' ? 'selected' : '' }}>تحصيل ديون</option>
                                    <option value="Other" {{ $item->category == 'Other' ? 'selected' : '' }}>أخرى</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-4 text-gray-500">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <div class="relative mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">نوع الايراد<span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select id="income_subCategory_edit" name="type" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none appearance-none" required>
                                    <option value="">اختر التوزيع الفرعي</option>
                                    {{-- الخيارات سيتم ملؤها بواسطة JS بناءً على الفئة الرئيسية وقيمة $item->type --}}
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-4 text-gray-500">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        {{-- **بداية إضافة حقول اختيار الحيوانات (مع قيم التعديل)** --}}
                        <div id="animal_buffalo_select_container_edit" class="relative mt-4 hidden">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">كود الجاموس<span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select id="animal_buffalo_select_edit" name="animal_code" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none appearance-none">
                                    <option value="">اختر الجاموس</option>
                                    @isset($allbuffaloes)
                                        @foreach($allbuffaloes as $animal)
                                            <option value="{{ $animal->animal_code }}" data-name="{{ $animal->animal_code }}" {{ isset($item->animal_code) && $item->animal_code == $animal->animal_code ? 'selected' : '' }}>
                                                {{ $animal->animal_code }}
                                            </option>
                                        @endforeach
                                    @endisset
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-4 text-gray-500">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <div id="animal_cow_select_container_edit" class="relative mt-4 hidden">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">كود البقرة<span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select id="animal_cow_select_edit" name="animal_code" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none appearance-none">
                                    <option value="">اختر البقرة</option>
                                    @isset($allcows)
                                        @foreach($allcows as $animal)
                                            <option value="{{ $animal->animal_code }}" data-name="{{ $animal->animal_code }}" {{ isset($item->animal_code) && $item->animal_code == $animal->animal_code ? 'selected' : '' }}>
                                                {{ $animal->animal_code }}
                                            </option>
                                        @endforeach
                                    @endisset
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-4 text-gray-500">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        {{-- حقل مخفي لحفظ اسم/كود الحيوان، سيتم ملؤه بواسطة JavaScript --}}
                        <input type="hidden" id="animal_code_hidden_field_edit" name="animal_code_hidden" value="{{ $item->animal_code ?? '' }}">
                        {{-- **نهاية إضافة حقول اختيار الحيوانات** --}}

                        <div id="income_otherSubCategoryContainer_edit" class="relative mt-4 {{ $item->category == 'Other' && !in_array($item->type, array_column(array_merge(...array_values($income_subCategoriesData)), 'value')) ? '' : 'hidden' }}">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">التوزيع الفرعي الآخر<span class="text-red-500">*</span></label>
                            <input type="text" id="income_otherSubCategory_edit" name="other_type" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" placeholder="اكتب التوزيع الفرعي هنا" value="{{ $item->type }}">
                        </div>

                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">تفاصيل<span class="text-red-500">*</span></label>
                            <input type="text" name="description" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" value="{{ $item->description }}" required>
                        </div>

                         <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">التاريخ<span class="text-red-500">*</span></label>
                            <input type="date" name="date" max="{{ date('Y-m-d') }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none"
                                   value="{{ \Carbon\Carbon::parse($item->date)->format('Y-m-d') }}" required>
                        </div>

                        {{-- **تعديل حقول العميل لاستخدام Dropdown كما في فورم الإضافة** --}}
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">اسم العميل<span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select id="buyer_select_edit" name="buyer_id" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none appearance-none" required>
                                    <option value="">اختر العميل</option>
                                    @isset($buyers)
                                        @foreach($buyers as $buyer)
                                            <option value="{{ $buyer->id }}" data-name="{{ $buyer->name }}" {{ $item->buyer_id == $buyer->id ? 'selected' : '' }}>
                                                {{ $buyer->name }} (كود: {{ $buyer->id }})
                                            </option>
                                        @endforeach
                                    @endisset
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-4 text-gray-500">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="buyer_name_hidden_field_edit" name="buyer_name" value="{{ $item->buyer_name ?? '' }}">
                        {{-- **نهاية تعديل حقول العميل** --}}

                    </div>

                    {{-- العمود الثاني --}}
                    <div class="space-y-5">
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">الكمية<span class="text-red-500">*</span></label>
                            <input type="number" name="quantity" min="0" step="1" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" value="{{ $item->quantity }}" required>
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">سعر الوحدة<span class="text-red-500">*</span></label>
                            <input type="number" name="unit_price" min="0" step="1" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" value="{{ $item->unit_price }}" required>
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">القيمة<span class="text-red-500">*</span></label>
                            <input type="number" name="amount" min="0" step="1" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" value="{{ $item->amount }}" required>
                        </div>

                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">المدفوع<span class="text-red-500">*</span></label>
                            <input type="number" name="paid" min="0" step="1" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" value="{{ $item->paid }}" required>
                        </div>

                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">الباقي<span class="text-red-500">*</span></label>
                            <input type="number" name="remaining" min="0" step="1" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none" value="{{ $item->remaining }}" required>
                        </div>

                         <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5 font-tajawal">تاريخ تحصيل الباقي <span class="text-red-500">*</span></label>
                            <input type="date" name="payment_due_date" min="{{ date('Y-m-d') }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200 outline-none"
                                   value="{{ isset($item->payment_due_date) ? \Carbon\Carbon::parse($item->payment_due_date)->format('Y-m-d') : '' }}">
                        </div>
                    </div>
                </div>

                {{-- أزرار --}}
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
    const income_subCategoriesData_edit = { // غيرت اسم المتغير لتجنب التعارض
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

    const income_mainCategory_edit = document.getElementById('income_mainCategory_edit');
    const income_subCategory_edit = document.getElementById('income_subCategory_edit');
    const income_otherSubCategoryContainer_edit = document.getElementById('income_otherSubCategoryContainer_edit');
    const income_otherSubCategory_edit = document.getElementById('income_otherSubCategory_edit');

    // **بداية إضافة عناصر الحيوانات الجديدة**
    const animalBuffaloSelectContainer_edit = document.getElementById('animal_buffalo_select_container_edit');
    const animalBuffaloSelect_edit = document.getElementById('animal_buffalo_select_edit');
    const animalCowSelectContainer_edit = document.getElementById('animal_cow_select_container_edit');
    const animalCowSelect_edit = document.getElementById('animal_cow_select_edit');
    const animalCodeHiddenField_edit = document.getElementById('animal_code_hidden_field_edit');
    // **نهاية إضافة عناصر الحيوانات الجديدة**

    // دالة جديدة لإخفاء جميع حقول الحيوانات ومسح قيمها وإزالة خاصية required
    function hideAndClearAllAnimalFields_edit() {
        animalBuffaloSelectContainer_edit.classList.add('hidden');
        animalCowSelectContainer_edit.classList.add('hidden');
        animalBuffaloSelect_edit.removeAttribute('required');
        animalCowSelect_edit.removeAttribute('required');
        animalBuffaloSelect_edit.value = ''; // مسح القيمة المختارة
        animalCowSelect_edit.value = '';     // مسح القيمة المختارة
        animalCodeHiddenField_edit.value = ''; // مسح كود الحيوان المخفي
    }

    // دالة لملء التوزيعات الفرعية بناءً على الفئة الرئيسية
    function populateSubCategories_edit(selectedCategory, currentType = null) {
        income_subCategory_edit.innerHTML = '<option value="">اختر التوزيع الفرعي</option>';
        if (income_subCategoriesData_edit[selectedCategory]) {
            income_subCategoriesData_edit[selectedCategory].forEach(sub => {
                const option = document.createElement('option');
                option.value = sub.value;
                option.textContent = sub.text;
                // قم بتحديد الخيار إذا كان يطابق النوع الحالي
                if (currentType && sub.value === currentType) {
                    option.selected = true;
                }
                income_subCategory_edit.appendChild(option);
            });
        }
    }

    // دالة لتهيئة حالة حقول الحيوانات وحقل "أخرى"
    function initializeDynamicFields_edit(selectedCategory, selectedSubCategory, animalCode) {
        // أخفِ الكل أولاً
        income_otherSubCategoryContainer_edit.classList.add('hidden');
        income_otherSubCategory_edit.removeAttribute('required');
        hideAndClearAllAnimalFields_edit();

        // املأ التوزيعات الفرعية أولاً
        populateSubCategories_edit(selectedCategory, selectedSubCategory);

        // ثم أظهر الحقل المناسب بناءً على التوزيع الفرعي المحدد
        if (selectedSubCategory === "Other") {
            income_otherSubCategoryContainer_edit.classList.remove('hidden');
            income_otherSubCategory_edit.setAttribute('required', 'true');
            income_otherSubCategory_edit.value = selectedSubCategory; // عرض القيمة في حقل "أخرى"
        } else if (selectedSubCategory === "Buffalo Sales") {
            animalBuffaloSelectContainer_edit.classList.remove('hidden');
            animalBuffaloSelect_edit.setAttribute('required', 'true');
            animalBuffaloSelect_edit.value = animalCode; // تعيين قيمة الجاموس المختارة
            animalCodeHiddenField_edit.value = animalCode; // تحديث الحقل المخفي
        } else if (selectedSubCategory === "Cow Sales") {
            animalCowSelectContainer_edit.classList.remove('hidden');
            animalCowSelect_edit.setAttribute('required', 'true');
            animalCowSelect_edit.value = animalCode; // تعيين قيمة البقرة المختارة
            animalCodeHiddenField_edit.value = animalCode; // تحديث الحقل المخفي
        }
    }


    income_mainCategory_edit.addEventListener('change', function () {
        const selectedCategory = income_mainCategory_edit.value;
        populateSubCategories_edit(selectedCategory); // أعد ملء القائمة بدون قيمة حالية
        // قم بإخفاء كل حقول الحيوانات وحقول "أخرى" عند تغيير الفئة الرئيسية
        hideAndClearAllAnimalFields_edit();
        income_otherSubCategoryContainer_edit.classList.add('hidden');
        income_otherSubCategory_edit.value = '';
        income_otherSubCategory_edit.removeAttribute('required');
    });

    income_subCategory_edit.addEventListener('change', function () {
        const selectedSubCategory = income_subCategory_edit.value;

        // أخفِ كل حقول الحيوانات وحقول "أخرى" ومسح قيمها
        hideAndClearAllAnimalFields_edit();
        income_otherSubCategoryContainer_edit.classList.add('hidden');
        income_otherSubCategory_edit.value = '';
        income_otherSubCategory_edit.removeAttribute('required');

        // أظهر الحقل المناسب بناءً على الاختيار الجديد
        if (selectedSubCategory === "Other") {
            income_otherSubCategoryContainer_edit.classList.remove('hidden');
            income_otherSubCategory_edit.setAttribute('required', 'true');
        } else if (selectedSubCategory === "Buffalo Sales") {
            animalBuffaloSelectContainer_edit.classList.remove('hidden');
            animalBuffaloSelect_edit.setAttribute('required', 'true');
        } else if (selectedSubCategory === "Cow Sales") {
            animalCowSelectContainer_edit.classList.remove('hidden');
            animalCowSelect_edit.setAttribute('required', 'true');
        }
    });

    // الدالة المسؤولة عن تحديث الحقل المخفي لكود الحيوان
    function updateAnimalCodeHiddenField_edit() {
        let selectedOption = null;
        if (!animalBuffaloSelectContainer_edit.classList.contains('hidden')) {
            selectedOption = animalBuffaloSelect_edit.options[animalBuffaloSelect_edit.selectedIndex];
        } else if (!animalCowSelectContainer_edit.classList.contains('hidden')) {
            selectedOption = animalCowSelect_edit.options[animalCowSelect_edit.selectedIndex];
        }

        if (selectedOption && selectedOption.dataset.name) {
            animalCodeHiddenField_edit.value = selectedOption.dataset.name;
        } else {
            animalCodeHiddenField_edit.value = ''; // مسح القيمة إذا لم يتم تحديد حيوان
        }
        console.log('Animal Code Hidden Field Value (Edit):', animalCodeHiddenField_edit.value);
    }

    // استمع لحدث التغيير على قوائم الحيوانات المنسدلة لتحديث الحقل المخفي
    animalBuffaloSelect_edit.addEventListener('change', updateAnimalCodeHiddenField_edit);
    animalCowSelect_edit.addEventListener('change', updateAnimalCodeHiddenField_edit);


    // الكود الخاص بتحديث اسم العميل (تم تعديله ليستخدم Dropdown)
    const buyerSelect_edit = document.getElementById('buyer_select_edit');
    const buyerNameHiddenField_edit = document.getElementById('buyer_name_hidden_field_edit');

    // الدالة المسؤولة عن تحديث الحقل المخفي لاسم العميل (في فورم التعديل)
    function updateBuyerNameHiddenField_edit() {
        const selectedOption = buyerSelect_edit.options[buyerSelect_edit.selectedIndex];
        if (selectedOption && selectedOption.dataset.name) {
            buyerNameHiddenField_edit.value = selectedOption.dataset.name;
        } else {
            buyerNameHiddenField_edit.value = '';
        }
        console.log('Buyer Name Hidden Field Value (Edit):', buyerNameHiddenField_edit.value);
    }

    // استمع لحدث التغيير على الـ droplist للعميل
    buyerSelect_edit.addEventListener('change', updateBuyerNameHiddenField_edit);

    // عند تحميل الصفحة (أو عند فتح الفورم)
    document.addEventListener('DOMContentLoaded', function() {
        const item = @json($item ?? null); // جلب بيانات العنصر من Blade إلى JavaScript
        if (item) {
            // تهيئة الفئة الرئيسية والتوزيع الفرعي وحقل "أخرى" أو الحيوانات
            income_mainCategory_edit.value = item.category;
            initializeDynamicFields_edit(item.category, item.type, item.animal_code);

            // تهيئة حقول العميل
            updateBuyerNameHiddenField_edit(); // لتعيين القيمة المخفية الأولية
        } else {
            // في حالة عدم وجود item (الفورم فارغ لأي سبب)
            hideAndClearAllAnimalFields_edit();
            income_otherSubCategoryContainer_edit.classList.add('hidden');
        }
    });

    // قبل إرسال الفورم (submit)
    document.getElementById('edit_income_form').addEventListener('submit', function(e) {
        // تأكد من تحديث اسم العميل وكود الحيوان قبل الإرسال مباشرة
        updateBuyerNameHiddenField_edit();
        updateAnimalCodeHiddenField_edit();

        // منطق حقل "أخرى"
        if (income_subCategory_edit.value === "Other") {
            if (income_otherSubCategory_edit.value.trim() === '') {
                e.preventDefault(); // منع الإرسال
                alert('يرجى إدخال التوزيع الفرعي الآخر.');
                income_otherSubCategory_edit.focus();
                return false;
            } else {
                income_subCategory_edit.value = income_otherSubCategory_edit.value.trim();
            }
        }

        // **التحقق من اختيار الحيوان إذا كانت الفئة "Buffalo Sales" أو "Cow Sales"**
        const selectedSubCategory = income_subCategory_edit.value;
        if (selectedSubCategory === "Buffalo Sales") {
            if (animalBuffaloSelect_edit.value === '') {
                e.preventDefault(); // منع الإرسال
                alert('يرجى اختيار كود الجاموس.');
                animalBuffaloSelect_edit.focus();
                return false;
            }
        } else if (selectedSubCategory === "Cow Sales") {
            if (animalCowSelect_edit.value === '') {
                e.preventDefault(); // منع الإرسال
                alert('يرجى اختيار كود البقرة.');
                animalCowSelect_edit.focus();
                return false;
            }
        }
    });

    // دالة إغلاق الفورم (تأكد من مطابقتها مع اسم الـ ID الجديد للفورم)
    function closeForm(formId) {
        document.getElementById(formId).classList.add('hidden');
    }
</script>
