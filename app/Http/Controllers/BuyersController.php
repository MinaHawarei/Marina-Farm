<?php

namespace App\Http\Controllers;

use App\Models\buyers;
use App\Models\daily_sale;

use App\Http\Requests\StorebuyersRequest;
use App\Http\Requests\UpdatebuyersRequest;
use Carbon\Carbon;

class BuyersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = buyers::withSum('sales', 'amount')
                    ->withSum('sales', 'remaining')
                    ->get();

        return view('clients.index', compact('clients'));
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
    public function store(StorebuyersRequest $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'purchase_type' => 'nullable|string|max:100',
        ]);

        buyers::create($validated);

        return redirect()->route('clients.index')->with('success', 'تم إضافة العميل بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(buyers $buyers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(buyers $buyers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatebuyersRequest $request, buyers $buyers)
    {
        $client = buyers::findOrFail($request->id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'purchase_type' => 'nullable|string|max:100',
        ]);

        $client->update($validated);

        return redirect()->route('clients.index')->with('success', 'تم تحديث بيانات العميل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(buyers $buyers)
    {
        //
    }
    public function totalAmount(buyers $buyers)
    {
        $translations = include resource_path('lang/ar/translate.php');
         $sales = $buyers->sales()->orderBy('date', 'desc')->get()->map(function ($sale) use ($translations) {
            $sale->type = $translations[$sale->type] ?? $sale->type; // ترجم إن وجد، وإلا رجّع الأصل
            $sale->formatted_date = Carbon::parse($sale->date)->format('d-m-Y');
            return $sale;
        });

        return response()->json($sales);
    }
    public function totalRemaining(buyers $buyers)
    {
        $translations = include resource_path('lang/ar/translate.php');
        $sales = $buyers->sales()
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
