<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('إدارة الحيوانات') }}
        </h2>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8 bg-gray-50/50 min-h-screen">
        {{-- Header Section --}}
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 font-tajawal">لوحة التحكم</h1>
            <p class="text-gray-500 mt-1 font-tajawal">مرحبًا بك في نظام إدارة مزارع سارة</p>
        </div>

        {{-- Alerts Section --}}
        <div class="space-y-4 mb-8">
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" class="flex items-center justify-between p-4 bg-green-50 border-r-4 border-green-500 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 ml-3 text-xl"></i>
                        <p class="text-green-800 font-medium">{{ session('success') }}</p>
                    </div>
                    <button @click="show = false" class="text-green-600 hover:text-green-800 transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @if($errors->any())
                <div x-data="{ show: true }" x-show="show" class="flex items-start justify-between p-4 bg-red-50 border-r-4 border-red-500 rounded-lg shadow-sm">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-circle text-red-500 ml-3 mt-1 text-xl"></i>
                        <ul class="list-disc list-inside text-red-800 space-y-1">
                            @foreach($errors->all() as $error)
                                <li class="font-medium">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button @click="show = false" class="text-red-600 hover:text-red-800 transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif
        </div>

        {{-- Quick Actions Grid --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 mb-10">
            <button onclick="toggleForm()" class="group relative bg-white overflow-hidden rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 p-6 flex flex-col items-center justify-center border border-gray-100 hover:border-brand-100">
                <div class="absolute inset-0 bg-brand-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10 w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-plus text-xl text-blue-600"></i>
                </div>
                <p class="relative z-10 font-bold text-gray-700 group-hover:text-blue-700 transition-colors font-tajawal">حيوان جديد</p>
            </button>

            <button onclick="dailyProdectionForm()" class="group relative bg-white overflow-hidden rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 p-6 flex flex-col items-center justify-center border border-gray-100 hover:border-brand-100">
                <div class="absolute inset-0 bg-brand-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10 w-12 h-12 rounded-full bg-indigo-50 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-industry text-xl text-indigo-600"></i>
                </div>
                <p class="relative z-10 font-bold text-gray-700 group-hover:text-indigo-700 transition-colors font-tajawal">الانتاج اليومي</p>
            </button>

            <button onclick="dailyConsumptionsForm()" class="group relative bg-white overflow-hidden rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 p-6 flex flex-col items-center justify-center border border-gray-100 hover:border-brand-100">
                 <div class="absolute inset-0 bg-brand-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10 w-12 h-12 rounded-full bg-orange-50 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-utensils text-xl text-orange-600"></i>
                </div>
                <p class="relative z-10 font-bold text-gray-700 group-hover:text-orange-700 transition-colors font-tajawal">الاستهلاك اليومي</p>
            </button>

            <button onclick="dailyExpenseForm()" class="group relative bg-white overflow-hidden rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 p-6 flex flex-col items-center justify-center border border-gray-100 hover:border-brand-100">
                 <div class="absolute inset-0 bg-brand-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10 w-12 h-12 rounded-full bg-red-50 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-receipt text-xl text-red-600"></i>
                </div>
                <p class="relative z-10 font-bold text-gray-700 group-hover:text-red-700 transition-colors font-tajawal">تسجيل مصروف</p>
            </button>

            <button onclick="incomeForm()" class="group relative bg-white overflow-hidden rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 p-6 flex flex-col items-center justify-center border border-gray-100 hover:border-brand-100">
                 <div class="absolute inset-0 bg-brand-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10 w-12 h-12 rounded-full bg-green-50 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-money-bill-wave text-xl text-green-600"></i>
                </div>
                <p class="relative z-10 font-bold text-gray-700 group-hover:text-green-700 transition-colors font-tajawal">تسجيل ايراد</p>
            </button>

            <button onclick="toggleHealthForm()" class="group relative bg-white overflow-hidden rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 p-6 flex flex-col items-center justify-center border border-gray-100 hover:border-brand-100">
                 <div class="absolute inset-0 bg-brand-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10 w-12 h-12 rounded-full bg-purple-50 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-heartbeat text-xl text-purple-600"></i>
                </div>
                <p class="relative z-10 font-bold text-gray-700 group-hover:text-purple-700 transition-colors font-tajawal">تقرير صحي</p>
            </button>
        </div>

        {{-- Statistics & Charts Section --}}
        <div class="mb-8">
            <h3 class="text-xl font-bold text-gray-800 mb-6 px-1 flex items-center">
                <i class="fas fa-chart-pie ml-2 text-brand-600"></i>
                موقف المخزون الحالي
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                @php
                    $charts = [
                        ['id' => 'chart1', 'title' => 'التبن', 'key' => 'chartAlert1'],
                        ['id' => 'chart2', 'title' => 'ذرة', 'key' => 'chartAlert2'],
                        ['id' => 'chart3', 'title' => 'صويا', 'key' => 'chartAlert3'],
                        ['id' => 'chart4', 'title' => 'قشر صويا', 'key' => 'chartAlert4'],
                        ['id' => 'chart5', 'title' => 'ردة', 'key' => 'chartAlert5'],
                        ['id' => 'chart6', 'title' => 'سيلاج', 'key' => 'chartAlert6'],
                    ];
                @endphp

                @foreach($charts as $chart)
                    <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 p-5 border border-gray-100">
                        <div class="relative aspect-square w-full flex items-center justify-center mb-3">
                            <canvas id="{{ $chart['id'] }}" class="w-full h-full"></canvas>
                             <div id="{{ $chart['key'] }}" class="absolute inset-0 flex items-center justify-center text-red-500 hidden opacity-0 transition-opacity duration-200 pointer-events-none">
                                 <span class="text-5xl font-bold drop-shadow-sm">!</span>
                            </div>
                        </div>
                        <p class="text-center font-bold text-gray-700">{{ $chart['title'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>




        <!-- Recent Activities Section -->
        <div class="w-full mb-8">
            <h3 class="text-xl font-bold text-gray-800 mb-6 px-1 flex items-center font-tajawal">
                <i class="fas fa-history ml-2 text-brand-600"></i>
                آخر الأنشطة
            </h3>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                @if(empty($latest_operations))
                    <div class="p-8 text-center">
                        <div class="bg-gray-50 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-inbox text-gray-400 text-2xl"></i>
                        </div>
                        <p class="text-gray-500 font-tajawal">لا توجد عمليات مسجلة حتى الآن.</p>
                    </div>
                @else
                    <ul class="divide-y divide-gray-100">
                        @foreach($latest_operations as $operation)
                            <li class="p-4 hover:bg-gray-50 transition-colors duration-200">
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-2 sm:space-y-0">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 ml-4 mt-1">
                                            <div class="w-10 h-10 rounded-full bg-brand-50 flex items-center justify-center border border-brand-100">
                                                <i class="fas fa-clipboard-check text-brand-600"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-gray-900 font-bold font-tajawal text-base">{{ $operation->type ?? 'عملية غير محددة' }}</p>
                                            <p class="text-gray-500 text-sm mt-0.5 font-tajawal">{{ $operation->description ?? '' }}</p>
                                            
                                            @if(!empty($operation->details))
                                                <div class="mt-2 bg-gray-50 text-gray-600 text-xs p-2.5 rounded-lg border border-gray-100 font-mono inline-block">
                                                    {!! nl2br(e($operation->details)) !!}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="flex flex-row sm:flex-col items-center sm:items-end justify-between w-full sm:w-auto pr-14 sm:pr-0">
                                        <div class="flex items-center bg-gray-100 rounded-full px-3 py-1 mb-1 sm:mb-2">
                                            <span class="text-gray-800 font-bold text-sm">{{ $operation->amount ?? $operation->quantity ?? '-' }}</span>
                                            <span class="text-gray-500 text-xs mr-1">{{ $operation->unit ?? '' }}</span>
                                        </div>
                                        <div class="text-gray-400 text-xs flex items-center" dir="ltr">
                                            <i class="far fa-clock ml-1"></i>
                                            <span>{{ $operation->created_at ? $operation->created_at->diffForHumans() : '' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
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
