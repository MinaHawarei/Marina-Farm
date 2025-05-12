<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\daily_sale;
use App\Models\expense;
use App\Models\User;
use Illuminate\Support\Carbon;



class TreasuryController extends Controller
{
    public function index()
    {
        // القيم العامة
        $total_income = daily_sale::sum('amount');
        $total_expense = expense::sum('amount');
        $total_liabilities = expense::where('remaining', '>', 0)->sum('remaining');
        $total_receivables = daily_sale::where('remaining', '>', 0)->sum('remaining');
        $net_income = $total_income - $total_receivables ;
        $net_expense = $total_expense - $total_liabilities ;

        $balance = $total_income - $total_expense;
        $current_balance = $net_income - $net_expense;

        $translations = [
            // تكاليف العلف
            "Feed Costs" => "تكاليف العلف",
            "Hay" => "تبن",
            "Concentrates" => "المركزات",
            "Feed" => "علف",
            "clover Feed" => "برسيم",

            // المصاريف البيطرية
            "Veterinary Expenses" => "المصاريف البيطرية",
            "Medicines and Vaccines" => "الأدوية البيطرية واللقاحات",
            "Veterinarian Visits" => "زيارات الأطباء البيطريين",

            // أجور العمال
            "Labor Wages" => "أجور العمال",
            "Worker Salaries" => "رواتب العمال",
            "Worker Daily Salaries" => "عمال باليومية",
            "Bonuses" => "مكافآت",

            // تكاليف التشغيل
            "Operational Costs" => "تكاليف التشغيل",
            "Electricity Bills" => "فواتير الكهرباء",
            "Water Bills" => "فواتير المياه",
            "Cleaning Supplies" => "أدوات النظافة",
            "Tools and Equipment" => "العدد والأدوات",

            // شراء المعدات
            "Machinery Purchase" => "شراء المعدات",
            "Agricultural Machinery" => "ماكينات زراعية",
            "Milking Machines" => "ماكينات حلب",
            "Feeding Systems" => "أنظمة التغذية",
            "Water Troughs" => "أحواض شرب المياه",
            "Cooling Fans" => "مراوح تبريد للحظائر",
            "Manure Spreaders" => "موزعات السماد العضوي",
            "Livestock Scales" => "موازين قياس",
            "Poultry Feeders" => "مغذيات الدواجن",
            "Poultry Drinkers" => "مشربيات الدواجن",
            "Incubators" => "ماكينات تفريخ",
            "Brooder Equipment" => "معدات التدفئة",
            "Ventilation Systems" => "أنظمة تهوية",
            "Egg Collectors" => "ماكينات جمع البيض",
            "Poultry Cages" => "أقفاص الدواجن",

            // صيانة المعدات
            "Equipment Maintenance" => "صيانة المعدات",
            "Barn Maintenance" => "صيانة الحظائر",
            "Equipment Repair" => "إصلاح المعدات الزراعية",
            "Plumbing Work" => "أعمال السباكة",
            "Brick Work" => "أعمال الطوب",

            // لوازم زراعية
            "Agricultural Supplies" => "لوازم زراعية",
            "Seeds" => "البذور",
            "Fertilizers" => "الأسمدة",
            "Pesticides" => "مكافحة الآفات",

            // تكاليف النقل
            "Transportation Costs" => "تكاليف النقل",
            "Animal Transport" => "نقل الحيوانات",
            "Vehicle Maintenance" => "صيانة وسائل النقل",
            "Vehicle Buying" => "شراء وسائل نقل",

            // شراء الحيوانات
            "Buying Animals" => "شراء الحيوانات",
            "Buffalo" => "جاموس",
            "Cow" => "ابقار",
            "Chekeen" => "دجاج",

            // المصاريف الإدارية
            "Administrative Expenses" => "المصاريف الإدارية",
            "Bills and Taxes" => "الفواتير والضرائب",
            "Licenses and Paperwork" => "الأوراق والتراخيص",
            "Furniture Purchase" => "شراء أثاث",
            "Office Supplies Purchase" => "شراء أدوات مكتبية",
            "Furniture Maintenance" => "صيانة أثاث",

            // تكاليف الطوارئ
            "Emergency Costs" => "تكاليف الطوارئ",
            "Emergency Cases" => "حالات الطوارئ",

            // أخرى
            "Tips" => "إكراميات",
            // مبيعات المنتجات
            "Product Sales" => "مبيعات المنتجات",
            "Buffalo Milk" => "لبن جاموس",
            "Cow Milk" => "لبن بقري",
            "eggs" => "بيض",
            "ghee" => "سمن",
            "Cheese" => "جبن",
            "dates" => "بلح",
            "clover" => "برسيم",
            "fertilizer" => "سماد حيواني",

            // مبيعات الحيوانات
            "Animal Sales" => "مبيعات الحيوانات",
            "Buffalo Sales" => "بيع الجاموس",
            "Cow Sales" => "بيع الأبقار",
            "Chicken Sales" => "بيع الدجاج",

            // مبيعات المعدات
            "Equipment Sales" => "مبيعات المعدات",
            "Machinery Sales" => "بيع الماكينات",
            "Furniture Sales" => "بيع الأثاث",

            // إيرادات الإيجارات
            "Rent Income" => "إيرادات الإيجارات",
            "Land Rent" => "تأجير أراضي",
            "Equipment Rent" => "تأجير معدات",

            // التحصيلات المالية
            "Collections" => "التحصيلات المالية",
            "Debt Collection" => "تحصيل ديون",
            "Installment Collection" => "تحصيل أقساط",
        ];




        // آخر العمليات
        $latest_transactions = collect()
        ->merge(daily_sale::select('category', 'type', 'amount', 'date', 'created_by')
            ->whereBetween('date', [now()->subDays(1)->startOfDay(), now()->endOfDay()])
            ->latest()
            ->get())
        ->merge(expense::select('category', 'type', 'amount', 'date', 'created_by')
            ->whereBetween('date', [now()->subDays(1)->startOfDay(), now()->endOfDay()])
            ->latest()
            ->get())
        ->sortByDesc('date')
        ->map(function ($transaction) use ($translations) {
            $user = User::find($transaction->created_by);
            $transaction->created_by_name = $user ? $user->name : 'غير معروف'; // إضافة الاسم للمعاملة
            $transaction->category = $translations[$transaction->category] ?? $transaction->category; // ترجمة النوع إذا كان موجودًا في المصفوفة
            $transaction->type = $translations[$transaction->type] ?? $transaction->type; // ترجمة النوع إذا كان موجودًا في المصفوفة
            return $transaction;
        });




        // بيانات الرسم البياني - مجموع الإيرادات والمصروفات حسب الأشهر
        $monthly_data = [];
        foreach (range(1, 12) as $month) {
            $income = daily_sale::whereMonth('date', $month)->sum('amount');
            $expense = expense::whereMonth('date', $month)->sum('amount');
            $monthly_data[] = [
                'month' => $month,
                'income' => $income,
                'expense' => $expense,
            ];
        }


        return view('treasury.index', compact(
            'total_income',
            'total_expense',
            'total_liabilities',
            'total_receivables',
            'current_balance',
            'net_income',
            'net_expense',
            'balance',
            'latest_transactions',
            'monthly_data'
        ));
    }
    public function income(Request $request)
    {
        $income = daily_sale::query();

        if ($request->has('datefrom') && $request->has('dateto')) {
            $income->whereBetween('date', [$request->datefrom, $request->dateto]);
        }

        $income = $income->get();

        return view('treasury.income', compact('income'));
    }

    public function expense(Request $request)
    {
        $income = expense::query();
        // تحقق إذا تم إرسال تاريخ معين
        if ($request->has('datefrom') && $request->has('dateto')) {
            $income->whereBetween('date', [$request->datefrom, $request->dateto]);
        }

        $income = $income->get();

        return view('treasury.expense', compact('income'));
    }
    public function receivables(Request $request)
    {
        $income = daily_sale::query();

        if ($request->has('datefrom') && $request->has('dateto')) {
            $income->whereBetween('payment_due_date', [$request->datefrom, $request->dateto]);
        }

        $income->where('remaining', '>', 0);
        $income->orderBy('payment_due_date', 'asc');
        $income = $income->get();

        return view('treasury.receivables', compact('income'));
    }

    public function liabilities(Request $request)
    {
        $income = expense::query();
        // تحقق إذا تم إرسال تاريخ معين
        if ($request->has('datefrom') && $request->has('dateto')) {
            $income->whereBetween('payment_due_date', [$request->datefrom, $request->dateto]);
        }
        $income->where('remaining', '>', 0);
        $income->orderBy('payment_due_date', 'asc');

        $income = $income->get();

        return view('treasury.liabilities', compact('income'));
    }
    public function daily(Request $request)
    {
        $income = daily_sale::query();
        $expense = expense::query();
        if ($request->has('date')) {
            $income->whereDate('date', $request->date);
            $expense->whereDate('date', $request->date);
        }  else {
        $income->whereDate('date', Carbon::today());
        $expense->whereDate('date', Carbon::today());
        }

        $income = $income->get();
        $expense = $expense->get();
        $total_income = $income->sum('paid');
        $total_expense = $expense->sum('paid');

        return view('treasury.daily', compact('income' , 'expense','total_income','total_expense',));
    }

}
