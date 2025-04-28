<?php

namespace App\Http\Controllers;

use App\Models\daily_sale;
use App\Models\Transaction;
use App\Http\Requests\Storedaily_saleRequest;
use App\Http\Requests\Updatedaily_saleRequest;

class DailySaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
    public function store(Storedaily_saleRequest $request)
    {

        // التحقق من صحة البيانات
        $validatedData = $request->validate([
            'category' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0',
            'amount' => 'required|numeric|min:0',
            'paid' => 'required|numeric|min:0',
            'remaining' => 'required|numeric|min:0',
            'date' => 'required|date',
            'supplier_name' => 'required|string|max:255',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'description' => 'nullable|string',
        ]);



        if (($validatedData['paid'] + $validatedData['remaining']) != $validatedData['amount']) {
            // إعادة التوجيه مع رسالة خطأ
            return redirect()->back()->withErrors(['error' => 'مجموع المدفوع والباقي يجب أن يساوي القيمة الإجمالية.']);
        }

        // إنشاء السجل الجديد مع إضافة created_by
        $expense = daily_sale::create(array_merge($validatedData, [
            'created_by' => auth()->id()
        ]));



        Transaction::create([
            'type' => 'expense', // نوع العملية مصروف
            'product_id' => null, // المصروف غير مرتبط بمنتج
            'quantity' => $expense->quantity, // المصروف ليس له كمية مرتبطة
            'amount' => $expense->amount, // القيمة المالية للمصروف
            'description' => $expense->description, // وصف العملية
            'date' => $expense->date, // تاريخ المصروف
            'created_by' => $expense->created_by, // المستخدم الذي أنشأ العملية
        ]);


        return redirect()->back()->with('success', 'تم إضافةالمصروفات بنجاح!')
        ?: redirect()->back()->with('error', 'حدث خطأ أثناء إضافةالمصروفات!');



    }

    /**
     * Display the specified resource.
     */
    public function show(daily_sale $daily_sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(daily_sale $daily_sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updatedaily_saleRequest $request, daily_sale $daily_sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(daily_sale $daily_sale)
    {
        //
    }
}
