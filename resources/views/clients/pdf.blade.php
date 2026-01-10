<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Daftar Klien - ROROO MUA</title>
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
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #d4b896;
        }

        .logo {
            width: 100px;
            height: auto;
            margin-bottom: 10px;
        }

        h1 {
            font-size: 22px;
            color: #8b7355;
            margin: 10px 0 5px 0;
            font-weight: bold;
        }

        .header-meta {
            font-size: 11px;
            color: #666;
            margin-top: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table thead tr {
            background: #8b7355;
            color: white;
        }

        th {
            padding: 10px;
            text-align: left;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }

        td {
            padding: 10px;
            text-align: left;
            font-size: 11px;
            border-bottom: 1px solid #e0e0e0;
        }

        tr:nth-child(even) {
            background-color: #fafafa;
        }

        tbody tr:last-child td {
            border-bottom: 2px solid #8b7355;
        }

        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #e0e0e0;
            text-align: center;
            font-size: 10px;
            color: #999;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ public_path('logo/logo-roroo-wedding.png') }}" alt="ROROO MUA Logo" class="logo">
        <h1>DAFTAR KLIEN</h1>
        <div class="header-meta">
            Tanggal Cetak: {{ date('d F Y, H:i') }} WIB
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Mempelai</th>
                <th>Telepon Wanita</th>
                <th>Telepon Pria</th>
                <th>Tanggal Akad</th>
                <th>Tanggal Resepsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clients as $index => $client)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $client->client_name }}</td>
                    <td>{{ $client->bride_phone }}</td>
                    <td>{{ $client->groom_phone }}</td>
                    <td class="text-center">{{ $client->akad_date ? $client->akad_date->format('d/m/Y') : '-' }}</td>
                    <td class="text-center">
                        {{ $client->reception_date ? $client->reception_date->format('d/m/Y') : '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Total Klien: {{ $clients->count() }} | Dicetak pada: {{ now()->format('d F Y, H:i') }} WIB</p>
        <p style="margin-top: 5px;">© 2026 ROROO MUA - Wedding Services</p>
    </div>
</body>

</html>
