<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Invoice;
use App\Models\Order;
use Carbon\Carbon;
use Carbon\Traits\Timestamp;

class InvoiceSeeder extends Seeder
{
    public function run(): void
    {
        $orders = Order::with('client')->get();

        if ($orders->count() === 0) {
            $this->command->warn('No orders found. Please run OrderSeeder first.');
            return;
        }

        foreach ($orders as $index => $order) {
            $invoiceNumber = 'INV-' . date('Ymd') . '-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT) . rand(100, 999);

            $invoice = new Invoice([
                'invoice_number' => $invoiceNumber,
                'order_id' => $order->id,
                'issue_date' => Carbon::now()->subDays(rand(1, 30)),
                'due_date' => Carbon::now()->addDays(rand(7, 30)),
                'total_amount' => $order->total_amount,
                'paid_amount' => $order->dp1 + $order->dp2 + $order->dp3,
                'remaining_amount' => $order->remaining_amount,
                'status' => $order->payment_status == 'Lunas' ? 'Paid' : 'Partial',
                'notes' => 'Invoice untuk pesanan ' . $order->order_number,
            ]);
            $invoice->save();
        }
    }
}
