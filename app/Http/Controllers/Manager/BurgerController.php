<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\StoreBurgerRequest;
use App\Http\Requests\Manager\UpdateBurgerRequest;
use App\Models\Burger;
use App\Models\Category;
use App\Services\BurgerService;

class BurgerController extends Controller
{

    protected BurgerService $burgerService;

    public function __construct(BurgerService $burgerService)
    {
        $this->burgerService = $burgerService;
        $this->authorizeResource(Burger::class, 'burger');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $burgers = Burger::with('category')->latest()->paginate(10);
        return view('manager.burgers.index', compact('burgers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('manager.burgers.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBurgerRequest $request)
    {
        $this->burgerService->createBurger($request->validated());

        return redirect()->route('manager.burgers.index')
            ->with('success', 'Le burger a été ajouté avec succès.');
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
        $categories = Category::all();
        return view('manager.burgers.edit', compact('burger', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBurgerRequest $request, Burger $burger)
    {
        $this->burgerService->updateBurger($burger, $request->validated());

        return redirect()->route('manager.burgers.index')
            ->with('success', 'Le burger a été mis à jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Burger $burger)
    {
        $this->burgerService->archiveBurger($burger);

        return redirect()->route('manager.burgers.index')
            ->with('success', 'Le burger a été archivé.');
    }
}
