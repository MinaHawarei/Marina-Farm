<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\daily_production;
use App\Models\Transaction;
use App\Models\daily_sale;
use App\Models\expense;
use App\Models\DailyConsumption;
use App\Models\User;

class StockController extends Controller
{
     public function producs()
    {
        //production
        $Buffalo_Milk_production = daily_production::sum('buffaloMilk');
        $Cow_Milk_production = daily_production::sum('cowMilk');
        $eggs_production = daily_production::sum('eggs');
        $dates_production = daily_production::sum('dates');
        $ghee_production = daily_production::sum('ghee');
        $cheese_production = daily_production::sum('cheese');

        //sales
        $Buffalo_Milk_sales = daily_sale::where('type', 'Buffalo Milk')->sum('quantity');
        $Cow_Milk_sales = daily_sale::where('type', 'Cow Milk')->sum('quantity');
        $eggs_sales = daily_sale::where('type', 'eggs')->sum('quantity');
        $dates_sales = daily_sale::where('type', 'dates')->sum('quantity');
        $ghee_sales = daily_sale::where('type', 'ghee')->sum('quantity');
        $cheese_sales = daily_sale::where('type', 'cheese')->sum('quantity');

        //net
        $Buffalo_Milk_net = $Buffalo_Milk_production - $Buffalo_Milk_sales;
        $Cow_Milk_net = $Cow_Milk_production - $Cow_Milk_sales;
        $eggs_net = $eggs_production - $eggs_sales;
        $dates_net = $dates_production - $dates_sales;
        $ghee_net = $ghee_production - $ghee_sales;
        $cheese_net = $cheese_production - $cheese_sales;




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
        ->merge(daily_production::select('buffaloMilk', 'cowMilk', 'eggs','dates', 'production_date', 'created_by')
            ->whereBetween('production_date', [now()->subDays(1)->startOfDay(), now()->endOfDay()])
            ->latest()
            ->get())
        ->merge(daily_production::select('buffaloMilk', 'cowMilk', 'eggs','dates', 'production_date', 'created_by')
            ->whereBetween('production_date', [now()->subDays(1)->startOfDay(), now()->endOfDay()])
            ->latest()
            ->get())
        ->sortByDesc('production_date')
        ->map(function ($transaction) use ($translations) {
            $user = User::find($transaction->created_by);
            $transaction->created_by_name = $user ? $user->name : 'غير معروف'; // إضافة الاسم للمعاملة
            $transaction->category = $translations[$transaction->category] ?? $transaction->category; // ترجمة النوع إذا كان موجودًا في المصفوفة
            $transaction->type = $translations[$transaction->type] ?? $transaction->type; // ترجمة النوع إذا كان موجودًا في المصفوفة
            return $transaction;
        });

        return view('stock.producs', compact(
            'Buffalo_Milk_net',
            'Cow_Milk_net',
            'eggs_net',
            'dates_net',
            'ghee_net',
            'cheese_net',
            'latest_transactions',
        ));
    }

    public function feeds(Request $request)
    {
        //DailyConsumption
        $hay_Consumption = DailyConsumption::sum('hay');
        $clover_Consumption = DailyConsumption::sum('clover');
        $corn_Consumption = DailyConsumption::sum('corn');
        $soybean_Consumption = DailyConsumption::sum('soybean');
        $soybean_hulls_Consumption = DailyConsumption::sum('soybean_hulls');
        $bran_Consumption = DailyConsumption::sum('bran');
        $silage_Consumption = DailyConsumption::sum('silage');


        //purchases
        $hay_purchases = expense::where('type', 'Hay')->sum('quantity');
        $clover_purchases = expense::where('type', 'clover Feed')->sum('quantity');
        $corn_purchases = expense::where('type', 'Corn')->sum('quantity');
        $soybean_purchases = expense::where('type', 'Soybean')->sum('quantity');
        $soybean_hulls_purchases = expense::where('type', 'Soybean Hulls')->sum('quantity');
        $bran_purchases = expense::where('type', 'Bran')->sum('quantity');
        $silage_purchases = expense::where('type', 'Silage')->sum('quantity');

        //daily_production
        $clover_production = daily_production::sum('clover');



        //net
        $hay_net = $hay_purchases - $hay_Consumption;
        $clover_net = $clover_production + $clover_purchases - $clover_Consumption;
        $corn_net = $corn_purchases - $corn_Consumption;
        $soybean_net = $soybean_purchases - $soybean_Consumption;
        $soybean_hulls_net = $soybean_hulls_purchases - $soybean_hulls_Consumption;
        $bran_net = $bran_purchases - $bran_Consumption;
        $silage_net = $silage_purchases - $silage_Consumption;



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
        ->merge(daily_production::select('buffaloMilk', 'cowMilk', 'eggs','dates', 'production_date', 'created_by')
            ->whereBetween('production_date', [now()->subDays(1)->startOfDay(), now()->endOfDay()])
            ->latest()
            ->get())
        ->merge(daily_production::select('buffaloMilk', 'cowMilk', 'eggs','dates', 'production_date', 'created_by')
            ->whereBetween('production_date', [now()->subDays(1)->startOfDay(), now()->endOfDay()])
            ->latest()
            ->get())
        ->sortByDesc('production_date')
        ->map(function ($transaction) use ($translations) {
            $user = User::find($transaction->created_by);
            $transaction->created_by_name = $user ? $user->name : 'غير معروف'; // إضافة الاسم للمعاملة
            $transaction->category = $translations[$transaction->category] ?? $transaction->category; // ترجمة النوع إذا كان موجودًا في المصفوفة
            $transaction->type = $translations[$transaction->type] ?? $transaction->type; // ترجمة النوع إذا كان موجودًا في المصفوفة
            return $transaction;
        });

        return view('stock.feeds', compact(
            'hay_net',
            'clover_net',
            'corn_net',
            'soybean_net',
            'soybean_hulls_net',
            'bran_net',
            'silage_net',
            'latest_transactions'
        ));

    }
    public function other(Request $request)
    {
        //DailyConsumption
        $gasoline_Consumption = DailyConsumption::sum('gasoline');
        $solar_Consumption = DailyConsumption::sum('solar');



        //purchases
        $gasoline_purchases = expense::where('type', 'Gasoline')->sum('quantity');
        $solar_purchases = expense::where('type', 'Solar')->sum('quantity');


        //net
        $gasoline_net = $gasoline_purchases - $gasoline_Consumption;
        $solar_net = $solar_purchases - $solar_Consumption;




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
        ->merge(daily_production::select('buffaloMilk', 'cowMilk', 'eggs','dates', 'production_date', 'created_by')
            ->whereBetween('production_date', [now()->subDays(1)->startOfDay(), now()->endOfDay()])
            ->latest()
            ->get())
        ->merge(daily_production::select('buffaloMilk', 'cowMilk', 'eggs','dates', 'production_date', 'created_by')
            ->whereBetween('production_date', [now()->subDays(1)->startOfDay(), now()->endOfDay()])
            ->latest()
            ->get())
        ->sortByDesc('production_date')
        ->map(function ($transaction) use ($translations) {
            $user = User::find($transaction->created_by);
            $transaction->created_by_name = $user ? $user->name : 'غير معروف'; // إضافة الاسم للمعاملة
            $transaction->category = $translations[$transaction->category] ?? $transaction->category; // ترجمة النوع إذا كان موجودًا في المصفوفة
            $transaction->type = $translations[$transaction->type] ?? $transaction->type; // ترجمة النوع إذا كان موجودًا في المصفوفة
            return $transaction;
        });

        return view('stock.other', compact(
            'gasoline_net',
            'solar_net',
            'latest_transactions'
        ));

    }
}
