<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use Illuminate\Http\Request;
use Carbon\Carbon;


class ToolController extends Controller
{
    // عرض جميع الأدوات
    public function index()
    {
         $tools = Tool::all();
        return view('tools.index', compact('tools'));
    }
    public function schedule(Request $request)
    {
       // تحديد الشهر المحدد من الريكوست أو استخدام الشهر الحالي
        $month = $request->input('month');
        $targetDate = $month ? Carbon::createFromFormat('Y-m', $month)->startOfMonth() : now();
        $month_view = $targetDate->format('Y-m');
        // فلترة الأدوات حسب موعد الصيانة القادم
        $tools = Tool::all()->filter(function ($tool) use ($targetDate) {
            if (!$tool->last_maintenance_at || !$tool->maintenance_frequency) {
                return false;
            }

            $nextMaintenanceDate = Carbon::parse($tool->last_maintenance_at)
                ->addMonths($tool->maintenance_frequency);
            $month_view = $nextMaintenanceDate->format('Y-m');

            return $nextMaintenanceDate->isSameMonth($targetDate);
        });

        return view('tools.schedule', compact('tools', 'month_view'));
    }

    // حفظ أداة جديدة
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:255',
            'price' => 'nullable|numeric',
            'available' => 'required|boolean',
            'last_maintenance_at' => 'nullable|date',
            'lifespan_years' => 'nullable|integer',
            'maintenance_frequency' => 'required|string|max:255',
        ]);

        Tool::create($validated);

        return redirect()->back()->with('success', 'تم إضافة المعدة بنجاح.');
    }

    // تحديث أداة موجودة
    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:255',
            'price' => 'nullable|numeric',
            'available' => 'required|numeric',
            'last_maintenance_at' => 'nullable|date',
            'lifespan_years' => 'nullable|integer',
            'maintenance_frequency' => 'required|string|max:255',
        ]);
        $tool = Tool::findOrFail($request->id);
        $tool->update($validated);

        return redirect()->back()->with('success', 'تم تعديل المعدة بنجاح.');
    }

    // حذف أداة (إن رغبت لاحقًا)
    public function destroy(Tool $tool)
    {
        $tool->delete();

        return redirect()->back()->with('success', 'تم حذف المعدة بنجاح.');
    }
}
