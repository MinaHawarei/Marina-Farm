<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\daily_production;
use App\Models\daily_sale;
use App\Models\Expense;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Facades\Excel;


class ReportController extends Controller
{
     private $allowedCategoriesAndTypes = [
        'Product Sales' => [
            'Buffalo Milk' => 'لبن جاموس',
            'Cow Milk' => 'لبن بقري',
            'eggs' => 'بيض',
            'ghee' => 'سمن',
            'Cheese' => 'جبن',
            'dates' => 'بلح',
            'clover' => 'برسيم',
            'fertilizer' => 'سماد حيواني',
        ],
        'Animal Sales' => [
            'Buffalo Sales' => 'بيع الجاموس',
            'Cow Sales' => 'بيع الأبقار',
            'Chicken Sales' => 'بيع الدجاج',
        ],
        'Equipment Sales' => [
            'Machinery Sales' => 'بيع الماكينات',
            'Furniture Sales' => 'بيع الأثاث',
        ],
        'Rent Income' => [
            'Land Rent' => 'تأجير أراضي',
            'Equipment Rent' => 'تأجير معدات',
        ],
    ];

    private $categoryTranslations = [
        'Product Sales' => 'مبيعات المنتجات',
        'Animal Sales' => 'مبيعات الحيوانات',
        'Equipment Sales' => 'مبيعات المعدات',
        'Rent Income' => 'إيرادات الإيجار',
        'Feed Costs' => 'تكاليف الأعلاف',
        'Veterinary Expenses' => 'مصروفات بيطرية',
        'Labor Wages' => 'مصاريف العمالة',
        'Operational Costs' => 'مصاريف التشغيل',
        'Machinery Purchase' => 'شراء الآلات',
        'Equipment Maintenance' => 'صيانة المعدات والبنية التحتية',
        'Agricultural Supplies' => 'مصاريف الزراعة',
        'Transportation Costs' => 'مصاريف النقل',
        'Buying Animals' => 'شراء حيوانات جديدة',
        'Administrative Expenses' => 'المصاريف الإدارية',
        'Emergency Costs' => 'تكاليف طارئة',
        'Other' => 'أخرى',
    ];
    public function production( Request $request )
    {
         $month = $request->input('month');
        $targetDate = $month
            ? Carbon::createFromFormat('Y-m', $month)->startOfMonth()
            : now()->startOfMonth();

        $start = $targetDate->copy()->startOfMonth();
        $end = $targetDate->copy()->endOfMonth();

        $month_view = $targetDate->format('Y-m');

        // فلترة الإنتاج حسب تاريخ الإنتاج داخل الشهر المحدد
        $items = daily_production::whereBetween('production_date', [$start, $end])->get();
        $totalProduction = [
            'buffaloMilk' => $items->sum('buffaloMilk'),
            'cowMilk' => $items->sum('cowMilk'),
            'eggs' => $items->sum('eggs'),
            'cheese' => $items->sum('cheese'),
            'ghee' => $items->sum('ghee'),
            'dates' => $items->sum('dates'),
        ];


         $chartEndDate = Carbon::now()->endOfMonth();
        $chartStartDate = Carbon::now()->subMonths(11)->startOfMonth(); // 12 شهر شامل الشهر الحالي

             // جلب البيانات مجمعة شهرياً لكل صنف
        $monthlyAggregates = daily_production::selectRaw('
            DATE_FORMAT(production_date, "%Y-%m") as month_year,
            SUM(buffaloMilk) as total_buffaloMilk,
            SUM(cowMilk) as total_cowMilk,
            SUM(eggs) as total_eggs,
            SUM(cheese) as total_cheese,
            SUM(ghee) as total_ghee,
            SUM(dates) as total_dates
        ')
        ->whereBetween('production_date', [$chartStartDate, $chartEndDate])
        ->groupBy('month_year')
        ->orderBy('month_year', 'asc')
        ->get();

        // تهيئة arrays لبيانات الرسم البياني
        $chartLabels = []; // أسماء الشهور (مثلاً: 2024-01, 2024-02)
        $chartData = [
            'buffaloMilk' => [],
            'cowMilk' => [],
            'eggs' => [],
            'cheese' => [],
            'ghee' => [],
            'dates' => [],
        ];

        // ملء arrays الرسم البياني مع التأكد من وجود كل الشهور في الفترة
        $currentChartMonth = $chartStartDate->copy();
        while ($currentChartMonth->lte($chartEndDate)) {
            $monthKey = $currentChartMonth->format('Y-m');
            $chartLabels[] = $monthKey; // أو Carbon::parse($monthKey)->format('M Y') للأسماء المختصرة

            $dataForMonth = $monthlyAggregates->firstWhere('month_year', $monthKey);

            $chartData['buffaloMilk'][] = $dataForMonth ? $dataForMonth->total_buffaloMilk : 0;
            $chartData['cowMilk'][] = $dataForMonth ? $dataForMonth->total_cowMilk : 0;
            $chartData['eggs'][] = $dataForMonth ? $dataForMonth->total_eggs : 0;
            $chartData['cheese'][] = $dataForMonth ? $dataForMonth->total_cheese : 0;
            $chartData['ghee'][] = $dataForMonth ? $dataForMonth->total_ghee : 0;
            $chartData['dates'][] = $dataForMonth ? $dataForMonth->total_dates : 0;

            $currentChartMonth->addMonth();
        }

        return view('reports.production', compact('items', 'month_view', 'totalProduction', 'chartLabels', 'chartData'));

    }
    public function exportProductionReport(Request $request)
    {
        $month = $request->input('month');
        $targetDate = $month
            ? Carbon::createFromFormat('Y-m', $month)->startOfMonth()
            : now()->startOfMonth();

        $start = $targetDate->copy()->startOfMonth();
        $end = $targetDate->copy()->endOfMonth();

        // جلب البيانات بنفس طريقة دالة الـ production
        $items = daily_production::whereBetween('production_date', [$start, $end])->get();

        // تجهيز البيانات لـ Excel
        // هنستخدم FromArray هنا لتبسيط الموضوع بدون الحاجة لـ Export Class منفصل
        $data = [];

        // إضافة عناوين الأعمدة
        $data[] = [
            'اليوم',
            'لبن جاموس',
            'لبن بقري',
            'بيض',
            'جبنة',
            'سمنة',
            'بلح'
        ];
         $totalBuffaloMilk = 0;
        $totalCowMilk = 0;
        $totalEggs = 0;
        $totalCheese = 0;
        $totalGhee = 0;
        $totalDates = 0;
        // إضافة بيانات كل صف
        foreach ($items as $item) {
            $data[] = [
                $item->production_date,
                $item->buffaloMilk,
                $item->cowMilk,
                $item->eggs,
                $item->cheese,
                $item->ghee,
                $item->dates
            ];
            $totalBuffaloMilk += $item->buffaloMilk;
            $totalCowMilk += $item->cowMilk;
            $totalEggs += $item->eggs;
            $totalCheese += $item->cheese;
            $totalGhee += $item->ghee;
            $totalDates += $item->dates;
        }
         $data[] = [
            'الإجمالي', // الخلية الأولى لصف الإجمالي
            $totalBuffaloMilk,
            $totalCowMilk,
            $totalEggs,
            $totalCheese,
            $totalGhee,
            $totalDates
        ];

        $fileName = 'production_report_' . $targetDate->format('Y-m') . '.xlsx';

        // استخدام Excel::download لإنشاء وتحميل الملف
        return Excel::download(new class($data) implements \Maatwebsite\Excel\Concerns\FromArray, \Maatwebsite\Excel\Concerns\WithHeadings, \Maatwebsite\Excel\Concerns\WithTitle {
            private $data;

            public function __construct(array $data)
            {
                $this->data = $data;
            }

            public function array(): array
            {
                return $this->data;
            }

            public function headings(): array
            {
                // العناوين اللي تم وضعها في الصف الأول من الـ data
                return []; // عشان FromArray already فيها العناوين
            }

            public function title(): string
            {
                return 'تقرير الانتاج';
            }
        }, $fileName);
    }

    public function sales(Request $request)
    {
        $selectedMonth = $request->input('month');
        $targetDate = $selectedMonth
            ? Carbon::createFromFormat('Y-m', $selectedMonth)->startOfMonth()
            : now()->startOfMonth();

        $startOfMonth = $targetDate->copy()->startOfMonth();
        $endOfMonth = $targetDate->copy()->endOfMonth();

        $month_view = $targetDate->format('Y-m');

        // جلب الفئات الرئيسية المسموح بها من الـ property
        $allowedCategories = array_keys($this->allowedCategoriesAndTypes);
        // جلب جميع الأنواع المسموح بها (اختياري للفلترة الدقيقة)
        $allAllowedTypes = [];
        foreach ($this->allowedCategoriesAndTypes as $category => $types) {
            $allAllowedTypes = array_merge($allAllowedTypes, array_keys($types));
        }

        // جلب بيانات المبيعات مجمعة يومياً حسب الـ category للشهر المحدد
        $salesItemsGroupedByDayAndCategory = Daily_sale::selectRaw('
            DATE_FORMAT(date, "%Y-%m-%d") as sale_date,
            category,
            SUM(amount) as total_amount_daily_category,
            SUM(quantity) as total_quantity_daily_category
        ')
        ->whereBetween('date', [$startOfMonth, $endOfMonth])
        ->whereIn('category', $allowedCategories) // فلترة على الفئات المحددة
        // ->whereIn('type', $allAllowedTypes) // لو عايز تفلتر على الـ types كمان
        ->groupBy('sale_date', 'category')
        ->orderBy('sale_date', 'asc')
        ->get();

        // لإجمالي المبيعات حسب الـ Category في الشهر المحدد
        $totalSalesByCategory = $salesItemsGroupedByDayAndCategory->groupBy('category')->map(function ($items) {
            return $items->sum('total_amount_daily_category');
        });

        // --- تحضير بيانات الرسم البياني للإجمالي الشهري للمبيعات حسب الـ Category ---
        $chartEndDate = Carbon::now()->endOfMonth();
        $chartStartDate = Carbon::now()->subMonths(11)->startOfMonth(); // آخر 12 شهر

        // جلب البيانات مجمعة شهرياً حسب الـ Category
        $monthlySalesAggregatesByCategory = Daily_sale::selectRaw('
            DATE_FORMAT(date, "%Y-%m") as month_year,
            category,
            SUM(amount) as total_amount_monthly_category
        ')
        ->whereBetween('date', [$chartStartDate, $chartEndDate])
        ->whereIn('category', $allowedCategories) // فلترة على الفئات المحددة
        // ->whereIn('type', $allAllowedTypes) // لو عايز تفلتر على الـ types كمان
        ->groupBy('month_year', 'category')
        ->orderBy('month_year', 'asc')
        ->get();

        // الفئات التي ستظهر في الرسم البياني (من الـ properties)
        $allCategoriesForChart = array_keys($this->allowedCategoriesAndTypes);

        $chartLabels = [];
        $chartData = [];

        foreach ($allCategoriesForChart as $category) {
            $chartData[$category] = [];
        }

        $currentChartMonth = $chartStartDate->copy();
        while ($currentChartMonth->lte($chartEndDate)) {
            $monthKey = $currentChartMonth->format('Y-m');
            $chartLabels[] = $monthKey;

            foreach ($allCategoriesForChart as $category) {
                $dataForMonthAndCategory = $monthlySalesAggregatesByCategory->first(function ($item) use ($monthKey, $category) {
                    return $item->month_year === $monthKey && $item->category === $category;
                });
                $chartData[$category][] = $dataForMonthAndCategory ? $dataForMonthAndCategory->total_amount_monthly_category : 0;
            }
            $currentChartMonth->addMonth();
        }

        // إرجاع البيانات للـ view مع ترجمة الفئات
        return view('reports.sales', compact('salesItemsGroupedByDayAndCategory', 'month_view', 'totalSalesByCategory', 'chartLabels', 'chartData', 'allCategoriesForChart'))
            ->with('categoryTranslations', $this->categoryTranslations); // نمرر الترجمة
    }
    public function exportSalesReport(Request $request)
    {
        $month = $request->input('month');
        $targetDate = $month
            ? Carbon::createFromFormat('Y-m', $month)->startOfMonth()
            : now()->startOfMonth();

        $start = $targetDate->copy()->startOfMonth();
        $end = $targetDate->copy()->endOfMonth();

        // جلب الفئات الرئيسية المسموح بها من الـ property
        $allowedCategories = array_keys($this->allowedCategoriesAndTypes);

        // 1. جلب كل بيانات المبيعات للشهر وتجميعها حسب التاريخ والـ Category
        $salesData = Daily_sale::select('date', 'category', \DB::raw('SUM(amount) as total_amount'))
                            ->whereBetween('date', [$start, $end])
                            ->whereIn('category', $allowedCategories) // فلترة على الفئات المحددة
                            ->groupBy('date', 'category')
                            ->orderBy('date', 'asc')
                            ->get();

        // 2. تحديد كل الـ Categories الفريدة الموجودة في البيانات (من الـ properties لضمان الترتيب)
        $allCategoriesInReport = array_keys($this->allowedCategoriesAndTypes);

        // 3. بناء صفوف البيانات لملف Excel
        $excelData = [];

        // Header Row: اليوم + كل الـ Categories (بالعربي) + إجمالي اليوم
        $headers = ['اليوم'];
        foreach ($allCategoriesInReport as $category) {
            $headers[] = $this->categoryTranslations[$category] ?? $category; // استخدام الترجمة
        }
        $headers[] = 'إجمالي اليوم';
        $excelData[] = $headers;

        // تجهيز المجاميع الكلية لكل عمود (Category)
        $categoryTotals = array_fill_keys($allCategoriesInReport, 0);
        $grandTotalDaily = 0;

        // Loop خلال الأيام في الشهر عشان نضمن كل الأيام
        $currentDay = $start->copy();
        while ($currentDay->lte($end)) {
            $dayString = $currentDay->format('Y-m-d');
            $row = [$dayString];

            $dailyTotal = 0;

            foreach ($allCategoriesInReport as $category) {
                $amountForCategory = $salesData->first(function ($item) use ($dayString, $category) {
                    return $item->date->format('Y-m-d') === $dayString && $item->category === $category;
                });

                $value = $amountForCategory ? $amountForCategory->total_amount : 0;
                $row[] = $value;
                $dailyTotal += $value;
                $categoryTotals[$category] += $value;
            }
            $row[] = $dailyTotal;
            $excelData[] = $row;
            $grandTotalDaily += $dailyTotal;

            $currentDay->addDay();
        }

        // إضافة صف الإجمالي الكلي في النهاية
        $totalRow = ['الإجمالي الكلي'];
        foreach ($allCategoriesInReport as $category) {
            $totalRow[] = $categoryTotals[$category];
        }
        $totalRow[] = $grandTotalDaily;
        $excelData[] = $totalRow;

        $fileName = 'sales_report_pivot_' . $targetDate->format('Y-m') . '.xlsx';

        return Excel::download(new class($excelData) implements \Maatwebsite\Excel\Concerns\FromArray, \Maatwebsite\Excel\Concerns\WithHeadings, \Maatwebsite\Excel\Concerns\WithTitle, \Maatwebsite\Excel\Concerns\ShouldAutoSize {
            private $data;
            public function __construct(array $data) { $this->data = $data; }
            public function array(): array { return $this->data; }
            public function headings(): array { return []; }
            public function title(): string { return 'تقرير مبيعات الفئات'; }
            public function shouldAutoSize(): bool { return true; }
        }, $fileName);
    }


    public function financial(Request $request)
    {
            $reportType = $request->input('report_type', 'monthly'); // 'monthly' or 'annual'
            $selectedYear = $request->input('year', Carbon::now()->year);
            $selectedMonth = $request->input('month', Carbon::now()->format('Y-m')); // 'YYYY-MM'

            $financialData = []; // للبيانات المالية المفصلة (شهرياً لو التقرير سنوي)
            $summary = [
                'total_revenues' => 0,
                'total_expenses' => 0,
                'net_profit_loss' => 0,
            ];
            $revenueDetails = []; // إجمالي الإيرادات حسب الفئة
            $expenseDetails = []; // إجمالي المصروفات حسب الفئة

            // تحديد فئات الإيرادات والمصروفات من الـ properties
            $allowedRevenueCategories = array_keys($this->allowedCategoriesAndTypes);
            $allowedExpenseCategories = array_keys(array_filter($this->categoryTranslations, function($key) use ($allowedRevenueCategories) {
                return !in_array($key, $allowedRevenueCategories);
            }, ARRAY_FILTER_USE_KEY));


            if ($request->has('export_excel')) {
                // منطق تصدير Excel (تم نقله هنا مباشرة)
                return $this->exportFinancialReport($request);
            }

            if ($reportType == 'monthly') {
                $targetDate = Carbon::createFromFormat('Y-m', $selectedMonth)->startOfMonth();
                $start = $targetDate->copy()->startOfMonth();
                $end = $targetDate->copy()->endOfMonth();

                // جلب الإيرادات للشهر المحدد
                $revenues = Daily_sale::select('category', \DB::raw('SUM(amount) as total_amount'))
                                    ->whereBetween('date', [$start, $end])
                                    ->whereIn('category', $allowedRevenueCategories)
                                    ->groupBy('category')
                                    ->get();

                // جلب المصروفات للشهر المحدد
                $expenses = Expense::select('category', \DB::raw('SUM(amount) as total_amount'))
                                    ->whereBetween('date', [$start, $end])
                                    ->whereIn('category', $allowedExpenseCategories)
                                    ->groupBy('category')
                                    ->get();

                // حساب الإجمالي لكل فئة وتخزينه
                foreach ($this->categoryTranslations as $key => $value) {
                    if (in_array($key, $allowedRevenueCategories)) {
                        $revenueDetails[$key] = $revenues->firstWhere('category', $key)->total_amount ?? 0;
                        $summary['total_revenues'] += $revenueDetails[$key];
                    } else if (in_array($key, $allowedExpenseCategories)) {
                        $expenseDetails[$key] = $expenses->firstWhere('category', $key)->total_amount ?? 0;
                        $summary['total_expenses'] += $expenseDetails[$key];
                    }
                }

                $summary['net_profit_loss'] = $summary['total_revenues'] - $summary['total_expenses'];

                // إعداد البيانات للتقرير الشهري (مثلاً، يوم بيوم لو عايز تفاصيل يومية، لكن هنا إجمالي الشهر)
                $financialData[] = [
                    'period' => $selectedMonth,
                    'total_revenues' => $summary['total_revenues'],
                    'total_expenses' => $summary['total_expenses'],
                    'net_profit_loss' => $summary['net_profit_loss']
                ];

            } elseif ($reportType == 'annual') {
                $startOfYear = Carbon::createFromDate($selectedYear, 1, 1)->startOfDay();
                $endOfYear = Carbon::createFromDate($selectedYear, 12, 31)->endOfDay();

                // جلب الإيرادات مجمعة شهرياً للسنة
                $monthlyRevenues = Daily_sale::selectRaw('DATE_FORMAT(date, "%Y-%m") as month_year, SUM(amount) as total_amount')
                                        ->whereBetween('date', [$startOfYear, $endOfYear])
                                        ->whereIn('category', $allowedRevenueCategories)
                                        ->groupBy('month_year')
                                        ->orderBy('month_year', 'asc')
                                        ->get()
                                        ->keyBy('month_year');

                // جلب المصروفات مجمعة شهرياً للسنة
                $monthlyExpenses = Expense::selectRaw('DATE_FORMAT(date, "%Y-%m") as month_year, SUM(amount) as total_amount')
                                        ->whereBetween('date', [$startOfYear, $endOfYear])
                                        ->whereIn('category', $allowedExpenseCategories)
                                        ->groupBy('month_year')
                                        ->orderBy('month_year', 'asc')
                                        ->get()
                                        ->keyBy('month_year');

                // حساب الإجمالي السنوي
                $yearlyTotalRevenues = 0;
                $yearlyTotalExpenses = 0;

                // بناء البيانات المالية لكل شهر
                $currentMonth = $startOfYear->copy();
                while ($currentMonth->lte($endOfYear)) {
                    $monthKey = $currentMonth->format('Y-m');
                    $revenueForMonth = $monthlyRevenues->get($monthKey)->total_amount ?? 0;
                    $expenseForMonth = $monthlyExpenses->get($monthKey)->total_amount ?? 0;
                    $netForMonth = $revenueForMonth - $expenseForMonth;

                    $financialData[] = [
                        'period' => $monthKey,
                        'total_revenues' => $revenueForMonth,
                        'total_expenses' => $expenseForMonth,
                        'net_profit_loss' => $netForMonth
                    ];

                    $yearlyTotalRevenues += $revenueForMonth;
                    $yearlyTotalExpenses += $expenseForMonth;

                    $currentMonth->addMonth();
                }

                $summary['total_revenues'] = $yearlyTotalRevenues;
                $summary['total_expenses'] = $yearlyTotalExpenses;
                $summary['net_profit_loss'] = $yearlyTotalRevenues - $yearlyTotalExpenses;

                // تفاصيل الإيرادات والمصروفات حسب الفئة للسنة كلها (مش شهرياً)
                $totalRevenuesByCategory = Daily_sale::select('category', \DB::raw('SUM(amount) as total_amount'))
                                            ->whereBetween('date', [$startOfYear, $endOfYear])
                                            ->whereIn('category', $allowedRevenueCategories)
                                            ->groupBy('category')
                                            ->get();
                foreach ($allowedRevenueCategories as $cat) {
                    $revenueDetails[$cat] = $totalRevenuesByCategory->firstWhere('category', $cat)->total_amount ?? 0;
                }

                $totalExpensesByCategory = Expense::select('category', \DB::raw('SUM(amount) as total_amount'))
                                            ->whereBetween('date', [$startOfYear, $endOfYear])
                                            ->whereIn('category', $allowedExpenseCategories)
                                            ->groupBy('category')
                                            ->get();
                foreach ($allowedExpenseCategories as $cat) {
                    $expenseDetails[$cat] = $totalExpensesByCategory->firstWhere('category', $cat)->total_amount ?? 0;
                }
            }

            // تحضير بيانات الرسم البياني (فقط لتقرير السنة)
            $chartLabels = [];
            $chartRevenues = [];
            $chartExpenses = [];
            $chartNetProfitLoss = [];

            if ($reportType == 'annual') {
                foreach ($financialData as $data) {
                    $chartLabels[] = $data['period'];
                    $chartRevenues[] = $data['total_revenues'];
                    $chartExpenses[] = $data['total_expenses'];
                    $chartNetProfitLoss[] = $data['net_profit_loss'];
                }
            }

            return view('reports.financial', compact(
                'reportType', 'selectedYear', 'selectedMonth',
                'financialData', 'summary', 'revenueDetails', 'expenseDetails',
                'chartLabels', 'chartRevenues', 'chartExpenses', 'chartNetProfitLoss'
            ))
            ->with('categoryTranslations', $this->categoryTranslations);
    }
     private function exportFinancialReport(Request $request)
    {
        $reportType = $request->input('report_type', 'monthly');
        $selectedYear = $request->input('year', Carbon::now()->year);
        $selectedMonth = $request->input('month', Carbon::now()->format('Y-m'));

        $excelData = [];
        $fileName = '';

        $allowedRevenueCategories = array_keys($this->allowedCategoriesAndTypes);
        $allowedExpenseCategories = array_keys(array_filter($this->categoryTranslations, function($key) use ($allowedRevenueCategories) {
            return !in_array($key, $allowedRevenueCategories);
        }, ARRAY_FILTER_USE_KEY));

        if ($reportType == 'monthly') {
            $targetDate = Carbon::createFromFormat('Y-m', $selectedMonth)->startOfMonth();
            $start = $targetDate->copy()->startOfMonth();
            $end = $targetDate->copy()->endOfMonth();

            $revenues = Daily_sale::select('category', \DB::raw('SUM(amount) as total_amount'))
                                ->whereBetween('date', [$start, $end])
                                ->whereIn('category', $allowedRevenueCategories)
                                ->groupBy('category')
                                ->get();

            $expenses = Expense::select('category', \DB::raw('SUM(amount) as total_amount'))
                                ->whereBetween('date', [$start, $end])
                                ->whereIn('category', $allowedExpenseCategories)
                                ->groupBy('category')
                                ->get();

            $totalRevenues = $revenues->sum('total_amount');
            $totalExpenses = $expenses->sum('total_amount');
            $netProfitLoss = $totalRevenues - $totalExpenses;

            $excelData[] = ['تقرير مالي شهري: ' . $selectedMonth];
            $excelData[] = [''];

            $excelData[] = ['الإيرادات'];
            $excelData[] = ['الفئة', 'المبلغ'];
            foreach ($allowedRevenueCategories as $cat) {
                $amount = $revenues->firstWhere('category', $cat)->total_amount ?? 0;
                $excelData[] = [$this->categoryTranslations[$cat] ?? $cat, $amount];
            }
            $excelData[] = ['إجمالي الإيرادات', $totalRevenues];
            $excelData[] = [''];

            $excelData[] = ['المصروفات'];
            $excelData[] = ['الفئة', 'المبلغ'];
            foreach ($allowedExpenseCategories as $cat) {
                $amount = $expenses->firstWhere('category', $cat)->total_amount ?? 0;
                $excelData[] = [$this->categoryTranslations[$cat] ?? $cat, $amount];
            }
            $excelData[] = ['إجمالي المصروفات', $totalExpenses];
            $excelData[] = [''];

            $excelData[] = ['الربح/الخسارة الصافي', $netProfitLoss];

            $fileName = 'financial_report_monthly_' . $selectedMonth . '.xlsx';

        } elseif ($reportType == 'annual') {
            $startOfYear = Carbon::createFromDate($selectedYear, 1, 1)->startOfDay();
            $endOfYear = Carbon::createFromDate($selectedYear, 12, 31)->endOfDay();

            $monthlyRevenues = Daily_sale::selectRaw('DATE_FORMAT(date, "%Y-%m") as month_year, SUM(amount) as total_amount')
                                    ->whereBetween('date', [$startOfYear, $endOfYear])
                                    ->whereIn('category', $allowedRevenueCategories)
                                    ->groupBy('month_year')
                                    ->orderBy('month_year', 'asc')
                                    ->get()
                                    ->keyBy('month_year');

            $monthlyExpenses = Expense::selectRaw('DATE_FORMAT(date, "%Y-%m") as month_year, SUM(amount) as total_amount')
                                    ->whereBetween('date', [$startOfYear, $endOfYear])
                                    ->whereIn('category', $allowedExpenseCategories)
                                    ->groupBy('month_year')
                                    ->orderBy('month_year', 'asc')
                                    ->get()
                                    ->keyBy('month_year');

            $excelData[] = ['تقرير مالي سنوي: ' . $selectedYear];
            $excelData[] = [''];

            $excelData[] = ['الشهر', 'إجمالي الإيرادات', 'إجمالي المصروفات', 'الربح/الخسارة الصافية'];
            $yearlyTotalRevenues = 0;
            $yearlyTotalExpenses = 0;

            $currentMonth = $startOfYear->copy();
            while ($currentMonth->lte($endOfYear)) {
                $monthKey = $currentMonth->format('Y-m');
                $revenueForMonth = $monthlyRevenues->get($monthKey)->total_amount ?? 0;
                $expenseForMonth = $monthlyExpenses->get($monthKey)->total_amount ?? 0;
                $netForMonth = $revenueForMonth - $expenseForMonth;

                $excelData[] = [
                    $monthKey,
                    $revenueForMonth,
                    $expenseForMonth,
                    $netForMonth
                ];
                $yearlyTotalRevenues += $revenueForMonth;
                $yearlyTotalExpenses += $expenseForMonth;
                $currentMonth->addMonth();
            }

            $excelData[] = [''];
            $excelData[] = ['الإجمالي السنوي للإيرادات', $yearlyTotalRevenues];
            $excelData[] = ['الإجمالي السنوي للمصروفات', $yearlyTotalExpenses];
            $excelData[] = ['الربح/الخسارة الصافي السنوي', $yearlyTotalRevenues - $yearlyTotalExpenses];

            $fileName = 'financial_report_annual_' . $selectedYear . '.xlsx';
        }

        return Excel::download(new class($excelData) implements \Maatwebsite\Excel\Concerns\FromArray, \Maatwebsite\Excel\Concerns\WithHeadings, \Maatwebsite\Excel\Concerns\WithTitle, \Maatwebsite\Excel\Concerns\ShouldAutoSize {
            private $data;
            public function __construct(array $data) { $this->data = $data; }
            public function array(): array { return $this->data; }
            public function headings(): array { return []; }
            public function title(): string { return 'التقرير المالي'; }
            public function shouldAutoSize(): bool { return true; }
        }, $fileName);
    }
     public function getDailySalesDetailsByCategory(Request $request)
    {
        $saleDate = $request->query('sale_date'); // مثلاً "2023-01-15"
        $category = $request->query('category');
        if (!$saleDate || !$category) {
            return response()->json(['error' => 'Sale date and category are required.'], 400);
        }

        try {

            $salesDetails = daily_sale::
                whereDate('date', $saleDate)
                ->where('category', $category)
                ->select(
                    'id',
                    'type',
                    'product_id',
                    'quantity',
                    'unit_price',
                    'amount'
                )
                ->get();

            return response()->json($salesDetails);
        } catch (\Exception $e) {
            \Log::error("Error fetching daily sales details: " . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch sales details.'], 500);
        }

    }
}
