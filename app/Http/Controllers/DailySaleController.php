<?php

namespace App\Http\Controllers;

use App\Models\daily_sale;
use App\Models\Product;
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
        $product_id = 0;
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
            'buyer_name' => 'required|string|max:255',
            'buyer_id' => 'nullable|exists:suppliers,id',
            'description' => 'nullable|string',
        ]);

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
                return redirect()->back()->withErrors(['error' => 'يجب وضع تاريخ الاستحقاق للمبلغ المتبقي و كود العميل.']);
            }elseif($validatedData['payment_due_date'] == null) {
                // إعادة التوجيه مع رسالة خطأ
                return redirect()->back()->withErrors(['error' => 'يجب وضع تاريخ الاستحقاق للمبلغ المتبقي.']);
            }elseif($validatedData['supplier_id'] == null) {
                // إعادة التوجيه مع رسالة خطأ
                return redirect()->back()->withErrors(['error' => 'يجب وضع كود العميل.']);
            }
        }
        $product = Product::where('product_name', $validatedData['type'])->first();
        $product_id = $product->id;
        $transactionType = 'sale';
        if (!$product) {
            $product_id = 0;
            $transactionType = 'income';
        }





        if (($validatedData['paid'] + $validatedData['remaining']) != $validatedData['amount']) {
            // إعادة التوجيه مع رسالة خطأ
            return redirect()->back()->withErrors(['error' => 'مجموع المدفوع والباقي يجب أن يساوي القيمة الإجمالية.']);
        }

        // إنشاء السجل الجديد مع إضافة created_by
        $expense = daily_sale::create(array_merge($validatedData, [
            'product_id' => $product_id,
            'created_by' => auth()->id()

        ]));



        Transaction::create([
            'type' => $transactionType, // نوع العملية مصروف
            'product_id' => $product_id, // المصروف غير مرتبط بمنتج
            'quantity' => $expense->quantity, // المصروف ليس له كمية مرتبطة
            'amount' => $expense->amount, // القيمة المالية للمصروف
            'description' => $expense->description, // وصف العملية
            'date' => $expense->date, // تاريخ المصروف
            'created_by' => $expense->created_by, // المستخدم الذي أنشأ العملية
        ]);


        return redirect()->back()->with('success', 'تم اضافة الايراد بنجاح!')
        ?: redirect()->back()->with('error', 'حدث خطأ أثناء اضافة الايراد!');



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
        return response()->json($daily_sale);

    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Updatedaily_saleRequest $request, daily_sale $daily_sale)
    {
        try {
            $data = $request->except(['_token', '_method', 'created_at', 'updated_at']);

            $daily_sale->update($data);

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
    public function destroy(daily_sale $daily_sale)
    {
        $daily_sale->delete();
        return redirect()->back()->with('success', 'تم حذف السجل بنجاح.');

    }
}
