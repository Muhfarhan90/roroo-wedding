<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Daftar Invoice - ROROO MUA</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        h1 {
            text-align: center;
            color: #d4b896;
            margin-bottom: 10px;
            font-size: 24px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            font-size: 18px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            font-size: 13px;
        }

        th {
            background-color: #d4b896;
            color: white;
            font-size: 14px;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo {
            width: 120px;
            height: auto;
            margin-bottom: 10px;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }

        .status {
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }

        .status-lunas {
            background-color: #d4edda;
            color: #155724;
        }

        .status-belum {
            background-color: #fff3cd;
            color: #856404;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ public_path('logo/logo-roroo-wedding.png') }}" alt="ROROO MUA Logo" class="logo">
        <h2>Daftar Invoice</h2>
        <p>Tanggal Cetak: {{ date('d F Y') }}</p>
        <p style="font-size: 11px; color: #999; margin-top: 10px;">© 2026 ROROO MUA - Wedding Services</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No. Invoice</th>
                <th>Klien</th>
                <th>Tanggal Terbit</th>
                <th>Total</th>
                <th>Terbayar</th>
                <th>Sisa</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoices as $index => $invoice)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $invoice->invoice_number }}</td>
                    <td>{{ $invoice->order->client->bride_name ?? '-' }} &
                        {{ $invoice->order->client->groom_name ?? '-' }}</td>
                    <td>{{ $invoice->issue_date ? \Carbon\Carbon::parse($invoice->issue_date)->format('d/m/Y') : '-' }}
                    </td>
                    <td>Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($invoice->paid_amount, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($invoice->remaining_amount, 0, ',', '.') }}</td>
                    <td>
                        <span class="status {{ $invoice->status == 'lunas' ? 'status-lunas' : 'status-belum' }}">
                            {{ ucfirst($invoice->status) }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Total Invoice: {{ $invoices->count() }}</p>
        <p>&copy; {{ date('Y') }} RORO MUA. All rights reserved.</p>
    </div>
</body>

</html>
