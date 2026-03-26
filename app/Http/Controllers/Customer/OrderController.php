<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\StoreOrderRequest;
use App\Models\Order;
use App\Models\User;
use App\Services\CategoryService;
use App\Services\OrderService;
use Auth;
use Illuminate\Http\Request;
use Throwable;

class OrderController extends Controller
{
    protected OrderService $orderService;
    protected CategoryService $categoryService;

    public function __construct(OrderService $orderService, CategoryService $categoryService)
    {
        $this->orderService = $orderService;
        $this->categoryService = $categoryService;
        $this->authorizeResource(Order::class, 'order');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /** @var User $user */
        $myOrders = Auth::user()->orders()->latest()->paginate(5);
        $categories = $this->categoryService->getActiveCategoriesWithBurgers();

        return view('customer.dashboard', compact('myOrders', 'categories'));
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
     * @throws Throwable
     */
    public function store(StoreOrderRequest $request)
    {
        $order = $this->orderService->createOrder((array)Auth::user(), $request->validated());

        return redirect()->route('customer.orders.show', $order)
            ->with('success', 'Votre commande a été enregistrée !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load(['burgers', 'payment']);
        return view('customer.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
