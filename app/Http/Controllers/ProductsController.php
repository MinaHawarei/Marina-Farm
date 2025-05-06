<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreproductsRequest;
use App\Http\Requests\UpdateproductsRequest;

class ProductsController extends Controller
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
    public function store(StoreproductsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(product $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(product $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateproductsRequest $request, product $products)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(product $products)
    {
        //
    }
}
