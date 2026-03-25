<?php
namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Burger;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class StatService
{
    public function getQuickStats()
    {
        return [
            'orders_today' => Order::whereDate('created_at', today())->count(),
            'validated_today' => Order::whereDate('created_at', today())
                ->whereIn('status', ['prete', 'payee'])
                ->count(),
            'revenue_today' => Payment::whereDate('date_paiement', today())->sum('montant'),
        ];
    }
    public function getOrdersPerMonth()
    {
        return Order::select(
            DB::raw('count(id) as count'),
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month")
        )
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();
    }
    public function getProductsByCategory()
    {
        return Category::withCount('burgers')->get(['nom', 'burgers_count']);
    }
    public function getTopSellingBurgers()
    {
        return DB::table('burger_order')
            ->join('burgers', 'burger_order.burger_id', '=', 'burgers.id')
            ->select('burgers.nom', DB::raw('SUM(burger_order.quantity) as total_sales'))
            ->groupBy('burgers.id', 'burgers.nom')
            ->orderBy('total_sales', 'desc')
            ->limit(5)
            ->get();
    }
}
