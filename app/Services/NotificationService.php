<?php
namespace App\Services;

use App\Mail\NewOrderAdminMail;
use App\Models\Order;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmedMail;
use App\Mail\InvoiceMail;

class NotificationService
{
    protected InvoiceService $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }
    public function sendOrderConfirmation(Order $order): void
    {
        Mail::to($order->user->email)->send(new OrderConfirmedMail($order));

        $managers = User::where('role', 'manager')->get();
        foreach ($managers as $manager) {
            Mail::to($manager->email)->send(new NewOrderAdminMail($order, $manager));
        }
    }

    /**
     * @throws Exception
     */
    public function sendInvoice(Order $order): void
    {
        //$pdfPath = $this->invoiceService->generateInvoice($order);
        Mail::to($order->user->email)->send(new InvoiceMail($order));
    }
}
