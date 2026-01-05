<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Client;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $clients = Client::all();

        if ($clients->count() === 0) {
            $this->command->warn('No clients found. Please run ClientSeeder first.');
            return;
        }

        $orders = [
            [
                'order_number' => 'ORD-001',
                'client_id' => 1,
                'items' => [
                    ['name' => 'Paket Gaun Pengantin', 'quantity' => 1, 'price' => 5000000, 'total' => 5000000],
                    ['name' => 'Makeup Pengantin Wanita', 'quantity' => 1, 'price' => 2000000, 'total' => 2000000],
                    ['name' => 'Makeup Pengantin Pria', 'quantity' => 1, 'price' => 1500000, 'total' => 1500000],
                ],
                'total_amount' => 8500000,
                'payment_history' => [
                    ['dp_number' => 'DP1', 'amount' => 3000000, 'payment_method' => 'Transfer Bank', 'notes' => 'Pembayaran pertama', 'paid_at' => '2025-12-28 10:00:00'],
                    ['dp_number' => 'DP2', 'amount' => 2000000, 'payment_method' => 'Transfer Bank', 'notes' => null, 'paid_at' => '2026-01-02 14:30:00'],
                ],
                'payment_status' => 'Belum Lunas',
                'decorations' => ['Dekorasi Pelaminan', 'Bunga Segar'],
                'notes' => 'Akad pagi, resepsi siang',
            ],
            [
                'order_number' => 'ORD-002',
                'client_id' => 2,
                'items' => [
                    ['name' => 'Paket Gaun Pengantin', 'quantity' => 1, 'price' => 4500000, 'total' => 4500000],
                    ['name' => 'Makeup Pengantin', 'quantity' => 1, 'price' => 2500000, 'total' => 2500000],
                ],
                'total_amount' => 7000000,
                'payment_history' => [
                    ['dp_number' => 'DP1', 'amount' => 2000000, 'payment_method' => 'Cash', 'notes' => null, 'paid_at' => '2025-12-20 11:00:00'],
                    ['dp_number' => 'DP2', 'amount' => 2000000, 'payment_method' => 'Transfer Bank', 'notes' => null, 'paid_at' => '2025-12-30 09:00:00'],
                ],
                'payment_status' => 'Belum Lunas',
                'decorations' => ['Dekorasi Minimalis'],
                'notes' => 'Tema hijau putih',
            ],
            [
                'order_number' => 'ORD-003',
                'client_id' => 3,
                'items' => [
                    ['name' => 'Paket Lengkap Pengantin', 'quantity' => 1, 'price' => 10000000, 'total' => 10000000],
                ],
                'total_amount' => 10000000,
                'payment_history' => [
                    ['dp_number' => 'DP1', 'amount' => 3000000, 'payment_method' => 'Transfer Bank', 'notes' => null, 'paid_at' => '2025-12-15 15:00:00'],
                    ['dp_number' => 'DP2', 'amount' => 3000000, 'payment_method' => 'Transfer Bank', 'notes' => null, 'paid_at' => '2025-12-28 16:00:00'],
                ],
                'payment_status' => 'Belum Lunas',
                'decorations' => ['Dekorasi Mewah', 'Backdrop Premium'],
                'notes' => 'VIP package',
            ],
            [
                'order_number' => 'ORD-004',
                'client_id' => 4,
                'items' => [
                    ['name' => 'Paket Gaun', 'quantity' => 1, 'price' => 3500000, 'total' => 3500000],
                    ['name' => 'Makeup', 'quantity' => 1, 'price' => 1500000, 'total' => 1500000],
                ],
                'total_amount' => 5000000,
                'payment_history' => [
                    ['dp_number' => 'DP1', 'amount' => 1500000, 'payment_method' => 'E-Wallet', 'notes' => null, 'paid_at' => '2025-12-22 10:30:00'],
                    ['dp_number' => 'DP2', 'amount' => 1500000, 'payment_method' => 'Cash', 'notes' => null, 'paid_at' => '2026-01-01 11:00:00'],
                ],
                'payment_status' => 'Belum Lunas',
                'decorations' => ['Dekorasi Sederhana'],
                'notes' => 'Acara rumahan',
            ],
            [
                'order_number' => 'ORD-005',
                'client_id' => 5,
                'items' => [
                    ['name' => 'Paket Gaun Pengantin', 'quantity' => 1, 'price' => 4000000, 'total' => 4000000],
                    ['name' => 'Makeup Lengkap', 'quantity' => 1, 'price' => 2000000, 'total' => 2000000],
                ],
                'total_amount' => 6000000,
                'payment_history' => [
                    ['dp_number' => 'DP1', 'amount' => 2000000, 'payment_method' => 'Transfer Bank', 'notes' => null, 'paid_at' => '2025-12-25 14:00:00'],
                ],
                'payment_status' => 'Belum Lunas',
                'decorations' => ['Dekorasi Tradisional'],
                'notes' => 'Tema adat Jawa',
            ],
        ];

        foreach ($orders as $orderData) {
            if ($orderData['client_id'] <= $clients->count()) {
                $order = new Order($orderData);

                // Calculate remaining amount from payment history
                $paymentHistory = $orderData['payment_history'] ?? [];
                $totalPaid = array_sum(array_column($paymentHistory, 'amount'));
                $order->remaining_amount = $order->total_amount - $totalPaid;

                $order->save();
            }
        }
    }
}
