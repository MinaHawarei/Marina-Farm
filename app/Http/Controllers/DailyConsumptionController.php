<?php

namespace App\Http\Controllers;

use App\Models\DailyConsumption;
use App\Models\Transaction;
use App\Http\Requests\StoreDailyConsumptionRequest;
use App\Http\Requests\UpdateDailyConsumptionRequest;
use Illuminate\Http\Request;


class DailyConsumptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function consumption(Request $request)
    {
        $query = DailyConsumption::query();

        // تحقق إذا تم إرسال تاريخ معين
        if ($request->has('datefrom') && $request->has('dateto')) {
            $query->whereBetween('consumptions_date', [$request->datefrom, $request->dateto]);

        }

        $daily_consumption = $query->orderBy('consumptions_date', 'desc')->get();

        return view('daily.consumption', compact('daily_consumption'));
    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDailyConsumptionRequest $request)
    {
        $exists = DailyConsumption::where('consumptions_date', $request->consumptions_date)->exists();
        if ($exists) {
            return redirect()->back()->withErrors(['consumptions_date' => 'لقد تم اضافة الاستهلاك اليومي من قبل !!'])->withInput();
        }


        $validatedData = $request->validate([
            'hay' => 'required|numeric|min:0',
            'clover' => 'required|numeric|min:0',
            'corn' => 'required|numeric|min:0',
            'soybean' => 'required|numeric|min:0',
            'soybean_hulls' => 'required|numeric|min:0',
            'bran' => 'required|numeric|min:0',
            'silage' => 'required|numeric|min:0',
            'gasoline' => 'required|numeric|min:0',
            'solar' => 'required|numeric|min:0',
            'consumptions_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        // إنشاء السجل الجديد مع إضافة created_by
        DailyConsumption::create(array_merge($validatedData, [
            'created_by' => auth()->id()
        ]));
        // تعريف الأصناف ومعرفاتهم (حسب الـ products عندك)
        $products = [
            10 => 'hay', // التبن
            11 => 'corn',     // الذرة
            12 => 'gasoline',        // البنزين
            13 => 'solar',       // سولار
            9 => 'clover',       // البرسيم
            14 => 'soybean',       // فول الصويا
            15 => 'soybean_hulls',       // قشر فول الصويا
            16 => 'bran',       // ردة
            17 => 'silage',       // سيلاج
        ];


        foreach ($products as $productId => $fieldName) {
            if ($validatedData[$fieldName] > 0) {
                Transaction::create([
                    'type' => 'consumptions', // نوع الحركة: انتاج
                    'product_id' => $productId,
                    'quantity' => $validatedData[$fieldName],
                    'amount' => null, // لأنه انتاج، مش بيع أو مصاريف
                    'description' => 'استهلاك يومي بتاريخ ' . $validatedData['consumptions_date'],
                    'date' => $validatedData['consumptions_date'],
                    'created_by' => auth()->id(),
                ]);
            }
        }

        return redirect()->back()->with('success', 'تم إضافةالاستهلاك اليومي بنجاح!')
        ?: redirect()->back()->with('error', 'حدث خطأ أثناء إضافةالاستهلاك اليومي!');

    }

    /**
     * Display the specified resource.
     */
    public function show(DailyConsumption $dailyConsumption)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DailyConsumption $dailyConsumption)
    {
        return response()->json($dailyConsumption);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDailyConsumptionRequest $request, DailyConsumption $dailyConsumption)
    {
        try {
            $data = $request->except(['_token', '_method', 'created_at', 'updated_at']);

            $dailyConsumption->update($data);

            return redirect()->back()->with([
                'success' => 'تم تحديث البيانات بنجاح',
                'updated_data' => $data
            ]);

        } catch (\Exception $e) {
            return redirect()->back()->with([
                'error' => 'حدث خطأ أثناء التحديث: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DailyConsumption $dailyConsumption)
    {
        $dailyConsumption->delete();
        return redirect()->back()->with('success', 'تم حذف السجل بنجاح.');

    }
}
