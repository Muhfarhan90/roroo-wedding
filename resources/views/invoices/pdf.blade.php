<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            background: white;
            padding: 30px 40px;
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            width: 100px;
            height: auto;
            margin-bottom: 10px;
        }

        .header h1 {
            font-size: 22px;
            color: #8b7355;
            margin: 0 0 5px 0;
            font-weight: bold;
        }

        .header-meta {
            font-size: 11px;
            color: #666;
            margin-top: 5px;
        }

        /* Section Titles */
        .section-title {
            font-size: 13px;
            font-weight: bold;
            color: #8b7355;
            border-bottom: 2px solid #d4b896;
            padding-bottom: 5px;
            margin: 20px 0 15px 0;
        }

        /* Info Section - Two Column Layout */
        .info-section {
            display: table;
            width: 100%;
            margin: 20px 0;
        }

        .column-left {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding-right: 30px;
        }

        .column-right {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding-left: 30px;
        }

        .info-title {
            font-size: 11px;
            font-weight: bold;
            color: #e8b896;
            margin-bottom: 8px;
        }

        .client-name {
            font-size: 13px;
            font-weight: bold;
            color: #000;
            margin-bottom: 8px;
        }

        .info-row {
            font-size: 11px;
            color: #4b5563;
            margin-bottom: 4px;
            line-height: 1.5;
        }

        .info-row strong {
            font-weight: 600;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0 15px 0;
        }

        table thead tr {
            background: white;
            border-bottom: 2px solid #e5e7eb;
        }

        table th {
            padding: 8px 12px;
            text-align: left;
            font-weight: 600;
            font-size: 10px;
            text-transform: uppercase;
            color: #e8b896;
        }

        table td {
            padding: 10px 12px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 11px;
            color: #374151;
        }

        table tbody tr:last-child td {
            border-bottom: none;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        /* Payment Summary Box */
        .payment-summary {
            background: white;
            padding: 15px 0;
            margin: 20px 0 0 0;
            border-top: 2px solid #e5e7eb;
        }

        .summary-container {
            width: 350px;
            margin-left: auto;
        }

        .summary-row {
            display: table;
            width: 100%;
            padding: 8px 0;
        }

        .summary-label {
            display: table-cell;
            text-align: left;
            font-size: 11px;
            color: #4b5563;
        }

        .summary-value {
            display: table-cell;
            text-align: right;
            font-size: 11px;
            font-weight: 600;
            color: #111827;
        }

        .summary-row.subtotal {
            padding-bottom: 8px;
        }

        .summary-row.total {
            border-top: 2px solid #1f2937;
            border-bottom: 2px solid #1f2937;
            padding: 12px 0;
            margin-top: 8px;
        }

        .summary-row.total .summary-label,
        .summary-row.total .summary-value {
            font-size: 13px;
            font-weight: bold;
            color: #111827;
        }

        .summary-row.paid {
            background: #f0fdf4;
            padding: 12px 16px;
            margin: 8px 0;
            border-radius: 4px;
        }

        .summary-row.paid .summary-label {
            color: #374151;
        }

        .summary-row.paid .summary-value {
            color: #16a34a;
            font-weight: 600;
        }

        .summary-row.remaining {
            background: #fff3e0;
            border: 1px solid #ffb74d;
            padding: 12px 16px;
            margin: 8px 0;
            border-radius: 4px;
        }

        .summary-row.remaining .summary-label {
            color: #111827;
            font-weight: 600;
        }

        .summary-row.remaining .summary-value {
            color: #f57c00;
            font-weight: bold;
        }

        /* Notes Section */
        .notes {
            background: white;
            padding: 20px 0;
            margin: 20px 0;
            border-top: 2px solid #e5e7eb;
            font-size: 11px;
            color: #374151;
            line-height: 1.6;
        }

        .notes-title {
            font-size: 10px;
            font-weight: bold;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
        }

        .notes p {
            margin-bottom: 8px;
        }

        /* Bank Info */
        .bank-info {
            background: white;
            padding: 20px 0;
            margin: 20px 0;
            border-top: 1px solid #e5e7eb;
        }

        .bank-title {
            font-size: 10px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 8px;
        }

        .bank-info p {
            font-size: 10px;
            color: #4b5563;
            margin: 2px 0;
        }

        .bank-grid {
            display: table;
            width: 100%;
        }

        .bank-item {
            display: table-cell;
            width: 50%;
            text-align: center;
            padding: 10px;
        }

        .bank-name {
            font-weight: bold;
            color: #333;
            font-size: 12px;
            margin-bottom: 5px;
        }

        .bank-account {
            font-size: 12px;
            color: #8b7355;
            font-weight: bold;
            letter-spacing: 1px;
            margin-bottom: 3px;
        }

        .bank-owner {
            font-size: 10px;
            color: #888;
        }

        /* Footer */
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #e0e0e0;
            text-align: center;
            font-size: 10px;
            color: #999;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div
        style="display: table; width: 100%; margin-bottom: 30px; border-bottom: 2px solid #e8d5c4; padding-bottom: 20px;">
        <div style="display: table-cell; width: 50%; vertical-align: middle;">
            <div style="display: table; width: 100%;">
                <div style="display: table-cell; width: 80px; vertical-align: middle;">
                    <img src="{{ public_path('logo/logo-roroo-wedding.PNG') }}" alt="RORO MUA Logo"
                        style="width: 70px; height: 70px; border-radius: 50%; border: 2px solid #d4b896; object-fit: cover;">
                </div>
                <div style="display: table-cell; vertical-align: middle; padding-left: 15px;">
                    <h1 style="font-size: 48px; font-weight: bold; color: #555; margin: 0; line-height: 1;">FAKTUR</h1>
                    <p style="font-size: 10px; color: #666; margin: 5px 0 0 0;">{{ $invoice->invoice_number }}</p>
                </div>
            </div>
        </div>
        <div style="display: table-cell; width: 50%; vertical-align: top; text-align: right;">
            <h3 style="font-size: 16px; font-weight: bold; color: #333; margin: 0 0 5px 0;">RORO MUA</h3>
            <p style="font-size: 9px; color: #666; margin: 2px 0;">Perumahan Kaliwulu blok AC no.1</p>
            <p style="font-size: 9px; color: #666; margin: 2px 0;">Kec.Plered Kab Cirebon</p>
            <p style="font-size: 9px; color: #666; margin: 2px 0;">(Depan Lapangan)</p>
        </div>
    </div>

    <!-- Info Section - Two Column -->
    <div class="info-section">
        <div class="column-left">
            <p class="info-title">DITERBITKAN KEPADA</p>
            <p class="client-name">{{ $invoice->order->client->bride_name }} & {{ $invoice->order->client->groom_name }}
            </p>

            <p class="info-row"><strong>HP Pengantin Wanita:</strong> {{ $invoice->order->client->bride_phone }}</p>
            @if ($invoice->order->client->groom_phone)
                <p class="info-row"><strong>HP Pengantin Pria:</strong> {{ $invoice->order->client->groom_phone }}</p>
            @endif
            <p class="info-row"><strong>Tanggal Akad:</strong>
                {{ $invoice->order->client->akad_date ? \Carbon\Carbon::parse($invoice->order->client->akad_date)->format('d F Y') : '-' }}
            </p>
            <p class="info-row"><strong>Tanggal Resepsi:</strong>
                {{ $invoice->order->client->reception_date ? \Carbon\Carbon::parse($invoice->order->client->reception_date)->format('d F Y') : '-' }}
            </p>
            <p class="info-row"><strong>Alamat Venue:</strong> {{ $invoice->order->client->event_location ?? '-' }}</p>
        </div>

        <div class="column-right">
            <p class="info-title" style="text-align: right;">DETAIL PEMBAYARAN</p>
            @php
                $paymentHistory = $invoice->order->payment_history ?? [];
                $totalPaidCheck = 0;
                foreach ($paymentHistory as $payment) {
                    $totalPaidCheck += floatval($payment['amount'] ?? 0);
                }
                $isFullyPaid = $totalPaidCheck >= $invoice->total_amount;
            @endphp
            <div style="text-align: right;">
                <p class="info-row" style="margin-bottom: 4px;">
                    <span style="color: #4b5563;">Tanggal Terbit:</span>
                    <span
                        style="font-weight: 600; color: #111827;">{{ \Carbon\Carbon::parse($invoice->issue_date)->format('M d, Y') }}</span>
                </p>
                <p class="info-row" style="margin-bottom: 4px;">
                    <span style="color: #4b5563;">Jatuh Tempo:</span>
                    @if ($isFullyPaid)
                        <span style="color: #16a34a; font-weight: 600;">Lunas ✓</span>
                    @else
                        <span
                            style="font-weight: 600; color: #111827;">{{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}</span>
                    @endif
                </p>
                <p class="info-row">
                    <span style="color: #4b5563;">ID Pesanan:</span>
                    <span style="font-weight: 600; color: #111827;">{{ $invoice->order->order_number }}</span>
                </p>
            </div>
        </div>
    </div>

    <!-- Items Table -->
    <table>
        <thead>
            <tr>
                <th>LAYANAN</th>
                <th class="text-center" style="width: 60px;">QTY</th>
                <th class="text-right" style="width: 120px;">HARGA</th>
                <th class="text-right" style="width: 120px;">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @if (is_array($invoice->order->items) && count($invoice->order->items) > 0)
                @foreach ($invoice->order->items as $item)
                    @if (!empty($item['name']) && $item['name'] !== 'N/A' && !empty($item['price']) && $item['price'] > 0)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td class="text-center">{{ $item['quantity'] ?? 1 }}</td>
                            <td class="text-right">Rp {{ number_format($item['price'] ?? 0, 0, ',', '.') }}</td>
                            <td class="text-right" style="font-weight: 600;">Rp
                                {{ number_format($item['total'] ?? 0, 0, ',', '.') }}</td>
                        </tr>
                    @endif
                @endforeach
            @endif

            @if (is_array($invoice->order->decorations) && count($invoice->order->decorations) > 0)
                @foreach ($invoice->order->decorations as $decoration)
                    @if (
                        !empty($decoration['name']) &&
                            $decoration['name'] !== 'N/A' &&
                            !empty($decoration['price']) &&
                            $decoration['price'] > 0)
                        <tr>
                            <td>{{ $decoration['name'] }}</td>
                            <td class="text-center">1</td>
                            <td class="text-right">Rp {{ number_format($decoration['price'] ?? 0, 0, ',', '.') }}</td>
                            <td class="text-right" style="font-weight: 600;">Rp
                                {{ number_format($decoration['price'] ?? 0, 0, ',', '.') }}</td>
                        </tr>
                    @endif
                @endforeach
            @endif
        </tbody>
    </table>

    <!-- Payment Summary -->
    <div class="payment-summary">
        @php
            $paymentHistory = $invoice->order->payment_history ?? [];
            $totalPaid = 0;
            foreach ($paymentHistory as $payment) {
                $totalPaid += floatval($payment['amount'] ?? 0);
            }
        @endphp

        <div class="summary-container">
            <div class="summary-row subtotal">
                <div class="summary-label">Subtotal</div>
                <div class="summary-value">Rp {{ number_format($invoice->order->total_amount, 0, ',', '.') }}</div>
            </div>

            @foreach ($paymentHistory as $index => $payment)
                <div class="summary-row"
                    style="@if ($loop->last) border-bottom: 2px solid #e8b896; padding-bottom: 10px; @endif">
                    <div class="summary-label">{{ $payment['dp_number'] ?? 'DP ' . ($index + 1) }}</div>
                    <div class="summary-value">Rp {{ number_format($payment['amount'] ?? 0, 0, ',', '.') }}</div>
                </div>
            @endforeach

            <div class="summary-row total">
                <div class="summary-label">Jumlah Total</div>
                <div class="summary-value">Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <!-- Total Dibayar - Full Width -->
    <div style="background: #f0fdf4; padding: 12px 16px; margin-bottom: 8px; border-radius: 4px;">
        <div class="summary-container">
            <div style="display: table; width: 100%;">
                <div style="display: table-cell; text-align: left; font-size: 11px; color: #374151;">Total Dibayar</div>
                <div style="display: table-cell; text-align: right; font-size: 11px; font-weight: 600; color: #16a34a;">
                    Rp {{ number_format($totalPaid, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <!-- Sisa Tagihan - Full Width -->
    <div style="background: #fff3e0; border: 1px solid #ffb74d; padding: 12px 16px; border-radius: 4px;">
        <div class="summary-container">
            <div style="display: table; width: 100%;">
                <div style="display: table-cell; text-align: left; font-size: 11px; color: #111827; font-weight: 600;">
                    Sisa Tagihan</div>
                <div
                    style="display: table-cell; text-align: right; font-size: 11px; font-weight: bold; color: #f57c00;">
                    Rp {{ number_format($invoice->total_amount - $totalPaid, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <!-- Notes -->
    @php
        $lastPayment = count($paymentHistory) > 0 ? end($paymentHistory) : null;
    @endphp
    @if ($lastPayment)
        <div class="notes">
            <div class="notes-title">CATATAN / KETERANGAN</div>
            <p style="margin-bottom: 8px;"><strong>Invoice untuk:</strong> Pembayaran
                {{ $lastPayment['dp_number'] ?? 'N/A' }} -
                {{ $invoice->order->order_number }}</p>
            <p style="margin-bottom: 8px;"><strong>Catatan pembayaran:</strong> Pembayaran
                {{ $lastPayment['dp_number'] ?? 'N/A' }} untuk pesanan
                {{ $invoice->order->order_number }}</p>
            <p style="margin-top: 15px; font-style: italic;">Terima kasih telah memilih ROROO MUA untuk hari istimewa
                Anda! Kami sangat menghargai kepercayaan
                Anda.</p>
        </div>
    @endif

    <!-- Bank Info -->
    <div class="bank-info">
        <div class="bank-title">Informasi Banking Bank</div>
        <p style="font-size: 11px; color: #333; margin-bottom: 4px;">BCA: 774 539 3493 a/n Tatimatu Ghofaroh</p>
        <p style="font-size: 11px; color: #333;">BRI: 0101 01030 547 563 a/n Tatimatu Ghofaroh</p>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d F Y, H:i') }} WIB</p>
        <p style="margin-top: 5px;">© 2026 ROROO MUA - Wedding Services</p>
    </div>
</body>

</html>
