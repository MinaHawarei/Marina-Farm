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

        {{-- زر الإضافة --}}
        <div class="mb-6 flex flex-wrap gap-3 items-center">
            <button onclick="toggleForm()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                حيوان جديد
            </button>

            <button onclick="dailyProdectionForm()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                الانتاج اليومي
            </button>

            <button onclick="dailyConsumptionsForm()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                الاستهلاك اليومي
            </button>

            <button onclick="dailyExpenseForm()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                تسجيل مصروف
            </button>

            <button onclick="incomeForm()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                تسجيل ايراد
            </button>
        </div>


        <!-- تمثيل بياني مرن -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
            <!-- مخطط حالة القطعان -->
            <div class="bg-white p-6 rounded-lg shadow overflow-hidden">
                <h3 class="text-lg font-bold text-gray-800 mb-4 text-center tracking-wide">حالة قطعان الابقار</h3>
                <div class="relative w-full aspect-square">
                    <canvas id="buffaloStatusChart" class="w-full h-full"></canvas>
                </div>
            </div>

            <!-- مخطط توزيع الحظائر -->
            <div class="bg-white p-6 rounded-lg shadow overflow-hidden">
                <h3 class="text-lg font-bold text-gray-800 mb-4 text-center tracking-wide">توزيع الابقار على الحظائر</h3>
                <div class="relative w-full aspect-square">
                    <canvas id="buffaloPensChart" class="w-full h-full"></canvas>
                </div>
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

    <script>
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

        document.addEventListener('click', function (e) {
            const modals = [
                { el: document.getElementById('add-form'), toggle: toggleForm },
                { el: document.getElementById('daily-prodection-form'), toggle: dailyProdectionForm },
                { el: document.getElementById('daily-consumptions-form'), toggle: dailyConsumptionsForm },
                { el: document.getElementById('expense-form'), toggle: dailyExpenseForm },
                { el: document.getElementById('income-form'), toggle: incomeForm },
            ];

            modals.forEach(modal => {
                const form = modal.el.querySelector('form');
                const clickedInside = form.contains(e.target) || e.target.closest('button[onclick="' + modal.toggle.name + '()"]');

                if (!modal.el.classList.contains('hidden') && !clickedInside) {
                    modal.toggle(); // يقفلها بس لو كانت مفتوحة وتم الضغط خارجها
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

                    ];

                modals.forEach(modal => {
                    if (!modal.el.classList.contains('hidden')) {
                        modal.toggle(); // يقفلها بس لو كانت مفتوحة
                    }
                });
            }
        });

        // بيانات حالة الجاموس
        const statusData = {
            labels: ['حلوب', 'عشار', 'تسمين', 'بطش'],
            datasets: [{
                data: [
                    {{ $dairyCow ?? 0 }},
                    {{ $pregnantCow ?? 0 }},
                    {{ $fatteningCow ?? 0 }},
                    {{ $calfCow ?? 0 }}
                ],
                backgroundColor: ['#3B82F6', '#10B981', '#F59E0B', '#6366F1'],
                borderWidth: 1
            }]
        };

        // بيانات توزيع الحظائر
        const pensData = {
            labels: ['رضاعة', 'فطام', 'تحت التلقيح', 'عشار', 'حلاب', 'انتظار ولادة', 'جفاف'],
            datasets: [{
                data: [
                    {{ $cowPen1 ?? 0 }},
                    {{ $cowPen2 ?? 0 }},
                    {{ $cowPen3 ?? 0 }},
                    {{ $cowPen4 ?? 0 }},
                    {{ $cowPen5 ?? 0 }},
                    {{ $cowPen6 ?? 0 }},
                    {{ $cowPen7 ?? 0 }}
                ],
                backgroundColor: ['#8B5CF6', '#EC4899', '#14B8A6', '#F97316', '#64748B', '#10B981', '#EF4444'],
                borderWidth: 1
            }]
        };

        // إعدادات مشتركة للرسم البياني
        const commonOptions = {
            responsive: true,
            maintainAspectRatio: false,
            aspectRatio: 1, // مربع
            plugins: {
                legend: {
                    position: 'bottom',
                    rtl: true,
                    labels: {
                        usePointStyle: true,
                        font: {
                            family: 'Tajawal, sans-serif',
                            size: 14
                        },
                        padding: 20
                    }
                },
                datalabels: {
                    color: '#fff',
                    font: {
                        weight: 'bold',
                        size: 14
                    },
                    formatter: (value, context) => {
                        const total = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                        const percentage = ((value / total) * 100);
                        if(value != 0){
                          return value;
                        }else{
                            return '';
                        }
                    },
                    anchor: 'csnter',
                    align: 'csnter', // لتثبيت النصوص أقرب للحواف
                    offset: 0,  // مسافة إضافية للموضع
                    clamp: true
                }

            }
        };

        // رسم مخطط حالة الجاموس
        new Chart(document.getElementById('buffaloStatusChart'), {
            type: 'pie',
            data: statusData,
            options: commonOptions,
            plugins: [ChartDataLabels]
        });

        // رسم مخطط توزيع الحظائر
        new Chart(document.getElementById('buffaloPensChart'), {
            type: 'pie',
            data: pensData,
            options: commonOptions,
            plugins: [ChartDataLabels]
        });

    </script>
</x-app-layout>
