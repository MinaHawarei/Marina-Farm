<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MilkProductionDetails;

class MilkProductionDetailsController extends Controller
{

    public function store(Request $request)
    {
        // التحقق من البيانات (بدون created_by)
        $validatedData = $request->validate([
            'animal_id' => 'required',
            'morning_milk' => 'required|integer|min:0',
            'evening_milk' => 'required|integer|min:0',
            'date' => 'required|date',
            'notes' => 'nullable|string',

        ]);
        $exists = MilkProductionDetails::where('animal_id', $validatedData['animal_id'])
        ->where('date', $validatedData['date'])
        ->exists();
        $total_milk = $validatedData['morning_milk'] + $validatedData['evening_milk'];

        try {
            if ($exists) {
                throw new \Exception('تم تسجيل هذا الحيوان بالفعل لهذا التاريخ.');
            }

            // باقي الكود إذا لم يوجد تكرار
            MilkProductionDetails::create(array_merge($validatedData, [
                'created_by' => auth()->id(),
                'total_milk' => $total_milk,
            ]));

            return redirect()->back()->with('success', 'تم اضافة انتاج حليب بنجاح!');

        } catch (\Exception $e) {
            return redirect()->back()->with([
                'error' => 'أثناء التحديث: ' . $e->getMessage()
            ]);        }
    }
    public function update(Request $request, $milkId)
    {
        $validatedData = $request->validate([
            'morning_milk' => 'required|integer|min:0',
            'evening_milk' => 'required|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        $total_milk = $validatedData['morning_milk'] + $validatedData['evening_milk'];

        try {
            MilkProductionDetails::where('id', $milkId)->update([
                'morning_milk' => $validatedData['morning_milk'],
                'evening_milk' => $validatedData['evening_milk'],
                'total_milk' => $total_milk,
                'notes' => $validatedData['notes'],
                'created_by' => auth()->id(),
            ]);


            return redirect()->back()->with('success', 'تم تحديث انتاج الحليب بنجاح!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'خطأ: ' . $e->getMessage());
        }
    }

}
