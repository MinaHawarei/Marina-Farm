<?php

namespace App\Http\Controllers;

use App\Models\health_record;
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
        //
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
