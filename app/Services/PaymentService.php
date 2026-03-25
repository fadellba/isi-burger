<?php
namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Exception;

class PaymentService
{
    public function recordPayment(Order $order, array $data)
    {
        if ($order->payment()->exists() || $order->status === 'payee') {
            throw new Exception("Cette commande a déjà été réglée.");
        }

        if ($order->status === 'annulee') {
            throw new Exception("Impossible de payer une commande annulée.");
        }

        return DB::transaction(function () use ($order, $data) {
            $payment = Payment::create([
                'order_id'       => $order->id,
                'montant'        => $data['montant'],
                'date_paiement'  => $data['date_paiement'] ?? now(),
            ]);

            $order->update(['status' => 'payee']);

            return $payment;
        });
    }
    public function getDailyRevenue()
    {
        return Payment::whereDate('date_paiement', today())->sum('montant');
    }
}
