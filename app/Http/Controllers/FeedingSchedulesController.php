<?php

namespace App\Http\Controllers;

use App\Models\feeding_schedules;
use App\Http\Requests\Storefeeding_schedulesRequest;
use App\Http\Requests\Updatefeeding_schedulesRequest;

class FeedingSchedulesController extends Controller
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
    public function store(Storefeeding_schedulesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(feeding_schedules $feeding_schedules)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(feeding_schedules $feeding_schedules)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updatefeeding_schedulesRequest $request, feeding_schedules $feeding_schedules)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(feeding_schedules $feeding_schedules)
    {
        //
    }
}
