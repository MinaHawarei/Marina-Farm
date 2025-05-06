<?php

namespace App\Http\Controllers;

use App\Models\Expense;
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
            'unit_price' => 'required|numeric|min:0',
            'amount' => 'required|numeric|min:0',
            'paid' => 'required|numeric|min:0',
            'remaining' => 'required|numeric|min:0',
            'date' => 'required|date',
            'payment_due_date' => 'nullable|date',
            'supplier_name' => 'required|string|max:255',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'description' => 'nullable|string',
        ]);



        if (($validatedData['paid'] + $validatedData['remaining']) != $validatedData['amount']) {
            // إعادة التوجيه مع رسالة خطأ
            return redirect()->back()->withErrors(['error' => 'مجموع المدفوع والباقي يجب أن يساوي القيمة الإجمالية.']);
        }
        //new
        if ($validatedData['paid'] > $validatedData['amount']) {
            // إعادة التوجيه مع رسالة خطأ
            return redirect()->back()->withErrors(['error' => 'المبلغ المدفوع لا يمكن أن يكون أكبر من المبلغ الإجمالي.']);
        }
        if ($validatedData['remaining'] > $validatedData['amount']) {
            // إعادة التوجيه مع رسالة خطأ
            return redirect()->back()->withErrors(['error' => 'المبلغ المتبقي لا يمكن أن يكون أكبر من المبلغ الإجمالي.']);
        }

        if ($validatedData['remaining'] > 0) {

            if($validatedData['payment_due_date'] == null && $validatedData['supplier_id'] == null) {
             // إعادة التوجيه مع رسالة خطأ
                return redirect()->back()->withErrors(['error' => 'يجب وضع تاريخ الاستحقاق للمبلغ المتبقي و كود المورد.']);
            }elseif($validatedData['payment_due_date'] == null) {
                // إعادة التوجيه مع رسالة خطأ
                return redirect()->back()->withErrors(['error' => 'يجب وضع تاريخ الاستحقاق للمبلغ المتبقي.']);
            }elseif($validatedData['supplier_id'] == null) {
                // إعادة التوجيه مع رسالة خطأ
                return redirect()->back()->withErrors(['error' => 'يجب وضع كود المورد.']);
            }
        }



        //end new

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


        return redirect()->back()->with('success', 'تم إضافةالمصروفات بنجاح!')
        ?: redirect()->back()->with('error', 'حدث خطأ أثناء إضافةالمصروفات!');

    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        return response()->json($expense);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateexpenseRequest $request, Expense $expense)
    {
        try {
            $data = $request->except(['_token', '_method', 'created_at', 'updated_at']);

            $expense->update($data);

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
    public function destroy(Expense $expense)
    {
        $expense->delete();
        return redirect()->back()->with('success', 'تم حذف السجل بنجاح.');

    }
}
