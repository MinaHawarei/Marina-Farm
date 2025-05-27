<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Animal;
use App\Models\DailyConsumption;
use App\Models\daily_production;
use App\Models\expense;
use App\Models\buyers;
use App\Models\supplier;
use Spatie\Activitylog\Models\Activity;


class DashboardController extends Controller
{
    public function index()
    {
        $translations = [];
        $translationFilePath = resource_path('lang/ar/translate.php'); // المسار الصحيح المفترض
        if (file_exists($translationFilePath)) {
            $translations = include $translationFilePath;
        }
         //DailyConsumption
        $hay_Consumption = DailyConsumption::sum('hay');
        $corn_Consumption = DailyConsumption::sum('corn');
        $soybean_Consumption = DailyConsumption::sum('soybean');
        $soybean_hulls_Consumption = DailyConsumption::sum('soybean_hulls');
        $bran_Consumption = DailyConsumption::sum('bran');
        $silage_Consumption = DailyConsumption::sum('silage');


        //purchases
        $hay_purchases = expense::where('type', 'Hay')->sum('quantity');
        $corn_purchases = expense::where('type', 'Corn')->sum('quantity');
        $soybean_purchases = expense::where('type', 'Soybean')->sum('quantity');
        $soybean_hulls_purchases = expense::where('type', 'Soybean Hulls')->sum('quantity');
        $bran_purchases = expense::where('type', 'Bran')->sum('quantity');
        $silage_purchases = expense::where('type', 'Silage')->sum('quantity');

        //net
        $hay_net = $hay_purchases - $hay_Consumption;
        $corn_net = $corn_purchases - $corn_Consumption;
        $soybean_net = $soybean_purchases - $soybean_Consumption;
        $soybean_hulls_net = $soybean_hulls_purchases - $soybean_hulls_Consumption;
        $bran_net = $bran_purchases - $bran_Consumption;
        $silage_net = $silage_purchases - $silage_Consumption;

        //p
        $hay_net = $hay_net /10000 * 100;
        $corn_net = $corn_net /10000 * 100;
        $soybean_net = $soybean_net /10000 * 100;
        $soybean_hulls_net = $soybean_hulls_net /10000 * 100;
        $bran_net = $bran_net /10000 * 100;
        $silage_net = $silage_net /10000 * 100;

        //
        $avg_daily_milk_production = 0; // استبدل بالقيمة الفعلية
        $avg_daily_egg_production = 0; // استبدل بالقيمة الفعلية
        $avg_daily_hay_consumption = 0; // استبدل بالقيمة الفعلية
        $avg_daily_corn_consumption = 0; // استبدل بالقيمة الفعلية
        $avg_daily_soybean_consumption = 0; // استبدل بالقيمة الفعلية
        $avg_daily_soybean_hulls_consumption = 0; // استبدل بالقيمة الفعلية
        $avg_daily_bran_consumption = 0; // استبدل بالقيمة الفعلية
        $avg_daily_silage_consumption = 0; // استبدل بالقيمة الفعلية
        $latest_operations = ''; // استبدل بالقيمة الفعلية
        $notifications = ''; // استبدل بالقيمة الفعلية


    $latest_operations = Activity::where(function ($query) {
            $query->whereNull('subject_type')
                ->orWhere('subject_type', '!=', 'App\\Models\\User');
        })
        ->latest()
        ->take(10) // هنفلتر بعدين بناءً على وجود تفاصيل، فممكن نجيب أكتر من 5 مؤقتاً
        ->get();
        $translations = include resource_path('lang/ar/translate.php');


        $formatted_latest_operations = $latest_operations->map(function ($activity) use ($translations) {
            $causer = $activity->causer;
            $add_details = '';
            // استخدام $translations مباشرة
            $causerName = $causer ? $causer->name : ($translations['unknown_user'] ?? 'مستخدم غير معروف');
            $causerId = $activity->causer_id;

            $actionKey = $activity->description;
            $subjectKey = $activity->subject_type ? class_basename($activity->subject_type) : null;

            // استخدام $translations مباشرة
            $action_ar = $translations[$actionKey] ?? "قام بـ {$actionKey}";
            $subject_ar = $translations[$subjectKey] ?? ($subjectKey ?? 'عنصر غير محدد');
            $add_details = "بكود : " . $activity->subject_id  ;

            if($subjectKey == 'Animal') {
                $animal = Animal::find($activity->subject_id);
                $add_details = "بكود : " . $animal->animal_code;

            } elseif ($subjectKey == 'DailyConsumption') {
                $DailyConsumption = DailyConsumption::find($activity->subject_id);
                $add_details = "عن يوم: " .$DailyConsumption ->consumptions_date ;
            }elseif ($subjectKey == 'daily_production') {
                $DailyProduction = daily_production::find($activity->subject_id);
                $add_details = "عن يوم: " .$DailyProduction ->production_date ;
            }
            $details_array = [];
            $item_id = $activity->subject_id;
            $excludedKeys = [
                'created_at',
                'updated_at',
                'deleted_at',
                'password',
                'causer_id',
                'causer_type',
                'user_id',
                'password',
                'created_by',
                'notes',
                'production_date',
                'consumptions_date',
                'production_id',
                'payment_due_date',
                'remember_token',
                'date'


            ];

            if ($activity->properties->has('attributes')) {
                foreach ($activity->properties['attributes'] as $key => $value) {
                    if (in_array($key, $excludedKeys)) {
                        continue; // تخطي هذا المفتاح
                    }

                    // استخدام $translations مباشرة
                    $translatedKey = $translations[$key] ?? $key;
                    $value = $translations[$value] ?? $value;

                    $details_array[] = "{$translatedKey}: {$value}";

                }
            }


            // بناء تفاصيل التغييرات للحالات "updated"
            if ($actionKey === 'updated' && $activity->properties->has('old')) {
                foreach ($activity->properties['old'] as $key => $oldValue) {
                    $newValue = $activity->properties['attributes'][$key] ?? null;

                    if (in_array($key, ['created_at', 'updated_at', 'deleted_at', 'password','remember_token'])) {
                        continue;
                    }

                    if ($oldValue != $newValue) {
                        // استخدام $translations مباشرة
                        $translatedKey = '';
                        $oldValue = $translations[$oldValue] ?? $oldValue;

                        $details_array[] = "حيث كان:  '{$oldValue}'";
                    }
                }
            }

            $fullDetails = implode('، ', array_filter($details_array));


            $timeFormatted = $activity->created_at->format('m/d h:i A');

            $debugProperties = json_encode($activity->properties->toArray(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            return (object)[
                'type' => "قام {$causerName} ب{$action_ar} {$subject_ar} {$add_details}",
                'details' => $fullDetails,
                'created_at' => $timeFormatted,
                'debug_info' => $debugProperties,
            ];
        });



        $latest_operations = $formatted_latest_operations;

        $animals = Animal::all();
        $buyers = buyers::all();
        $suppliers = supplier::all();

        return view('dashboard', compact(
              'hay_net',
            'corn_net',
            'soybean_net',
            'soybean_hulls_net',
            'bran_net',
            'silage_net',
            'animals',
            'buyers',
            'suppliers',
            // البيانات الجديدة: متوسط الإنتاج اليومي
            'avg_daily_milk_production', // مثال لمتوسط إنتاج الحليب
            'avg_daily_egg_production',  // مثال لمتوسط إنتاج البيض

            // البيانات الجديدة: متوسط الاستهلاك اليومي (لكل نوع علف)
            'avg_daily_hay_consumption',
            'avg_daily_corn_consumption',
            'avg_daily_soybean_consumption',
            'avg_daily_soybean_hulls_consumption',
            'avg_daily_bran_consumption',
            'avg_daily_silage_consumption',

            // البيانات الجديدة: آخر 5 عمليات
            'latest_operations', // مصفوفة/مجموعة من الكائنات تحتوي على تفاصيل العملية (التاريخ، النوع، الوصف، المبلغ/الكمية)

            // البيانات الجديدة: الإشعارات
            'notifications', // مصفوفة/مجموعة من الكائنات تحتوي على تفاصيل الإشعار (العنوان، الوصف، التاريخ، الأهمية)

        ));
    }
}
