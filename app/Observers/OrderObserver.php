<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\Invoice;

class OrderObserver
{
    /**
     * Handle the Order "updated" event.
     * Automatically sync invoice when order payment is updated
     */
    public function updated(Order $order)
    {
        // Check if payment_history or payment-related fields were updated
        if ($order->wasChanged(['payment_history', 'remaining_amount', 'payment_status', 'total_amount'])) {
            $this->syncInvoice($order);
        }
    }

    /**
     * Sync invoice with order payment data
     */
    private function syncInvoice(Order $order)
    {
        $invoice = Invoice::where('order_id', $order->id)->first();

        if ($invoice) {
            // Calculate total paid from payment_history
            $paymentHistory = is_array($order->payment_history) ? $order->payment_history : [];
            $totalPaid = collect($paymentHistory)->sum('amount');

            // Update invoice
            $invoice->paid_amount = $totalPaid;
            $invoice->total_amount = $order->total_amount;
            $invoice->remaining_amount = max(0, $invoice->total_amount - $totalPaid);

            // Update invoice status
            if ($invoice->paid_amount >= $invoice->total_amount) {
                $invoice->status = 'Paid';
            } elseif ($invoice->paid_amount > 0) {
                $invoice->status = 'Partial';
            } else {
                $invoice->status = 'Unpaid';
            }

            $invoice->saveQuietly(); // Use saveQuietly to prevent infinite loop
        }
    }
}
