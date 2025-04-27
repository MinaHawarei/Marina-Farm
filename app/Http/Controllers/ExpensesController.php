<?php

namespace App\Http\Controllers;

use App\Models\expense;
use App\Models\Transaction;
use App\Http\Requests\StoreexpenseRequest;
use App\Http\Requests\UpdateexpenseRequest;

class ExpensesController extends Controller
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
    public function store(StoreexpenseRequest $request)
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
            'supplier_id' => 'nullable|exists:suppliers,id',
            'description' => 'nullable|string',
        ]);



        if (($validatedData['paid'] + $validatedData['remaining']) != $validatedData['amount']) {
            // إعادة التوجيه مع رسالة خطأ
            return redirect()->back()->withErrors(['error' => 'مجموع المدفوع والباقي يجب أن يساوي القيمة الإجمالية.']);
        }

        // إنشاء السجل الجديد مع إضافة created_by
        $expense = expense::create(array_merge($validatedData, [
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


        return redirect()->back()->with('success', 'تم إضافةالاستهلاك اليومي بنجاح!')
        ?: redirect()->back()->with('error', 'حدث خطأ أثناء إضافةالاستهلاك اليومي!');

    }

    /**
     * Display the specified resource.
     */
    public function show(expense $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(expense $expense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateexpenseRequest $request, expense $expense)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(expense $expense)
    {
        //
    }
}
