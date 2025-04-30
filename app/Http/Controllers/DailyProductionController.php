<?php

namespace App\Http\Controllers;

use App\Models\daily_production;
use App\Models\Transaction;
use App\Http\Requests\Storedaily_productionRequest;
use App\Http\Requests\Updatedaily_productionRequest;
use Illuminate\Http\Request;


class DailyProductionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function production(Request $request)
    {
        $query = daily_production::query();

        // تحقق إذا تم إرسال تاريخ معين
        if ($request->has('date') && $request->date) {
            $query->whereDate('production_date', $request->date);
        }

        $daily_production = $query->orderBy('production_date', 'desc')->get();

        return view('daily.prodection', compact('daily_production'));
    }
    public function index()
    {
        $daily_production = daily_production::all();
        return view('daily.prodection');
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
    public function store(Storedaily_productionRequest $request)
    {

        $exists = daily_production::where('production_date', $request->production_date)->exists();
        if ($exists) {
            return redirect()->back()->withErrors(['production_date' => 'لقد تم اضافة يومية الانتاج من قبل !!'])->withInput();
        }


        $validatedData = $request->validate([
            'buffaloMilk' => 'required|numeric|min:0',
            'cowMilk' => 'required|numeric|min:0',
            'eggs' => 'required|numeric|min:0',
            'dates' => 'required|numeric|min:0',
            'clover' => 'required|numeric|min:0',
            'production_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        // إنشاء السجل الجديد مع إضافة created_by
        daily_production::create(array_merge($validatedData, [
            'created_by' => auth()->id()
        ]));
        // تعريف الأصناف ومعرفاتهم (حسب الـ products عندك)
        $products = [
            1 => 'buffaloMilk', // اللبن جاموس
            2 => 'cowMilk',     // اللبن ابقار
            3 => 'eggs',        // البيض
            9 => 'dates',       // البلح
            11 => 'clover',       // البرسيم
        ];

        foreach ($products as $productId => $fieldName) {
            if ($validatedData[$fieldName] > 0) {
                Transaction::create([
                    'type' => 'production', // نوع الحركة: انتاج
                    'product_id' => $productId,
                    'quantity' => $validatedData[$fieldName],
                    'amount' => null, // لأنه انتاج، مش بيع أو مصاريف
                    'description' => 'إنتاج يومي بتاريخ ' . $validatedData['production_date'],
                    'date' => $validatedData['production_date'],
                    'created_by' => auth()->id(),
                ]);
            }
        }

            //return redirect()->back()->with('success', 'تم إضافة يومية الانتاج بنجاح!');
            return redirect()->back()->with('success', 'تم إضافة يومية الانتاج بنجاح!')
        ?: redirect()->back()->with('error', 'حدث خطأ أثناء إضافة يومية الإنتاج!');
        }

    /**
     * Display the specified resource.
     */
    public function show(daily_production $daily_production)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(daily_production $daily_production)
    {
        return response()->json($daily_production);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Updatedaily_productionRequest $request, daily_production $daily_production)
    {
        try {
            $data = $request->except(['_token', '_method', 'created_at', 'updated_at']);

            $daily_production->update($data);

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
    public function destroy(daily_production $daily_production)
    {
        $daily_production->delete();
        return redirect()->back()->with('success', 'تم حذف السجل بنجاح.');
    }
}
