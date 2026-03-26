<?php
namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Services\StatService;

class StatController extends Controller
{
    protected StatService $statService;

    public function __construct(StatService $statService)
    {
        $this->statService = $statService;
        $this->middleware('can:viewAny,App\Models\Order');
    }

    public function index()
    {
        $stats = [
            'quick' => $this->statService->getQuickStats(),
            'monthly' => $this->statService->getOrdersPerMonth(),
            'categories' => $this->statService->getProductsByCategory(),
            'top' => $this->statService->getTopSellingBurgers(),
        ];

        return view('manager.dashboard', compact('stats'));
    }
}
