<?php
namespace App\Services;

use App\Models\Order;
use App\Models\Burger;
use Illuminate\Support\Facades\DB;
use Exception;
use Throwable;

class OrderService
{
    protected BurgerService $burgerService;
    protected NotificationService $notificationService;

    public function __construct(BurgerService $burgerService, NotificationService $notificationService)
    {
        $this->burgerService = $burgerService;
        $this->notificationService = $notificationService;
    }

    /**
     * @throws Throwable
     */
    public function createOrder(array $data, int $userId)
    {
        foreach ($data['items'] as $item) {
            $burger = Burger::findOrFail($item['burger_id']);
            if (!$this->burgerService->hasAvailableStock($burger, $item['quantity'])) {
                throw new Exception("Stock insuffisant pour le burger : " . $burger->nom);
            }
        }

        return DB::transaction(function () use ($data, $userId) {
            $order = Order::create([
                'user_id' => $userId,
                'status' => 'en_attente',
                'total_price' => 0,
            ]);

            $total = 0;

            foreach ($data['items'] as $item) {
                $burger = Burger::find($item['burger_id']);
                $unitPrice = $burger->prix;
                $subtotal = $unitPrice * $item['quantity'];

                $order->burgers()->attach($burger->id, [
                    'quantity' => $item['quantity'],
                    'unit_price' => $unitPrice
                ]);

                $burger->decrement('stock', $item['quantity']);

                $total += $subtotal;
            }

            $order->update(['total_price' => $total]);

            $this->notificationService->sendOrderConfirmation($order);

            return $order;
        });
    }

    /**
     * @throws Exception
     */
    public function updateStatus(Order $order, string $newStatus): void
    {
        $oldStatus = $order->status;
        $order->update(['status' => $newStatus]);

        if ($newStatus === 'prete' && $oldStatus !== 'prete') {
            $this->notificationService->sendInvoice($order);
        }
    }
}
