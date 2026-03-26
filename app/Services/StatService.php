<?php
namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Category;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use LaravelIdea\Helper\App\Models\_IH_Category_C;
use LaravelIdea\Helper\App\Models\_IH_Order_C;

class StatService
{
    public function getQuickStats(): array
    {
        return [
            'orders_today' => Order::whereDate('created_at', today())->count(),
            'validated_today' => Order::whereDate('created_at', today())
                ->whereIn('status', ['prete', 'payee'])
                ->count(),
            'revenue_today' => Payment::whereDate('date_paiement', today())->sum('montant'),
        ];
    }
    public function getOrdersPerMonth(): array|_IH_Order_C
    {
        return Order::select(
            DB::raw('count(id) as count'),
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month")
        )
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    }
    public function getProductsByCategory(): _IH_Category_C|array
    {
        return Category::withCount('burgers')->get(['nom', 'burgers_count']);
    }
    public function getTopSellingBurgers(): Collection
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
