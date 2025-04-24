<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Http\Requests\StoreAnimalRequest;
use App\Http\Requests\UpdateAnimalsRequest;

class AnimalController extends Controller
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

     public function store(StoreAnimalRequest $request)
     {
         // التحقق من البيانات (بدون created_by)
         $validatedData = $request->validate([
             'animal_code' => 'required|unique:animals',
             'type' => 'required',
             'breed' => 'nullable|string',
             'age' => 'required|integer|min:0',
             'weight' => 'required|numeric|min:0',
             'health_status' => 'nullable|string',
             'gender' => 'required|in:Male,Female',
             'origin' => 'required|string',
             'arrival_date' => 'required|date',
             'status' => 'required|string',
             'pen_id' => 'required|string',
             'insemination_type' => 'required|string',
         ]);

         // إنشاء السجل الجديد مع إضافة created_by
         Animal::create(array_merge($validatedData, [
             'created_by' => auth()->id()
         ]));

         return redirect()->route('buffalo')->with('success', 'تم إضافة الحيوان بنجاح!');
     }

    /**
     * Display the specified resource.
     */
    public function show(Animal $animals)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Animal $animals)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAnimalsRequest $request, Animal $animals)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Animal $animals)
    {
        //
    }
}
