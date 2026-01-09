<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10px;
            line-height: 1.5;
            color: #1f2937;
            background: white;
            padding: 20px 20px;
            border: 2px solid #d4b896;
            border-radius: 2%;
            margin: 40px 40px;
        }

        /* Header */
        .header {
            display: table;
            width: 100%;
            margin-bottom: 10px;
            border-bottom: 2px solid #d4b896;
            padding-bottom: 10px;
        }

        .logo {
            display: table-cell;
            width: 60px;
            vertical-align: top;
        }

        .logo img {
            width: 60px;
            height: 60px;
        }

        .header-center {
            display: table-cell;
            vertical-align: top;
            padding-left: 8px;
        }

        .header h1 {
            font-size: 22px;
            color: #111827;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.7px;
        }

        .header-meta {
            font-size: 9px;
            color: #1f2937;
        }

        .header-right {
            display: table-cell;
            width: 200px;
            text-align: right;
            vertical-align: top;
        }

        .company-info {
            font-size: 9px;
            color: #1f2937;
            line-height: 1.6;
        }

        .company-name {
            font-weight: bold;
            font-size: 11px;
            color: #111827;
            margin-bottom: 3px;
        }

        /* Section Titles */
        .section-title {
            font-size: 12px;
            font-weight: bold;
            color: #ea580c;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 20px 0 12px 0;
        }

        /* Info Section - Two Column Layout */
        .info-section {
            display: table;
            width: 100%;
        }

        .column-left {
            display: table-cell;
            width: 60%;
            vertical-align: top;
            padding-right: 30px;
        }

        .column-right {
            display: table-cell;
            width: 40%;
            vertical-align: top;
        }

        .info-title {
            font-size: 9px;
            font-weight: bold;
            color: #8b6f47;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .client-name {
            font-size: 9px;
            font-weight: bold;
            color: #111827;
            margin-bottom: 6px;
        }

        .info-row {
            font-size: 9px;
            color: #111827;
            margin-bottom: 4px;
            line-height: 1.1;
        }

        .info-label {
            color: #6b7280;
            font-weight: 600;
        }

        .info-value {
            font-weight: bold;
            color: #111827;
        }

        .info-value-paid {
            font-weight: 600;
            color: #16a34a;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0 0 0;
        }

        table thead tr {
            background: white;
            color: #8b6f47;
            border-bottom: 2px solid #d4b896;
        }

        table th {
            padding: 10px 8px;
            text-align: left;
            font-weight: 600;
            font-size: 9px;
            text-transform: uppercase;
            color: #8b6f47;
            letter-spacing: 0.3px;
            border-top: 2px solid #d4b896;
        }

        table td {
            padding: 6px 8px;
            border-bottom: 1px solid #d4b896;
            font-size: 10px;
            color: #1f2937;
        }

        table tbody tr:last-child td {
            border-bottom: 1px solid #d4b896;
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
        }

        .summary-container {
            width: 240px;
            margin-left: auto;
        }

        .summary-row {
            display: table;
            width: 100%;
            padding: 6px 0;
        }

        .summary-label {
            display: table-cell;
            text-align: left;
            font-size: 10px;
            color: #6b7280;
        }

        .summary-value {
            display: table-cell;
            text-align: right;
            font-size: 10px;
            font-weight: 600;
            color: #1f2937;
        }

        .summary-row.subtotal {
            padding: 4px 0;
        }

        .summary-row.total {
            border-bottom: 2px solid #d4b896;
            padding: 4px 0;
        }

        .summary-row.total .summary-label,
        .summary-row.total .summary-value {
            font-size: 12px;
            font-weight: bold;
            color: #111827;
        }

        .summary-row.paid {
            padding: 6px 10px;
        }

        .summary-row.paid .summary-label {
            color: #166534;
            font-weight: 600;
            font-size: 10px;
        }

        .summary-row.paid .summary-value {
            color: #16a34a;
            font-weight: bold;
            font-size: 11px;
        }

        .dp-container {
            background: #f0fdf4;
            border: 1px solid #86efac;
            border-radius: 4px;
            padding: 8px 10px;
            margin: 8px 0;
        }

        .dp-item {
            display: table;
            width: 100%;
            padding: 4px 0;
            border-bottom: 1px solid #d1fae5;
        }

        .dp-item:last-child {
            border-bottom: none;
        }

        .dp-label {
            display: table-cell;
            text-align: left;
            font-size: 10px;
            color: #166534;
            font-weight: 600;
        }

        .dp-value {
            display: table-cell;
            text-align: right;
            font-size: 11px;
            color: #16a34a;
            font-weight: bold;
        }

        .summary-row.remaining {
            background: #fff7ed;
            border: 1px solid #fed7aa;
            padding: 6px 8px;
            margin: 5px 0;
            border-radius: 4px;
        }

        .summary-row.remaining .summary-label {
            color: #9a3412;
            font-weight: 600;
            font-size: 10px;
        }

        .summary-row.remaining .summary-value {
            color: #ea580c;
            font-weight: bold;
            font-size: 11px;
        }

        /* Notes Section */
        .notes {
            font-size: 9px;
            color: #4b5563;
            padding: 10px 0;
        }

        .notes-title {
            font-size: 9px;
            font-weight: bold;
            color: #8b6f47;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        /* Bank Info */
        .bank-info {
            background: white;
            padding: 10px 0;
            margin: 10px 0;
            border-top: 1px solid #d4b896;
        }

        .bank-title {
            font-size: 9px;
            font-weight: bold;
            color: #111827;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
        }

        .bank-info p {
            font-size: 9px;
            color: #6b7280;
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
            color: #111827;
            font-size: 11px;
            margin-bottom: 5px;
        }

        .bank-account {
            font-size: 11px;
            color: #1f2937;
            font-weight: bold;
            letter-spacing: 0.5px;
            margin-bottom: 3px;
        }

        .bank-holder {
            font-size: 9px;
            color: #6b7280;
        }

        .bank-center {
            width: 100%;
            padding: 5px 0;
            border-top: 1px solid #e5e7eb;
            text-align: center;
        }

        .bank-center-title {
            font-size: 10px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 6px;
            text-align: center;
        }

        .bank-flex {
            display: inline-block;
            text-align: center;
        }

        .bank-flex-item {
            display: inline-block;
            font-size: 11px;
            color: #333;
            min-width: 180px;
            margin: 0 10px;
            vertical-align: top;
        }

        .bank-flex-name {
            font-weight: bold;
        }

        .bank-flex-holder {
            font-size: 10px;
            color: #666;
        }

        /* Footer */
        .footer {
            padding-top: 15px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 8px;
            color: #9ca3af;
            line-height: 1.1;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <div class="logo">
            @if (isset($logoSrc) && $logoSrc)
                <img src="{{ $logoSrc }}" alt="RORO MUA Logo">
            @endif
        </div>
        <div class="header-center">
            <h1>FAKTUR</h1>
            <p class="header-meta">#{{ $invoice->invoice_number }}</p>
        </div>
        <div class="header-right">
            <div class="company-info">
                <p class="company-name">{{ $profile->business_name ?? 'RORO MUA' }}</p>
                @if ($profile && $profile->address)
                    @foreach (explode("\n", $profile->address) as $line)
                        <p>{{ $line }}</p>
                    @endforeach
                @else
                    <p>Perumahan Kaliwulu blok AC no.1</p>
                    <p>Kec.Plered Kab Cirebon</p>
                    <p>(Depan Lapangan)</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Info Section - Two Column -->
    <div class="info-section">
        <div class="column-left">
            <p class="info-title">DITERBITKAN KEPADA</p>
            <p class="client-name">{{ $invoice->order->client->client_name }}</p>

            <p class="info-row">
                <span class="info-label">Tanggal Akad:</span>
                <span
                    class="info-value">{{ $invoice->order->client->akad_date ? \Carbon\Carbon::parse($invoice->order->client->akad_date)->format('d F Y') : '-' }}</span>
            </p>
            <p class="info-row">
                <span class="info-label">Tanggal Resepsi:</span>
                <span
                    class="info-value">{{ $invoice->order->client->reception_date ? \Carbon\Carbon::parse($invoice->order->client->reception_date)->format('d F Y') : '-' }}</span>
            </p>
            <p class="info-row">
                <span class="info-label">Lokasi Acara:</span>
                <span class="info-value">{{ $invoice->order->client->event_location ?? '-' }}</span>
            </p>
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
                    <span class="info-label">Tanggal Terbit:</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($invoice->issue_date)->format('M d, Y') }}</span>
                </p>
                <p class="info-row" style="margin-bottom: 4px;">
                    <span class="info-label">Jatuh Tempo:</span>
                    @if ($isFullyPaid)
                        <span class="info-value-paid">Lunas</span>
                    @else
                        <span
                            class="info-value">{{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}</span>
                    @endif
                </p>
                <p class="info-row">
                    <span class="info-label">ID Pesanan:</span>
                    <span class="info-value">{{ $invoice->order->order_number }}</span>
                </p>
            </div>
        </div>
    </div>

    <!-- Items Table -->
    <table>
        <thead>
            <tr class="">
                <th>LAYANAN</th>
                <th class="text-center" style="width: 30px;">QTY</th>
                <th class="text-right" style="width: 80px;">HARGA</th>
                <th class="text-right" style="width: 80px;">TOTAL</th>
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
                            <td class="text-right" style="">Rp
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
            <!-- Jumlah Total -->
            <div class="summary-row total">
                <div class="summary-label">Jumlah Total</div>
                <div class="summary-value">Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</div>
            </div>

            <!-- DP Container -->
            @if (count($paymentHistory) > 0)
                <div class="dp-container">
                    @foreach ($paymentHistory as $index => $payment)
                        <div class="dp-item">
                            <div class="dp-label">{{ $payment['dp_number'] ?? 'DP ' . ($index + 1) }}</div>
                            <div class="dp-value">Rp {{ number_format($payment['amount'] ?? 0, 0, ',', '.') }}</div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Sisa Tagihan -->
            <div class="summary-row remaining">
                <div class="summary-label">Sisa Tagihan</div>
                <div class="summary-value">Rp {{ number_format($invoice->total_amount - $totalPaid, 0, ',', '.') }}
                </div>
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
            <p style=""><strong>Invoice untuk:</strong> Pembayaran
                {{ $lastPayment['dp_number'] ?? 'N/A' }} -
                {{ $invoice->order->order_number }}</p>
            <p style="font-style: italic;">Terima kasih telah memilih ROROO MUA untuk hari istimewa
                Anda! Kami sangat menghargai kepercayaan
                Anda.</p>
        </div>
    @endif
    <!-- Bank Info & Contact (Centered Two Columns) -->
    <div class="bank-center">
        <div class="bank-center-title">Informasi Rekening Bank</div>
        <div class="bank-flex">
            @if ($profile && $profile->banks && count($profile->banks) > 0)
                @foreach ($profile->banks as $bank)
                    <div class="bank-flex-item">
                        <div class="bank-flex-name">{{ $bank['bank_name'] }}</div>
                        <div>{{ $bank['account_number'] }}</div>
                        <div class="bank-flex-holder">a/n {{ $bank['account_holder'] }}</div>
                    </div>
                @endforeach
            @else
                <div class="bank-flex-item">
                    <div class="bank-flex-name">Bank BCA</div>
                    <div>774-559-3402</div>
                    <div class="bank-flex-holder">a/n FATIMATUZ ZAHRO</div>
                </div>
                <div class="bank-flex-item">
                    <div class="bank-flex-name">BRI</div>
                    <div>0601-01000-547-563</div>
                    <div class="bank-flex-holder">a/n FATIMATUZ ZAHRO</div>
                </div>
            @endif
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d F Y, H:i') }} WIB</p>
        <p style="margin-top: 5px;">© {{ date('Y') }} {{ $profile->business_name ?? 'ROROO MUA' }} - Wedding
            Services</p>
    </div>
</body>

</html>
