<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Animal;
use App\Models\DailyConsumption;
use App\Models\daily_production;
use App\Models\expense;
use App\Models\buyers;
use App\Models\supplier;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Spatie\Activitylog\Models\Activity;



class UserController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index(Request $request)
    {
        if (!Auth::user()->hasRole('admin')) {
            return redirect()->back()->with('error', 'لا تملك صلاحية الوصول إلى هذه الصفحة.');
        }

        $users = User::with('roles')->get();
        return view('user.index', compact('users'));
    }

     public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'role'     => 'required|in:admin,accountant,employee',
        ]);
        $user = User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        return redirect()->route('user.index')->with('success', 'User added successfully.');
    }
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|string|in:admin,accountant,employee',
            'password' => 'nullable|string|min:6',
        ]);

        $passwordChanged = $request->filled('password');

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $passwordChanged ? Hash::make($request->password) : $user->password ,
        ]);

        $user->syncRoles([$request->role]);

        // تسجيل خروج المستخدم من كل جلساته
        if ($passwordChanged) {
           DB::table('sessions')->where('user_id', $user->id)->delete(); // حذف الجلسات
            $user->update(['remember_token' => null]);
        }


        return redirect()->back()->with('success', 'User updated and forced logout applied if password changed.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function logs(Request $request)
    {
        // نبدأ استعلام Activity بدون تنفيذ
        $query = Activity::query();

        // استبعاد عمليات على User فقط (لو مازلت محتاج الشرط ده)
        $query->where(function ($q) {
            $q->whereNull('subject_type')
                ->orWhere('subject_type', '!=', 'App\\Models\\User');
        });

        // لو المستخدم اختار فلترة حسب causer_id
        if ($request->filled('causer_id')) {
            $query->where('causer_id', $request->causer_id);
        }

        // فلترة بالتاريخ (start_date / end_date)
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // جلب النتائج
        $latest_operations = $query->latest()->get();


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
        $users = User::with('roles')->get();
        $logs = $formatted_latest_operations;
        return view('user.logs', compact('latest_operations', 'users'));
    }
}
