<?php

namespace App\Http\Controllers;

use App\Models\daily_production;
use App\Http\Requests\Storedaily_productionRequest;
use App\Http\Requests\Updatedaily_productionRequest;

class DailyProductionController extends Controller
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
    public function store(Storedaily_productionRequest $request)
    {
        $validatedData = $request->validate([
            'buffaloMilk' => 'required|numeric|min:0',
            'cowMilk' => 'required|numeric|min:0',
            'eggs' => 'required|numeric|min:0',
            'dates' => 'required|numeric|min:0',
            'production_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        // إنشاء السجل الجديد مع إضافة created_by
        daily_production::create(array_merge($validatedData, [
            'created_by' => auth()->id()
        ]));

        return redirect()->back()->with('success', 'تم إضافة يومية الانتاج بنجاح!');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updatedaily_productionRequest $request, daily_production $daily_production)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(daily_production $daily_production)
    {
        //
    }
}
