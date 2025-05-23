<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('إدارة الحيوانات') }}
        </h2>
    </x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8 bg-gray-50 min-h-screen">
        {{-- رسائل التنبيه --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded">
                <div class="flex justify-between items-center">
                    <p>{{ session('success') }}</p>
                    <button onclick="this.parentElement.parentElement.remove()" class="text-green-700">&times;</button>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded">
                <div class="flex justify-between items-center">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button onclick="this.parentElement.parentElement.remove()" class="text-red-700">&times;</button>
                </div>
            </div>
        @endif

      {{-- قسم الأزرار --}}
      <div class="mb-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">

        <button onclick="toggleForm()" class="group text-center bg-white rounded-xl shadow-md p-6 flex flex-col items-center justify-center transition duration-200 hover:shadow-lg hover:bg-gray-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600 transition duration-200 group-hover:text-blue-700" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                <p class="font-semibold text-gray-800 mt-2 text-sm md:text-base">حيوان جديد</p>
            </button>

        <button onclick="dailyProdectionForm()" class="group text-center bg-white rounded-xl shadow-md p-6 flex flex-col items-center justify-center transition duration-200 hover:shadow-lg hover:bg-gray-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600 transition duration-200 group-hover:text-blue-700" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                <p class="font-semibold text-gray-800 mt-2 text-sm md:text-base">الانتاج اليومي</p>
            </button>

        <button onclick="dailyConsumptionsForm()" class="group text-center bg-white rounded-xl shadow-md p-6 flex flex-col items-center justify-center transition duration-200 hover:shadow-lg hover:bg-gray-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600 transition duration-200 group-hover:text-blue-700" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                <p class="font-semibold text-gray-800 mt-2 text-sm md:text-base">الاستهلاك اليومي</p>
            </button>

        <button onclick="dailyExpenseForm()" class="group text-center bg-white rounded-xl shadow-md p-6 flex flex-col items-center justify-center transition duration-200 hover:shadow-lg hover:bg-gray-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600 transition duration-200 group-hover:text-blue-700" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                <p class="font-semibold text-gray-800 mt-2 text-sm md:text-base">تسجيل مصروف</p>
            </button>

        <button onclick="incomeForm()" class="group text-center bg-white rounded-xl shadow-md p-6 flex flex-col items-center justify-center transition duration-200 hover:shadow-lg hover:bg-gray-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600 transition duration-200 group-hover:text-blue-700" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                <p class="font-semibold text-gray-800 mt-2 text-sm md:text-base">تسجيل ايراد</p>
            </button>

        <button onclick="toggleHealthForm()" class="group text-center bg-white rounded-xl shadow-md p-6 flex flex-col items-center justify-center transition duration-200 hover:shadow-lg hover:bg-gray-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600 transition duration-200 group-hover:text-blue-700" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                <p class="font-semibold text-gray-800 mt-2 text-sm md:text-base">تسجيل تقرير صحي</p>
            </button>
        </div>

        {{-- قسم الرسومات البيانية --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-6 gap-6 mt-10">
            {{-- كل بطاقة رسم بياني --}}
            {{-- تم تعديل الـ div الخارجية لكل بطاقة رسم بياني لتكون نقطة التوهج --}}
            <div class="text-center bg-white rounded-xl shadow-md p-6 flex flex-col items-center justify-between transition-all duration-200">
                {{-- حاوية الرسم البياني --}}
                <div class="w-full aspect-square mx-auto relative mb-2 flex items-center justify-center">
                    <canvas id="chart1" class="block w-full h-full"></canvas>
                    {{-- تم إضافة div لعلامة التعجب هنا --}}
                    <div id="chartAlert1" class="absolute inset-0 flex items-center justify-center text-red-500 hidden opacity-0 transition-opacity duration-200">
                         <span class="text-6xl font-bold">!</span>
                    </div>
                </div>
                <p class="font-semibold">التبن</p>
            </div>
            <div class="text-center bg-white rounded-xl shadow-md p-6 flex flex-col items-center justify-between transition-all duration-200">
                <div class="w-full aspect-square mx-auto relative mb-2 flex items-center justify-center">
                    <canvas id="chart2" class="block w-full h-full"></canvas>
                     <div id="chartAlert2" class="absolute inset-0 flex items-center justify-center text-red-500 hidden opacity-0 transition-opacity duration-200">
                         <span class="text-6xl font-bold">!</span>
                    </div>
                </div>
                <p class="font-semibold">ذرة</p>
            </div>
            <div class="text-center bg-white rounded-xl shadow-md p-6 flex flex-col items-center justify-between transition-all duration-200">
                <div class="w-full aspect-square mx-auto relative mb-2 flex items-center justify-center">
                    <canvas id="chart3" class="block w-full h-full"></canvas>
                     <div id="chartAlert3" class="absolute inset-0 flex items-center justify-center text-red-500 hidden opacity-0 transition-opacity duration-200">
                         <span class="text-6xl font-bold">!</span>
                    </div>
                </div>
                <p class="font-semibold">صويا</p>
            </div>
            <div class="text-center bg-white rounded-xl shadow-md p-6 flex flex-col items-center justify-between transition-all duration-200">
                <div class="w-full aspect-square mx-auto relative mb-2 flex items-center justify-center">
                    <canvas id="chart4" class="block w-full h-full"></canvas>
                     <div id="chartAlert4" class="absolute inset-0 flex items-center justify-center text-red-500 hidden opacity-0 transition-opacity duration-200">
                         <span class="text-6xl font-bold">!</span>
                    </div>
                </div>
                <p class="font-semibold">قشر صويا</p>

            </div>
            <div class="text-center bg-white rounded-xl shadow-md p-6 flex flex-col items-center justify-between transition-all duration-200">
                <div class="w-full aspect-square mx-auto relative mb-2 flex items-center justify-center">
                    <canvas id="chart5" class="block w-full h-full"></canvas>
                     <div id="chartAlert5" class="absolute inset-0 flex items-center justify-center text-red-500 hidden opacity-0 transition-opacity duration-200">
                         <span class="text-6xl font-bold">!</span>
                    </div>
                </div>
                <p class="font-semibold">ردة</p>

            </div>
            <div class="text-center bg-white rounded-xl shadow-md p-6 flex flex-col items-center justify-between transition-all duration-200">
                <div class="w-full aspect-square mx-auto relative mb-2 flex items-center justify-center">
                    <canvas id="chart6" class="block w-full h-full"></canvas>
                     <div id="chartAlert6" class="absolute inset-0 flex items-center justify-center text-red-500 hidden opacity-0 transition-opacity duration-200">
                         <span class="text-6xl font-bold">!</span>
                    </div>
                </div>
                <p class="font-semibold">سيلاج</p>

            </div>
        </div>


        {{-- قسم الإشعارات --}}
        <h3 class="text-xl font-bold text-gray-800 mb-4 mt-8">الإشعارات</h3>
        <div class="bg-white rounded-xl shadow-md p-6">
            @if(empty($notifications))
                <p class="text-gray-600 text-center">لا توجد إشعارات حاليًا.</p>
            @else
                <ul class="divide-y divide-gray-200">
                    @foreach($notifications as $notification)
                        <li class="py-3 flex items-start space-x-3 rtl:space-x-reverse">
                            {{-- أيقونة الإشعار حسب الأهمية --}}
                            <div class="flex-shrink-0">
                                @if(isset($notification->importance) && $notification->importance === 'high')
                                    <svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                @else
                                    <svg class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                @endif
                            </div>
                            <div class="flex-1">
                                <p class="text-gray-800 font-semibold">{{ $notification->title ?? 'إشعار' }}</p>
                                <p class="text-gray-600 text-sm">{{ $notification->description ?? '' }}</p>
                                <p class="text-gray-500 text-xs mt-1">{{ $notification->created_at->format('Y-m-d H:i') ?? '' }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <h3 class="text-xl font-bold text-gray-800 mb-4 mt-8">آخر الانشطة</h3>
        <div class="bg-white rounded-xl shadow-md p-6">
            @if(empty($latest_operations))
                <p class="text-gray-600 text-center">لا توجد عمليات مسجلة حتى الآن.</p>
            @else
                <ul class="divide-y divide-gray-200">
                    @foreach($latest_operations as $operation)
                        <li class="py-3 flex justify-between items-center">
                            <div>
                                <p class="text-gray-800 font-semibold">{{ $operation->type ?? 'غير محدد' }}</p>
                                <p class="text-gray-600 text-sm">{{ $operation->description ?? '' }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-gray-700">{{ $operation->amount ?? $operation->quantity ?? '' }} {{ $operation->unit ?? '' }}</p>
                                <p class="text-gray-500 text-xs">{{ $operation->created_at->format('Y-m-d H:i') ?? '' }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    {{-- مودال إضافة الحيوان --}}
    @include('components.animal-form', [
        'modalId' => 'add-form',
        'title' => 'إضافة حيوان جديد',
        'formAction' => route('animals.store'),
        'isVisible' => false,
        'method' => 'POST',
        'animal' => null,
        'buttonText' => 'إضافة'
    ])
    {{-- موديل اضافة الانتاج اليومي --}}
    @include('components.daily-prodection-form', [
        'modalId' => 'daily-prodection-form',
        'title' => 'اضافة الانتاج اليومي',
        'formAction' => route('animals.store'),
        'isVisible' => false,
        'method' => 'POST',
        'animal' => null,
        'buttonText' => 'إضافة'
    ])
    {{-- موديل اضافة الاستهلاك اليومي --}}
    @include('components.daily-consumptions-form', [
        'modalId' => 'daily-consumptions-form',
        'title' => 'اضافة الاستهلاك اليومي',
        'formAction' => route('animals.store'),
        'isVisible' => false,
        'method' => 'POST',
        'animal' => null,
        'buttonText' => 'إضافة'
    ])
    {{-- موديل اضافة الاستهلاك اليومي --}}
    @include('components.expense-form', [
        'modalId' => 'expense-form',
        'title' => 'اضافة مصاريف',
        'formAction' => route('expense.store'),
        'isVisible' => false,
        'method' => 'POST',
        'animal' => null,
        'buttonText' => 'إضافة'
    ])
    {{-- موديل اضافة الاستهلاك اليومي --}}
    @include('components.income-form', [
        'modalId' => 'income-form',
        'title' => 'اضافة ايراد',
        'formAction' => route('income.store'),
        'isVisible' => false,
        'method' => 'POST',
        'animal' => null,
        'buttonText' => 'إضافة'
    ])
    {{-- موديل اضافة الاستهلاك اليومي --}}
    @include('components.health-report-form', [
        'modalId' => 'health-form',
        'title' => 'اضافة تقرير صحي',
        'formAction' => route('income.store'),
        'isVisible' => false,
        'method' => 'POST',
        'animal' => null,
        'buttonText' => 'إضافة'
    ])

    <script>
        // دوال المودال - لم يتم تعديلها بناءً على طلبك
        function toggleForm() {
            const modal = document.getElementById('add-form');
            modal.classList.toggle('hidden');
        }
        function dailyProdectionForm() {
            const modal2 = document.getElementById('daily-prodection-form');
            modal2.classList.toggle('hidden');
        }
        function dailyConsumptionsForm() {
            const modal3 = document.getElementById('daily-consumptions-form');
            modal3.classList.toggle('hidden');
        }
        function dailyExpenseForm() {
            const modal4 = document.getElementById('expense-form');
            modal4.classList.toggle('hidden');
        }
        function incomeForm() {
            const modal5 = document.getElementById('income-form');
            modal5.classList.toggle('hidden');
        }
        function toggleHealthForm() {
            const modal6 = document.getElementById('health-form');
            modal6.classList.toggle('hidden');
        }

        document.addEventListener('click', function (e) {
            const modals = [
                { el: document.getElementById('add-form'), toggle: toggleForm },
                { el: document.getElementById('daily-prodection-form'), toggle: dailyProdectionForm },
                { el: document.getElementById('daily-consumptions-form'), toggle: dailyConsumptionsForm },
                { el: document.getElementById('expense-form'), toggle: dailyExpenseForm },
                { el: document.getElementById('income-form'), toggle: incomeForm },
                { el: document.getElementById('health-form'), toggle: toggleHealthForm },
            ];

            modals.forEach(modal => {
                if (modal.el) {
                    const form = modal.el.querySelector('form');
                    const clickedInside = (form && form.contains(e.target)) || e.target.closest('button[onclick="' + modal.toggle.name + '()"]');

                    if (!modal.el.classList.contains('hidden') && !clickedInside) {
                        modal.toggle();
                    }
                }
            });
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === "Escape") {
                const modals = [
                    { el: document.getElementById('add-form'), toggle: toggleForm },
                    { el: document.getElementById('daily-prodection-form'), toggle: dailyProdectionForm },
                    { el: document.getElementById('daily-consumptions-form'), toggle: dailyConsumptionsForm },
                    { el: document.getElementById('expense-form'), toggle: dailyExpenseForm },
                    { el: document.getElementById('income-form'), toggle: incomeForm },
                    { el: document.getElementById('health-form'), toggle: toggleHealthForm },
                ];

                modals.forEach(modal => {
                    if (modal.el && !modal.el.classList.contains('hidden')) {
                        modal.toggle();
                    }
                });
            }
        });

        // Chart.js Plugins for custom text inside doughnut charts
        const doughnutTextPlugin = {
            id: 'doughnutText',
            beforeDraw: (chart, args, options) => {
                if (chart.config.type === 'doughnut') {
                    const { ctx, width, height } = chart;
                    ctx.restore();

                    // تحديد إذا كان يجب إظهار علامة التعجب بدلاً من النسبة
                    const showExclamation = options.showExclamation;
                    const text = showExclamation ? '!' : `${options.percentage}%`;
                    const fontSize = (height / (showExclamation ? 2.5 : 5)).toFixed(2); // حجم أكبر لعلامة التعجب
                    const color = showExclamation ? options.exclamationColor || '#ef4444' : options.color || '#333';


                    ctx.font = `bold ${fontSize}px sans-serif`;
                    ctx.textBaseline = "middle";
                    ctx.textAlign = 'center';
                    ctx.fillStyle = color;
                    ctx.fillText(text, width / 2, height / 2);
                    ctx.save();
                }
            }
        };

        // Register the plugin globally
        Chart.register(doughnutTextPlugin);

        // Function to create Doughnut Charts
        function createDoughnutChart(id, percentage, chartTitle) {
            const ctx = document.getElementById(id);
            if (!ctx) {
                console.warn(`Canvas element with ID '${id}' not found.`);
                return;
            }

            // تدمير الرسم البياني القديم إذا كان موجودًا
            if (Chart.getChart(id)) {
                Chart.getChart(id).destroy();
            }

            let color;
            let showAlertText = false; // لإظهار نص "المخزون ينفذ"
            let showExclamationMark = false; // لإظهار علامة التعجب في وسط الرسم البياني
            const parentCard = ctx.closest('.text-center'); // الحصول على البطاقة الأم
            const chartAlertDiv = document.getElementById(`chartAlert${id.replace('chart', '')}`); // حاوية علامة التعجب
            const alertTextDiv = document.getElementById(`alert${id.replace('chart', '')}`); // حاوية نص "المخزون ينفذ"

            if (percentage < 15) {
                color = '#ef4444'; // أحمر (Tailwind red-500)
                showAlertText = true;
                showExclamationMark = true;
            } else if (percentage < 40) {
                color = '#f97316'; // برتقالي (Tailwind orange-500)
                showAlertText = false; // لا تعرض نص التنبيه للبرتقالي
            } else {
                color = '#22c55e'; // أخضر (Tailwind green-500)
                showAlertText = false;
            }

            const chartInstance = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [percentage, 100 - percentage],
                        backgroundColor: [color, '#e5e7eb'],
                        borderColor: 'transparent',
                        hoverOffset: 4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '80%',
                    plugins: {
                        tooltip: { enabled: false },
                        legend: { display: false },
                        doughnutText: {
                            percentage: percentage, // تمرير النسبة المئوية
                            showExclamation: showExclamationMark, // تمرير حالة إظهار علامة التعجب
                            exclamationColor: '#ef4444', // لون علامة التعجب
                            color: '#111827' // لون النص العادي
                        }
                    },
                    animation: {
                        animateRotate: false,
                        animateScale: false
                    },
                    onHover: function(event, elements) {
                        const canvas = event.chart.canvas;
                        canvas.style.cursor = elements.length > 0 ? 'pointer' : 'default';
                    }
                }
            });

            // التحكم في ظهور الوميض لعلامة التعجب والرسم البياني
            if (showExclamationMark) {
                // إظهار وإخفاء علامة التعجب بالوميض
                if (chartAlertDiv) {
                    chartAlertDiv.classList.remove('hidden');
                    chartAlertDiv.classList.add('animate-pulse', 'opacity-100'); // لإظهارها وجعلها تومض
                }
                // إضافة الوميض للبطاقة الأم (الرسم البياني كله)
                if (parentCard) {
                    parentCard.classList.add('animate-pulse');
                }
            } else {
                // إخفاء علامة التعجب وإزالة الوميض
                if (chartAlertDiv) {
                    chartAlertDiv.classList.add('hidden');
                    chartAlertDiv.classList.remove('animate-pulse', 'opacity-100');
                }
                // إزالة الوميض من البطاقة الأم
                if (parentCard) {
                    parentCard.classList.remove('animate-pulse');
                }
            }

            // التحكم في ظهور نص "المخزون ينفذ" أسفل الرسم البياني
            if (alertTextDiv) {
                if (showAlertText) {
                    alertTextDiv.classList.remove('hidden');
                    // animate-pulse موجودة بالفعل على alertTextDiv في HTML، لا داعي لإضافتها هنا مجدداً
                    // لكن إذا كنت تريد إعادة تفعيل الـ animation (مثل إعادة تشغيلها)، يمكنك استخدام الحيل التالية:
                    // alertTextDiv.classList.remove('animate-pulse');
                    // void alertTextDiv.offsetWidth; // Force reflow
                    // alertTextDiv.classList.add('animate-pulse');
                } else {
                    alertTextDiv.classList.add('hidden');
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
           createDoughnutChart('chart1', {{ $hay_net ?? 0 }}, 'التبن'); //
            createDoughnutChart('chart2', {{ $corn_net ?? 0 }}, 'ذرة');    //
            createDoughnutChart('chart3', {{ $soybean_net ?? 0 }}, 'صويا');
            createDoughnutChart('chart4', {{ $soybean_hulls_net ?? 0 }}, 'قشر صويا');
            createDoughnutChart('chart5', {{ $bran_net ?? 0 }}, 'ردة');
            createDoughnutChart('chart6', {{ $silage_net ?? 0 }}, 'سيلاج');
        });
    </script>
</x-app-layout>
