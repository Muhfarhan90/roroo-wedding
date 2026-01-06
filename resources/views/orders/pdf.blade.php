<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Order #{{ $order->order_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            line-height: 1.5;
            color: #333;
            padding: 20px 30px;
        }

        /* Header */
        .header {
            display: table;
            width: 100%;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 3px solid #8b7355;
        }

        .header-left {
            display: table-cell;
            width: 70px;
            vertical-align: middle;
        }

        .logo {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: 2px solid #d4b896;
            object-fit: cover;
        }

        .header-center {
            display: table-cell;
            vertical-align: middle;
            padding-left: 15px;
        }

        .header-title {
            font-size: 20px;
            font-weight: bold;
            color: #8b7355;
            margin-bottom: 3px;
        }

        .header-subtitle {
            font-size: 10px;
            color: #666;
        }

        .header-right {
            display: table-cell;
            vertical-align: middle;
            text-align: right;
        }

        .order-number {
            font-size: 13px;
            font-weight: bold;
            color: #333;
            margin-bottom: 3px;
        }

        .order-date {
            font-size: 10px;
            color: #666;
        }

        /* Section */
        .section {
            margin-bottom: 20px;
            page-break-inside: avoid;
        }

        .section-header {
            background: #f5f5f5;
            padding: 8px 12px;
            border-left: 4px solid #8b7355;
            margin-bottom: 12px;
        }

        .section-title {
            font-size: 12px;
            font-weight: bold;
            color: #8b7355;
            text-transform: uppercase;
        }

        /* Info Grid */
        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 10px;
        }

        .info-col-2 {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding: 0 8px;
        }

        .info-col-2:first-child {
            padding-left: 0;
        }

        .info-col-2:last-child {
            padding-right: 0;
        }

        .info-item {
            margin-bottom: 10px;
        }

        .info-label {
            font-size: 9px;
            font-weight: bold;
            color: #666;
            text-transform: uppercase;
            margin-bottom: 3px;
        }

        .info-value {
            font-size: 11px;
            color: #333;
            line-height: 1.4;
        }

        .info-value strong {
            color: #000;
            font-weight: bold;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }

        table thead {
            background: #8b7355;
            color: white;
        }

        table th {
            padding: 8px 10px;
            text-align: left;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }

        table td {
            padding: 8px 10px;
            border-bottom: 1px solid #e5e5e5;
            font-size: 11px;
        }

        table tbody tr:last-child td {
            border-bottom: 2px solid #8b7355;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .total-row {
            background: #f9f9f9;
            font-weight: bold;
        }

        /* Status Badge */
        .status-box {
            background: #f5f5f5;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .badge-lunas {
            background: #d4edda;
            color: #155724;
        }

        .badge-belum {
            background: #fff3cd;
            color: #856404;
        }

        /* Payment Summary */
        .payment-box {
            background: #f9f9f9;
            padding: 12px;
            border-radius: 4px;
            border: 1px solid #e5e5e5;
        }

        /* Custom Items */
        .custom-grid {
            display: table;
            width: 100%;
        }

        .custom-item {
            display: table-cell;
            width: 50%;
            padding: 8px;
            vertical-align: top;
        }

        .custom-label {
            font-size: 9px;
            font-weight: bold;
            color: #8b7355;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .custom-value {
            font-size: 11px;
            color: #333;
        }

        /* Notes */
        .notes-box {
            background: #fffbf0;
            border-left: 3px solid #f0ad4e;
            padding: 12px;
            font-size: 10px;
            color: #666;
            line-height: 1.6;
            font-style: italic;
        }

        /* Footer */
        .footer {
            margin-top: 30px;
            padding-top: 12px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 9px;
            color: #999;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <div class="header-left">
            @php
                $logoPath = public_path('logo/logo-roroo-wedding.png');
                $logoData = '';
                if (file_exists($logoPath)) {
                    $cacheKey = 'logo_base64_order_' . md5_file($logoPath);
                    $logoData = cache()->remember($cacheKey, 3600, function () use ($logoPath) {
                        return base64_encode(file_get_contents($logoPath));
                    });
                }
                $logoSrc = $logoData ? 'data:image/png;base64,' . $logoData : '';
            @endphp
            @if ($logoSrc)
                <img src="{{ $logoSrc }}" alt="Logo" class="logo">
            @endif
        </div>
        <div class="header-center">
            <div class="header-title">Detail Pesanan</div>
            <div class="header-subtitle">{{ $profile->business_name ?? 'ROROO MUA' }}</div>
        </div>
        <div class="header-right">
            <div class="order-number">Order #{{ $order->order_number }}</div>
            <div class="order-date">Tanggal: {{ $order->created_at->format('d F Y') }}</div>
        </div>
    </div>

    <!-- Section 1: Detail Klien & Acara -->
    <div class="section">
        <div class="section-header">
            <div class="section-title">Detail Klien & Acara</div>
        </div>

        <div class="info-grid">
            <div class="info-col-2">
                <div class="info-item">
                    <div class="info-label">Kontak Person</div>
                    <div class="info-value"><strong>{{ $order->client->bride_name }}</strong></div>
                </div>

                <div class="info-item">
                    <div class="info-label">HP Pengantin Wanita</div>
                    <div class="info-value">{{ $order->client->bride_phone ?? '-' }}</div>
                </div>

                <div class="info-item">
                    <div class="info-label">HP Pengantin Pria</div>
                    <div class="info-value">{{ $order->client->groom_phone ?? '-' }}</div>
                </div>

                <div class="info-item">
                    <div class="info-label">Pengantin Pria</div>
                    <div class="info-value"><strong>{{ $order->client->groom_name }}</strong></div>
                </div>

                <div class="info-item">
                    <div class="info-label">Orang Tua Pengantin Pria</div>
                    <div class="info-value">{{ $order->client->groom_parents ?? '-' }}</div>
                </div>
            </div>

            <div class="info-col-2">
                <div class="info-item">
                    <div class="info-label">Pengantin Wanita</div>
                    <div class="info-value"><strong>{{ $order->client->bride_name }}</strong></div>
                </div>

                <div class="info-item">
                    <div class="info-label">Orang Tua Pengantin Wanita</div>
                    <div class="info-value">{{ $order->client->bride_parents ?? '-' }}</div>
                </div>

                <div class="info-item">
                    <div class="info-label">Tanggal Akad</div>
                    <div class="info-value">
                        {{ $order->client->akad_date ? $order->client->akad_date->format('d F Y') : '-' }}
                        @if ($order->client->akad_time)
                            - {{ date('H:i', strtotime($order->client->akad_time)) }} s/d
                            {{ $order->client->akad_time ? date('H:i', strtotime($order->client->akad_time)) : '00:00' }}
                            WIB
                        @endif
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">Tanggal Resepsi</div>
                    <div class="info-value">
                        {{ $order->client->reception_date ? $order->client->reception_date->format('d F Y') : '-' }}
                        @if ($order->client->reception_time)
                            - {{ date('H:i', strtotime($order->client->reception_time)) }} s/d
                            {{ $order->client->reception_end_time ? date('H:i', strtotime($order->client->reception_end_time)) : '00:00' }}
                            WIB
                        @endif
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">Lokasi Acara</div>
                    <div class="info-value">{{ $order->client->event_location ?? '-' }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 2: Item Pesanan -->
    <div class="section">
        <div class="section-header">
            <div class="section-title">Item Pesanan</div>
        </div>

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
                        @if (!empty($item['name']) && $item['name'] !== 'N/A')
                            <tr>
                                <td>{{ $item['name'] }}</td>
                                <td class="text-center">{{ $item['quantity'] ?? 1 }}</td>
                                <td class="text-right">Rp {{ number_format($item['price'] ?? 0, 0, ',', '.') }}</td>
                                <td class="text-right">Rp {{ number_format($item['total'] ?? 0, 0, ',', '.') }}</td>
                            </tr>
                        @endif
                    @endforeach
                @endif

                @if (is_array($order->decorations) && count($order->decorations) > 0)
                    @foreach ($order->decorations as $key => $decoration)
                        @if (is_array($decoration) && isset($decoration['name']) && !empty($decoration['name']) && $decoration['name'] !== 'N/A')
                            <tr>
                                <td>{{ $decoration['name'] }}</td>
                                <td class="text-center">1</td>
                                <td class="text-right">Rp {{ number_format($decoration['price'] ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="text-right">Rp {{ number_format($decoration['price'] ?? 0, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @endif

                <tr class="total-row">
                    <td colspan="3" class="text-right">Total</td>
                    <td class="text-right">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Section 3: Pilihan Kustom -->
    @php
        $hasCustomOptions = false;
        $textOptions = [];
        $photoOptions = [];
        $gaunPhotos = [];

        // Field mapping for labels
        $fieldLabels = [
            'kursi_pelaminan' => 'Model Pelaminan',
            'warna_tenda' => 'Warna Tenda',
            'harga_dekorasi' => 'Harga Dekorasi',
            'type_dekorasi' => 'Tipe Dekorasi',
            'notes_dekorasi' => 'Catatan Dekorasi',
            'photo_pelaminan' => 'Foto Model Pelaminan',
            'photo_kain_tenda' => 'Foto Warna Kain Tenda',
        ];

        // Check decorations
        if (is_array($order->decorations)) {
            // Collect gaun photos
            for ($i = 1; $i <= 3; $i++) {
                if (isset($order->decorations["foto_gaun_{$i}"]) && !empty($order->decorations["foto_gaun_{$i}"])) {
                    $photoPath = storage_path('app/public/' . $order->decorations["foto_gaun_{$i}"]);
                    if (file_exists($photoPath)) {
                        $cacheKey = 'decoration_gaun_' . $i . '_' . md5_file($photoPath);
                        $photoData = cache()->remember($cacheKey, 3600, function () use ($photoPath) {
                            return base64_encode(file_get_contents($photoPath));
                        });
                        $gaunPhotos[] =
                            'data:image/' . pathinfo($photoPath, PATHINFO_EXTENSION) . ';base64,' . $photoData;
                    }
                }
            }

            foreach ($order->decorations as $key => $value) {
                // Skip empty values
                if (empty($value)) {
                    continue;
                }

                // Skip individual gaun photos (handled separately above)
                if (str_contains($key, 'foto_gaun_')) {
                    continue;
                }

                // For photo fields, encode to base64
                if (str_contains($key, 'photo_') || str_contains($key, 'foto_')) {
                    $photoPath = storage_path('app/public/' . $value);
                    if (file_exists($photoPath)) {
                        $cacheKey = 'decoration_' . $key . '_' . md5_file($photoPath);
                        $photoData = cache()->remember($cacheKey, 3600, function () use ($photoPath) {
                            return base64_encode(file_get_contents($photoPath));
                        });
                        $label =
                            $fieldLabels[$key] ??
                            ucwords(str_replace(['_', 'photo', 'foto'], [' ', 'Foto', 'Foto'], $key));
                        $photoOptions[$label] =
                            'data:image/' . pathinfo($photoPath, PATHINFO_EXTENSION) . ';base64,' . $photoData;
                        $hasCustomOptions = true;
                    }
                }
                // For text fields, show the value
                elseif (is_string($value)) {
                    $label = $fieldLabels[$key] ?? ucwords(str_replace('_', ' ', $key));
                    $textOptions[$label] = $value;
                    $hasCustomOptions = true;
                }
            }
        }

        if (count($gaunPhotos) > 0) {
            $hasCustomOptions = true;
        }
    @endphp

    @if ($hasCustomOptions)
        <div class="section">
            <div class="section-header">
                <div class="section-title">Pilihan Kustom</div>
            </div>

            <!-- Text Options -->
            @if (count($textOptions) > 0)
                <div class="custom-grid" style="margin-bottom: 15px;">
                    @php
                        $optionsArray = array_chunk($textOptions, ceil(count($textOptions) / 2), true);
                    @endphp
                    @foreach ($optionsArray as $columnOptions)
                        <div style="display: table-cell; width: 50%; padding: 0 8px; vertical-align: top;">
                            @foreach ($columnOptions as $label => $value)
                                <div style="margin-bottom: 10px;">
                                    <div class="custom-label">{{ $label }}</div>
                                    <div class="custom-value">{{ $value }}</div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Photo Options -->
            @if (count($photoOptions) > 0)
                @foreach ($photoOptions as $label => $photoSrc)
                    <div style="margin-bottom: 15px; page-break-inside: avoid;">
                        <div class="custom-label" style="margin-bottom: 5px;">{{ $label }}</div>
                        <div style="text-align: center; background: #f5f5f5; padding: 10px; border-radius: 4px;">
                            <img src="{{ $photoSrc }}" alt="{{ $label }}"
                                style="max-width: 100%; max-height: 200px; border-radius: 4px; object-fit: contain;">
                        </div>
                    </div>
                @endforeach
            @endif

            <!-- Gaun Photos -->
            @if (count($gaunPhotos) > 0)
                <div style="margin-bottom: 15px; page-break-inside: avoid;">
                    <div class="custom-label" style="margin-bottom: 5px;">Foto Gaun</div>
                    <div style="display: table; width: 100%; table-layout: fixed;">
                        @foreach ($gaunPhotos as $gaunPhoto)
                            <div
                                style="display: table-cell; width: {{ 100 / count($gaunPhotos) }}%; padding: 5px; vertical-align: top;">
                                <div style="background: #f5f5f5; padding: 5px; border-radius: 4px; text-align: center;">
                                    <img src="{{ $gaunPhoto }}" alt="Gaun"
                                        style="max-width: 100%; height: 120px; border-radius: 4px; object-fit: cover;">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    @endif

    <!-- Section 4: Status Pembayaran -->
    <div class="section">
        <div class="section-header">
            <div class="section-title">Status Pembayaran</div>
        </div>

        <div class="status-box">
            <div class="info-label" style="margin-bottom: 5px;">STATUS</div>
            <span class="status-badge {{ $order->payment_status == 'Lunas' ? 'badge-lunas' : 'badge-belum' }}">
                {{ $order->payment_status == 'Lunas' ? 'LUNAS' : 'BELUM LUNAS' }}
            </span>
        </div>

        <div class="payment-box" style="margin-bottom: 12px;">
            <div class="info-label" style="margin-bottom: 5px;">SISA PEMBAYARAN</div>
            <div style="font-size: 16px; font-weight: bold; color: #8b7355;">
                Rp {{ number_format($order->remaining_amount, 0, ',', '.') }}
            </div>
        </div>

        @if (is_array($order->payment_history) && count($order->payment_history) > 0)
            <div class="info-label" style="margin-bottom: 8px;">RIWAYAT PEMBAYARAN</div>
            <table>
                <thead>
                    <tr>
                        <th style="width: 25%">PEMBAYARAN</th>
                        <th class="text-center" style="width: 25%">TANGGAL</th>
                        <th class="text-right" style="width: 30%">JUMLAH</th>
                        <th class="text-center" style="width: 20%">METODE</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->payment_history as $payment)
                        <tr>
                            <td>{{ $payment['dp_number'] ?? 'DP' }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($payment['paid_at'])->format('d M Y') }}
                            </td>
                            <td class="text-right">Rp {{ number_format($payment['amount'] ?? 0, 0, ',', '.') }}</td>
                            <td class="text-center">{{ $payment['payment_method'] ?? 'Transfer' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- Section 5: Catatan Khusus (Optional) -->
    @if ($order->notes)
        <div class="section">
            <div class="section-header">
                <div class="section-title">Catatan Khusus</div>
            </div>
            <div class="notes-box">
                {{ $order->notes }}
            </div>
        </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>Dokumen ini dibuat secara otomatis pada {{ now()->format('d F Y, H:i') }} WIB</p>
        <p style="margin-top: 5px;">about:<strong
                style="color: #8b7355;">{{ $profile->business_name ?? 'ROROO MUA' }}</strong></p>
    </div>
</body>

</html>
