<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('إدارة الحيوانات') }}
        </h2>
    </x-slot>

    <h3 class="text-lg font-bold text-gray-800 mb-4 text-center tracking-wide">الانتاج اليومي</h3>
    <canvas id="productionLineChart" class="w-full h-full"></canvas>
    <h3 class="text-lg font-bold text-gray-800 mb-4 text-center tracking-wide">الاستهلاك اليومي</h3>
    <canvas id="consumptionLineChart" class="w-full h-full"></canvas>

    <script>
        const labels = {!! json_encode($dailyProduction->pluck('production_date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('d'))) !!};


        const buffaloMilk = {!! json_encode($dailyProduction->pluck('buffaloMilk')) !!};
        const cowMilk = {!! json_encode($dailyProduction->pluck('cowMilk')) !!};
        const eggs = {!! json_encode($dailyProduction->pluck('eggs')) !!};
        const dates = {!! json_encode($dailyProduction->pluck('dates')) !!};
        const clover = {!! json_encode($dailyProduction->pluck('clover')) !!};

        const labelsConsumption = {!! json_encode($dailyConsumption->pluck('consumptions_date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('d'))) !!};


        const hay = {!! json_encode($dailyConsumption->pluck('hay')) !!};
        const corn = {!! json_encode($dailyConsumption->pluck('corn')) !!};
        const ConsumptionClover = {!! json_encode($dailyConsumption->pluck('corn')) !!};
        const soybean = {!! json_encode($dailyConsumption->pluck('soybean')) !!};
        const soybeanHulls = {!! json_encode($dailyConsumption->pluck('soybean_hulls')) !!};
        const bran = {!! json_encode($dailyConsumption->pluck('bran')) !!};
        const silage = {!! json_encode($dailyConsumption->pluck('silage')) !!};
        const gasoline = {!! json_encode($dailyConsumption->pluck('gasoline')) !!};
        const solar = {!! json_encode($dailyConsumption->pluck('solar')) !!};

        new Chart(document.getElementById('productionLineChart'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'لبن الجاموس',
                        data: buffaloMilk,
                        borderColor: '#f44336',
                        backgroundColor: '#f44336',
                        tension: 0.3
                    },
                    {
                        label: 'لبن الأبقار',
                        data: cowMilk,
                        borderColor: '#4caf50',
                        backgroundColor: '#4caf50',
                        tension: 0.3
                    },
                    {
                        label: 'بيض',
                        data: eggs,
                        borderColor: '#2196f3',
                        backgroundColor: '#2196f3',
                        tension: 0.3
                    },
                    {
                        label: 'بلح',
                        data: dates,
                        borderColor: '#ff9800',
                        backgroundColor: '#ff9800',
                        tension: 0.9
                    },
                    {
                        label: 'برسيم',
                        data: clover,
                        borderColor: '#9c27b0',
                        backgroundColor: '#9c27b0',
                        tension: 0.3
                    },
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    title: {
                        display: true,
                        text: 'الرسم البياني للإنتاج اليومي'
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'اليوم من الشهر'
                        }
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        new Chart(document.getElementById('consumptionLineChart'), {
            type: 'line',
            data: {
                labels: labelsConsumption,
                datasets: [
                    {
                        label: 'تبن',
                        data: hay,
                        borderColor: '#e91e63',
                        backgroundColor: '#e91e63',
                        tension: 0.3
                    },
                    {
                        label: 'ذرة',
                        data: corn,
                        borderColor: '#9c27b0',
                        backgroundColor: '#9c27b0',
                        tension: 0.3
                    },
                    {
                        label: 'برسيم',
                        data: ConsumptionClover,
                        borderColor: '#3f51b5',
                        backgroundColor: '#3f51b5',
                        tension: 0.3
                    },
                    {
                        label: 'فول صويا',
                        data: soybean,
                        borderColor: '#2196f3',
                        backgroundColor: '#2196f3',
                        tension: 0.3
                    },
                    {
                        label: 'قشور فول صويا',
                        data: soybeanHulls,
                        borderColor: '#00bcd4',
                        backgroundColor: '#00bcd4',
                        tension: 0.3
                    },
                    {
                        label: 'نخالة',
                        data: bran,
                        borderColor: '#4caf50',
                        backgroundColor: '#4caf50',
                        tension: 0.3
                    },
                    {
                        label: 'سيلاج',
                        data: silage,
                        borderColor: '#8bc34a',
                        backgroundColor: '#8bc34a',
                        tension: 0.3
                    },
                    {
                        label: 'بنزين',
                        data: gasoline,
                        borderColor: '#ffc107',
                        backgroundColor: '#ffc107',
                        tension: 0.3
                    },
                    {
                        label: 'سولار',
                        data: solar,
                        borderColor: '#ff5722',
                        backgroundColor: '#ff5722',
                        tension: 0.3
                    },
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    title: {
                        display: true,
                        text: 'الرسم البياني للاستهلاك اليومي'
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'اليوم من الشهر'
                        }
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });


    </script>


</x-app-layout>
