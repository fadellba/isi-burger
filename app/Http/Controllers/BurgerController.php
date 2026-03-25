<?php

namespace App\Http\Controllers;

use App\Models\Burger;
use App\Http\Requests\StoreBurgerRequest;
use App\Http\Requests\UpdateBurgerRequest;

class BurgerController extends Controller
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
    public function store(StoreBurgerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Burger $burger)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Burger $burger)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBurgerRequest $request, Burger $burger)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Burger $burger)
    {
        //
    }
}
