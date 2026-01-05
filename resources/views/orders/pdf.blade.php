<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan #{{ $order->order_number }}</title>
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
            padding: 30px 40px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            width: 100px;
            height: auto;
            margin: 0 auto 10px;
        }

        .header h1 {
            font-size: 22px;
            color: #8b7355;
            margin: 0 0 5px 0;
            font-weight: bold;
        }

        .order-meta {
            text-align: center;
            font-size: 11px;
            color: #666;
            margin-top: 5px;
        }

        .divider {
            border-top: 2px solid #d4b896;
            margin: 20px 0;
        }

        .section {
            margin-bottom: 20px;
            background: white;
        }

        .section-title {
            font-size: 13px;
            font-weight: bold;
            color: #8b7355;
            border-bottom: 2px solid #d4b896;
            padding-bottom: 5px;
            margin: 20px 0 15px 0;
        }

        .info-box {
            background: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .info-row {
            margin-bottom: 8px;
            line-height: 1.5;
        }

        .info-label {
            font-size: 10px;
            text-transform: uppercase;
            color: #666;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 12px;
            color: #333;
            margin-bottom: 8px;
        }

        .info-value strong {
            font-weight: bold;
            color: #000;
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
            padding-right: 10px;
        }

        .column-right {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding-left: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table thead {
            background: #8b7355;
            color: white;
        }

        table th {
            padding: 10px 8px;
            text-align: left;
            font-weight: 600;
            font-size: 11px;
            text-transform: uppercase;
        }

        table td {
            padding: 10px 8px;
            border-bottom: 1px solid #e0e0e0;
            font-size: 12px;
            color: #333;
        }

        table tbody tr:nth-child(even) {
            background: #fafafa;
        }

        table tbody tr:last-child td {
            border-bottom: 2px solid #8b7355;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .total-row {
            background: #fafafa;
            font-weight: bold;
        }

        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-lunas {
            background: #d4edda;
            color: #155724;
        }

        .status-belum {
            background: #f8d7da;
            color: #721c24;
        }

        /* Payment Summary Box */
        .payment-summary {
            background: #f8f8f8;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 15px;
            margin: 20px 0;
        }

        .payment-summary-row {
            display: table;
            width: 100%;
            padding: 5px 0;
        }

        .payment-summary-label {
            display: table-cell;
            text-align: left;
            font-size: 11px;
            color: #666;
        }

        .payment-summary-value {
            display: table-cell;
            text-align: right;
            font-size: 11px;
            font-weight: bold;
            color: #333;
        }

        .payment-summary-row.highlight {
            border-top: 2px solid #8b7355;
            padding-top: 10px;
            margin-top: 5px;
        }

        .payment-summary-row.highlight .payment-summary-label,
        .payment-summary-row.highlight .payment-summary-value {
            font-size: 13px;
            font-weight: bold;
            color: #8b7355;
        }

        /* Notes Section */
        .notes {
            background: #fafafa;
            border-left: 3px solid #d4b896;
            padding: 15px;
            margin: 20px 0;
            font-size: 11px;
            color: #666;
            line-height: 1.6;
        }

        .notes-title {
            font-weight: bold;
            margin-bottom: 8px;
            font-size: 12px;
            color: #8b7355;
        }

        .notes-content {
            font-size: 11px;
            line-height: 1.6;
        }

        /* Image Styling */
        .decoration-image {
            width: 100%;
            max-width: 200px;
            height: auto;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            margin-top: 5px;
        }

        .decoration-grid {
            display: table;
            width: 100%;
            margin: 10px 0;
        }

        .decoration-item {
            display: table-cell;
            width: 33.33%;
            padding: 10px;
            text-align: center;
            vertical-align: top;
        }

        .decoration-label {
            font-size: 10px;
            text-transform: uppercase;
            color: #666;
            font-weight: bold;
            margin-bottom: 8px;
            display: block;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #999;
            padding-top: 15px;
            border-top: 1px solid #ddd;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ public_path('logo/logo-roroo-wedding.png') }}" alt="ROROO MUA Logo" class="logo">
        <h1>ROROO</h1>
        <div class="header-meta">Wedding Make Up</div>
    </div>

    <!-- Order Info Box -->
    <div class="info-box" style="text-align: center; margin-bottom: 20px;">
        <div style="font-size: 14px; font-weight: bold; color: #8b7355; margin-bottom: 5px;">
            DETAIL PESANAN
        </div>
        <div style="font-size: 13px; font-weight: bold; color: #333;">
            Order #{{ $order->order_number }}
        </div>
        <div style="font-size: 10px; color: #666; margin-top: 3px;">
            Tanggal: {{ $order->created_at->format('d F Y') }}
        </div>
    </div>

    <!-- Detail Klien & Acara -->
    <div class="section">
        <div class="section-title">Detail Klien & Acara</div>

        <div class="info-section">
            <div class="column-left">
                <div class="info-box">
                    <div class="info-row">
                        <span class="info-label">Order Number</span>
                        <div class="info-value"><strong>{{ $order->order_number }}</strong></div>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Tanggal Order</span>
                        <div class="info-value">{{ $order->created_at->format('d F Y') }}</div>
                    </div>
                    <div class="info-row">
                        <span class="info-label">HP Pengantin Wanita</span>
                        <div class="info-value">{{ $order->client->bride_phone ?? '-' }}</div>
                    </div>
                    <div class="info-row">
                        <span class="info-label">HP Pengantin Pria</span>
                        <div class="info-value">{{ $order->client->groom_phone ?? '-' }}</div>
                    </div>
                </div>

                <div class="info-box">
                    <div class="info-row">
                        <span class="info-label">Pengantin Wanita</span>
                        <div class="info-value"><strong>{{ $order->client->bride_name }}</strong></div>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Alamat Pengantin Wanita</span>
                        <div class="info-value">{{ $order->client->bride_address ?? '-' }}</div>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Orang Tua Pengantin Wanita</span>
                        <div class="info-value">{{ $order->client->bride_parents ?? '-' }}</div>
                    </div>
                </div>
            </div>

            <div class="column-right">
                <div class="info-box">
                    <div class="info-row">
                        <span class="info-label">Pengantin Pria</span>
                        <div class="info-value"><strong>{{ $order->client->groom_name }}</strong></div>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Alamat Pengantin Pria</span>
                        <div class="info-value">{{ $order->client->groom_address ?? '-' }}</div>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Orang Tua Pengantin Pria</span>
                        <div class="info-value">{{ $order->client->groom_parents ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-box">
            <div class="info-row">
                <span class="info-label">Lokasi Acara</span>
                <div class="info-value">{{ $order->client->event_location ?? '-' }}</div>
            </div>
            <div class="info-row">
                <span class="info-label">Tanggal Akad</span>
                <div class="info-value">
                    {{ $order->client->akad_date ? $order->client->akad_date->format('d F Y') : '-' }}
                    @if ($order->client->akad_time)
                        - {{ date('H:i', strtotime($order->client->akad_time)) }} WIB
                    @endif
                </div>
            </div>
            <div class="info-row">
                <span class="info-label">Tanggal Resepsi</span>
                <div class="info-value">
                    {{ $order->client->reception_date ? $order->client->reception_date->format('d F Y') : '-' }}
                    @if ($order->client->reception_time)
                        - {{ date('H:i', strtotime($order->client->reception_time)) }}
                        @if ($order->client->reception_end_time)
                            s/d {{ date('H:i', strtotime($order->client->reception_end_time)) }}
                        @endif
                        WIB
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Item Pesanan -->
    <div class="section">
        <div class="section-title">Item Pesanan</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 50%">ITEM / PAKET</th>
                    <th class="text-center" style="width: 15%">JUMLAH</th>
                    <th class="text-right" style="width: 17%">HARGA</th>
                    <th class="text-right" style="width: 18%">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                @if (is_array($order->items) && count($order->items) > 0)
                    @foreach ($order->items as $item)
                        <tr>
                            <td>{{ $item['name'] ?? 'N/A' }}</td>
                            <td class="text-center">{{ $item['quantity'] ?? 0 }}</td>
                            <td class="text-right">Rp {{ number_format($item['price'] ?? 0, 0, ',', '.') }}</td>
                            <td class="text-right">Rp {{ number_format($item['total'] ?? 0, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    <tr class="total-row">
                        <td colspan="3" class="text-right"><strong>Total</strong></td>
                        <td class="text-right"><strong>Rp
                                {{ number_format($order->total_amount, 0, ',', '.') }}</strong></td>
                    </tr>
                @else
                    <tr>
                        <td colspan="4" class="text-center" style="padding: 20px; color: #999;">Tidak ada item</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Pilihan Kustom -->
    @if (is_array($order->decorations) && count($order->decorations) > 0)
        <div class="section">
            <div class="section-title">Pilihan Kustom</div>

            @php
                $hasImages = false;
                $textDecorations = [];
            @endphp

            <!-- Foto Model Pelaminan -->
            @if (isset($order->decorations['photo_pelaminan']) && is_string($order->decorations['photo_pelaminan']))
                @php $hasImages = true; @endphp
                <div class="info-box">
                    <span class="info-label">FOTO MODEL PELAMINAN</span>
                    <div style="text-align: center; margin-top: 10px;">
                        <img src="{{ public_path('storage/' . $order->decorations['photo_pelaminan']) }}" 
                             alt="Model Pelaminan" 
                             class="decoration-image"
                             style="max-width: 250px;">
                    </div>
                    @if(isset($order->decorations['kursi_pelaminan']))
                        <div class="info-value" style="margin-top: 10px; text-align: center;">
                            <strong>Kursi:</strong> {{ $order->decorations['kursi_pelaminan'] }}
                        </div>
                    @endif
                </div>
            @endif

            <!-- Foto Warna Kain Tenda -->
            @if (isset($order->decorations['photo_kain_tenda']) && is_string($order->decorations['photo_kain_tenda']))
                @php $hasImages = true; @endphp
                <div class="info-box">
                    <span class="info-label">FOTO WARNA KAIN TENDA</span>
                    <div style="text-align: center; margin-top: 10px;">
                        <img src="{{ public_path('storage/' . $order->decorations['photo_kain_tenda']) }}" 
                             alt="Kain Tenda" 
                             class="decoration-image"
                             style="max-width: 250px;">
                    </div>
                    @if(isset($order->decorations['warna_tenda']))
                        <div class="info-value" style="margin-top: 10px; text-align: center;">
                            <strong>Warna:</strong> {{ $order->decorations['warna_tenda'] }}
                        </div>
                    @endif
                </div>
            @endif

            <!-- Foto Gaun (3 Foto) -->
            @php
                $gaunImages = [];
                for ($i = 1; $i <= 3; $i++) {
                    if (isset($order->decorations["foto_gaun_{$i}"]) && is_string($order->decorations["foto_gaun_{$i}"])) {
                        $gaunImages[] = $order->decorations["foto_gaun_{$i}"];
                    }
                }
            @endphp

            @if (count($gaunImages) > 0)
                @php $hasImages = true; @endphp
                <div class="info-box">
                    <span class="info-label">FOTO GAUN</span>
                    <div class="decoration-grid">
                        @foreach($gaunImages as $index => $gaunImage)
                            <div class="decoration-item">
                                <img src="{{ public_path('storage/' . $gaunImage) }}" 
                                     alt="Gaun {{ $index + 1 }}" 
                                     class="decoration-image"
                                     style="max-width: 150px;">
                                <div style="font-size: 9px; color: #999; margin-top: 5px;">Gaun {{ $index + 1 }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Text Decorations (Kursi & Warna Tenda jika tidak ada foto) -->
            @php
                if (isset($order->decorations['kursi_pelaminan']) && !isset($order->decorations['photo_pelaminan'])) {
                    $textDecorations['Kursi Pelaminan'] = $order->decorations['kursi_pelaminan'];
                }
                if (isset($order->decorations['warna_tenda']) && !isset($order->decorations['photo_kain_tenda'])) {
                    $textDecorations['Warna Tenda'] = $order->decorations['warna_tenda'];
                }
            @endphp

            @if (count($textDecorations) > 0)
                <div class="info-box">
                    @foreach($textDecorations as $label => $value)
                        <div style="margin-bottom: 8px;">
                            <span class="info-label">{{ strtoupper($label) }}</span>
                            <div class="info-value">{{ $value }}</div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    <!-- Status Pembayaran -->
    <div class="section">
        <div class="section-title">Status Pembayaran</div>

        <div class="info-box" style="margin-bottom: 15px;">
            <div class="info-row">
                <span class="info-label">Status</span>
                <div class="info-value">
                    <span
                        class="status-badge {{ $order->payment_status == 'Lunas' ? 'status-lunas' : 'status-belum' }}">
                        {{ strtoupper($order->payment_status) }}
                    </span>
                </div>
            </div>
        </div>

        @if (is_array($order->payment_history) && count($order->payment_history) > 0)
            <div class="info-box" style="margin-bottom: 0;">
                <span class="info-label" style="display: block; margin-bottom: 10px;">Sisa Pembayaran</span>
                <div class="info-value" style="font-size: 13px; font-weight: bold; color: #8b7355;">
                    Rp {{ number_format($order->remaining_amount, 0, ',', '.') }}
                </div>
            </div>

            <div style="margin-top: 15px;">
                <span class="info-label" style="display: block; margin-bottom: 10px;">Riwayat Pembayaran</span>
                <table>
                    <thead>
                        <tr>
                            <th style="width: 25%">SISTEM</th>
                            <th class="text-center" style="width: 25%">TANGGAL</th>
                            <th class="text-right" style="width: 30%">JUMLAH</th>
                            <th class="text-center" style="width: 20%">METODE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->payment_history as $payment)
                            <tr>
                                <td>{{ $payment['dp_number'] ?? 'N/A' }}</td>
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($payment['paid_at'])->format('d M Y') }}</td>
                                <td class="text-right">Rp {{ number_format($payment['amount'] ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="text-center">{{ $payment['payment_method'] ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="info-box">
                <div class="info-value" style="text-align: center; color: #999;">Belum ada pembayaran</div>
            </div>
        @endif

        <div class="payment-summary">
            <div class="payment-summary-row">
                <div class="payment-summary-label">Total Pesanan:</div>
                <div class="payment-summary-value">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</div>
            </div>
            <div class="payment-summary-row">
                <div class="payment-summary-label">Total Dibayar:</div>
                <div class="payment-summary-value">
                    Rp
                    {{ number_format(array_sum(array_column($order->payment_history ?? [], 'amount')), 0, ',', '.') }}
                </div>
            </div>
            <div class="payment-summary-row highlight">
                <div class="payment-summary-label">Sisa Tagihan:</div>
                <div class="payment-summary-value">Rp {{ number_format($order->remaining_amount, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <!-- Catatan -->
    @if ($order->notes)
        <div class="notes">
            <div class="notes-title">Catatan Pesanan:</div>
            <div class="notes-content">{{ $order->notes }}</div>
        </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>Terima kasih atas kepercayaan Anda kepada ROROO Wedding Make Up</p>
        <p style="margin-top: 8px; font-size: 9px;">Dokumen ini dibuat secara otomatis pada {{ now()->format('d F Y H:i') }} WIB</p>
        <p style="margin-top: 5px; font-weight: bold; color: #8b7355;">© 2026 ROROO MUA - Wedding Services</p>
    </div>
</body>

</html>
