<?php

namespace App\Http\Controllers;

use App\Models\health_record;
use App\Models\Animal;
use App\Http\Requests\Storehealth_recordRequest;
use App\Http\Requests\Updatehealth_recordRequest;

class HealthRecordController extends Controller
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
    public function store(Storehealth_recordRequest $request)
    {
        $validatedData = $request->validate([
             'animal_id' => 'nullable',
             'date' => 'required',
             'treatment_type' => 'required',
             'veterinarian_name' => 'required',
             'cost' => 'required|numeric|min:0',
         ]);

        if ($request->treatment_type === 'تطعيم عام') {
            // تطبيق على كل الحيوانات من النوع المحدد
            $animals = Animal::where('type', $request->animal_type)->get();

            foreach ($animals as $animal) {
                health_record::create([
                    'animal_id' => $animal->id,
                    'date' => $request->date,
                    'treatment_type' => $request->treatment_type,
                    'veterinarian_name' => $request->veterinarian_name,
                    'cost' => $request->cost,
                    'notes' => $request->notes,
                    'created_by' => auth()->id(),
                ]);
            }
        } else {
            // لحيوان واحد
            health_record::create(array_merge($validatedData, [
             'created_by' => auth()->id()
            ]));
        }

        return redirect()->back()->with('success', 'تم حفظ التقرير الصحي بنجاح');

    }

    /**
     * Display the specified resource.
     */
    public function show(health_record $health_record)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(health_record $health_record)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updatehealth_recordRequest $request, health_record $health_record)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(health_record $health_record)
    {
        //
    }
}
