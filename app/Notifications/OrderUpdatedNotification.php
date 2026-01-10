<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Order;

class OrderUpdatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $order;
    public $changes;
    public $user;

    public function __construct(Order $order, array $changes, $user = null)
    {
        $this->order = $order;
        $this->changes = $changes;
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $mail = (new MailMessage)
            ->subject('[ROROO Wedding] 🔔 Update Pesanan #' . $this->order->id)
            ->greeting('Halo Admin,')
            ->line('Terdapat pembaruan data pada pesanan berikut:')
            ->line('**Nama Klien:** ' . ($this->order->client->client_name ?? '-'))
            ->line('**Order ID:** #' . $this->order->id);

        if (!empty($this->changes)) {
            $mail->line('---');
            $mail->line('**Detail Perubahan:**');

            // 1. KAMUS TERJEMAHAN (Tambahkan payment_history disini)
            $customLabels = [
                'total_amount'     => 'Total Harga',
                'remaining_amount' => 'Sisa Tagihan',
                'payment_status'   => 'Status Pembayaran',
                'notes'            => 'Catatan / Notes',
                'client_id'        => 'Data Klien',
                'items'            => 'Item Pesanan',
                'decorations'      => 'Dekorasi',
                'payment_history'  => 'Riwayat Pembayaran', // <--- DITAMBAHKAN
            ];

            foreach ($this->changes as $field => $change) {
                if ($change['old'] == $change['new']) {
                    continue;
                }
                // Ambil label bahasa Indonesia
                $fieldName = $customLabels[$field] ?? ucwords(str_replace('_', ' ', $field));

                // --- A. KHUSUS ITEMS ---
                if ($field === 'items') {
                    $mail->line('');
                    $mail->line("**Update {$fieldName}:**");

                    // -- Item Lama --
                    $mail->line('🔴 **Daftar Lama:**');
                    $this->renderItemList($mail, $change['old']);

                    // -- Item Baru --
                    $mail->line('🟢 **Daftar Baru:**');
                    $this->renderItemList($mail, $change['new']);
                    $mail->line('');
                }

                // --- B. KHUSUS PAYMENT HISTORY (LOGIKA BARU) ---
                elseif ($field === 'payment_history') {
                    $mail->line('');
                    $mail->line("**Update {$fieldName}:**");

                    // -- History Lama --
                    $mail->line('🔴 **Data Lama:**');
                    $this->renderPaymentList($mail, $change['old']);

                    // -- History Baru --
                    $mail->line('🟢 **Data Baru:**');
                    $this->renderPaymentList($mail, $change['new']);
                    $mail->line('');
                }

                // --- C. KHUSUS DECORATIONS ---
                elseif ($field === 'decorations') {
                    $mail->line("- **Update {$fieldName}:**");
                    $diffs = $this->formatDecorationsDiff($change['old'], $change['new']);

                    if (empty($diffs)) {
                        $mail->line("  (Data dekorasi diperbarui)");
                    } else {
                        foreach ($diffs as $diff) {
                            $mail->line("  • " . $diff);
                        }
                    }
                }

                // --- D. KHUSUS HARGA/UANG ---
                elseif (str_contains($field, 'amount') || str_contains($field, 'price')) {
                    $oldVal = 'Rp ' . number_format((float)$change['old'], 0, ',', '.');
                    $newVal = 'Rp ' . number_format((float)$change['new'], 0, ',', '.');
                    $mail->line("- **{$fieldName}**: {$oldVal} ➝ {$newVal}");
                }

                // --- E. DEFAULT ---
                else {
                    $oldVal = $this->formatValue($change['old']);
                    $newVal = $this->formatValue($change['new']);
                    $mail->line("- **{$fieldName}**: {$oldVal} ➝ {$newVal}");
                }
            }
        }

        if ($this->user) {
            $name = $this->user->name ?? $this->user->email ?? 'System';
            $mail->line('**Diubah oleh:** ' . $name);
        }

        $mail->line('Waktu: ' . now()->format('d F Y, H:i'));
        $mail->action('🔍 Cek Pesanan', route('orders.show', $this->order->id));

        return $mail;
    }

    // --- HELPER BARU: RENDER ITEM LIST ---
    private function renderItemList($mail, $json)
    {
        $items = is_string($json) ? json_decode($json, true) : $json;
        if (!empty($items) && is_array($items)) {
            foreach ($items as $item) {
                $txt = "• " . ($item['name'] ?? '-') .
                    " (x" . ($item['quantity'] ?? 1) . ") - " .
                    'Rp ' . number_format((float)($item['total'] ?? 0), 0, ',', '.');
                $mail->line($txt);
            }
        } else {
            $mail->line('• (Kosong)');
        }
    }

    // --- HELPER BARU: RENDER PAYMENT HISTORY (Supaya Rapi) ---
    private function renderPaymentList($mail, $json)
    {
        $payments = is_string($json) ? json_decode($json, true) : $json;

        if (!empty($payments) && is_array($payments)) {
            foreach ($payments as $pay) {
                // Format: "DP1: Rp 500.000 via Transfer (09 Jan 2026)"
                $dpName = $pay['dp_number'] ?? 'Payment';
                $amount = 'Rp ' . number_format((float)($pay['amount'] ?? 0), 0, ',', '.');
                $method = $pay['payment_method'] ?? '-';

                // Format Tanggal Cantik
                $date = '-';
                if (!empty($pay['paid_at'])) {
                    try {
                        $date = \Carbon\Carbon::parse($pay['paid_at'])->format('d M Y H:i');
                    } catch (\Exception $e) {
                    }
                }

                $mail->line("• **{$dpName}**: {$amount}");
                $mail->line("  Via: {$method} ({$date})");
            }
        } else {
            $mail->line('• (Belum ada pembayaran)');
        }
    }

    private function itemsToMarkdownTable($itemsJson)
    {
        // 1. Normalisasi Data
        $items = is_string($itemsJson) ? json_decode($itemsJson, true) : $itemsJson;

        // Jika kosong/error
        if (empty($items) || !is_array($items)) {
            return "_Tidak ada item_";
        }

        // 2. Header Tabel Markdown
        // Format: | Header | Header |
        //         | :--- | :---: | (Alignment: Kiri, Tengah)
        $table = "| Item | Qty | Harga | Total |\n";
        $table .= "|:---|:---:|:---:|:---:|\n";

        // 3. Isi Baris
        foreach ($items as $item) {
            $name = $item['name'] ?? '-';
            $qty = $item['quantity'] ?? 1;

            // Format Rupiah
            $price = 'Rp ' . number_format((float)($item['price'] ?? 0), 0, ',', '.');
            $total = 'Rp ' . number_format((float)($item['total'] ?? 0), 0, ',', '.');

            // Susun baris tabel
            $table .= "| {$name} | {$qty} | {$price} | {$total} |\n";
        }

        return $table;
    }
    // --- HELPER BARU UNTUK MEMBANDINGKAN DEKORASI ---
    private function formatDecorationsDiff($oldJson, $newJson)
    {
        $old = is_string($oldJson) ? json_decode($oldJson, true) : $oldJson;
        $new = is_string($newJson) ? json_decode($newJson, true) : $newJson;

        $old = is_array($old) ? $old : [];
        $new = is_array($new) ? $new : [];

        $diffs = [];

        // Cek semua key yang ada di data BARU
        foreach ($new as $key => $value) {
            $label = ucwords(str_replace('_', ' ', $key)); // photo_pelaminan -> Photo Pelaminan
            $oldVal = $old[$key] ?? null;

            // Jika value beda dengan yang lama
            if ($value !== $oldVal) {
                // Cek apakah ini file upload (biasanya path panjang atau ada 'decorations/')
                if (is_string($value) && (str_contains($value, '/') || str_contains($value, 'decorations'))) {
                    if (empty($oldVal)) {
                        $diffs[] = "**{$label}**: 📸 Foto Baru Diupload";
                    } else {
                        $diffs[] = "**{$label}**: 📸 Foto Diganti/Diperbarui";
                    }
                } else {
                    // Jika cuma teks biasa (misal warna tenda)
                    $oldText = $oldVal ?: '-';
                    $newText = $value ?: '-';
                    $diffs[] = "**{$label}**: {$oldText} ➝ {$newText}";
                }
            }
        }

        return $diffs;
    }

    // Helper untuk merapikan JSON Items
    private function formatItemsList($itemsJson)
    {
        // Jika null/kosong
        if (empty($itemsJson) || $itemsJson == '[]') return '-';

        // Jika bentuknya string JSON, decode dulu
        $items = is_string($itemsJson) ? json_decode($itemsJson, true) : $itemsJson;

        if (!is_array($items)) return (string) $itemsJson;

        // Buat list nama barang + quantity
        $formatted = array_map(function ($item) {
            $name = $item['name'] ?? 'Item';
            $qty = $item['quantity'] ?? 1;
            return "{$name} (x{$qty})";
        }, $items);

        return implode(', ', $formatted);
    }

    // Helper untuk value biasa
    private function formatValue($value)
    {
        if ($value instanceof \DateTimeInterface) {
            return $value->format('d M Y H:i');
        }
        if (is_bool($value)) {
            return $value ? 'Ya' : 'Tidak';
        }
        if (is_null($value) || $value === '') {
            return '-';
        }
        // Bersihkan tanda kutip jika sisa json_encode
        return trim((string) $value, '"');
    }
}
