<?php

namespace App\Http\Controllers;

use App\Models\supplier;
use App\Http\Requests\StoresupplierRequest;
use App\Http\Requests\UpdatesupplierRequest;
use Carbon\Carbon;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $clients = supplier::withSum('sales', 'amount')
                    ->withSum('sales', 'remaining')
                    ->get();

        return view('clients.suppliers', compact('clients'));
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
    public function store(StoresupplierRequest $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'purchase_type' => 'nullable|string|max:100',
        ]);

        supplier::create($validated);

        return redirect()->route('suppliers.index')->with('success', 'تم إضافة المورد بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(supplier $supplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatesupplierRequest $request, supplier $supplier)
    {
        $client = supplier::findOrFail($request->id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'purchase_type' => 'nullable|string|max:100',
        ]);

        $client->update($validated);

        return redirect()->route('suppliers.index')->with('success', 'تم تحديث بيانات العميل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(supplier $supplier)
    {
        //
    }
    public function totalAmount(supplier $supplier)
    {
        $translations = include resource_path('lang/ar/translate.php');
         $sales = $supplier->sales()->orderBy('date', 'desc')->get()->map(function ($sale) use ($translations) {
            $sale->type = $translations[$sale->type] ?? $sale->type;
            $sale->formatted_date = Carbon::parse($sale->date)->format('d-m-Y');
            return $sale;
        });

        return response()->json($sales);
    }
    public function totalRemaining(supplier $supplier)
    {
        $translations = include resource_path('lang/ar/translate.php');
        $sales = $supplier->sales()
            ->where('remaining', '>', 0)
            ->orderBy('date', 'desc')->get()
            ->map(function ($sale) use ($translations) {
            $sale->type = $translations[$sale->type] ?? $sale->type;
            $sale->formatted_date = Carbon::parse($sale->date)->format('d-m-Y');
            $sale->formatted_payment_due_date = Carbon::parse($sale->payment_due_date)->format('d-m-Y');
            return $sale;
        });

        return response()->json($sales);
    }
}
