<?php
namespace App\Services;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Exception;

class InvoiceService
{
    /**
     * @throws Exception
     */
    public function generateInvoice(Order $order): string
    {
        if ($order->burgers->isEmpty()) {
            throw new Exception("Impossible de générer une facture : la commande est vide.");
        }

        $order->load(['user', 'burgers']);

        $data = [
            'order' => $order,
            'date'  => now()->format('d/m/Y H:i'),
        ];

        $pdf = Pdf::loadView('pdf.invoice', $data);

        $fileName = 'invoices/facture_burger_' . $order->id . '_' . time() . '.pdf';
        Storage::disk('public')->put($fileName, $pdf->output());

        return $fileName;
    }
}
