<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .invoice-details {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .total {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Invoice</h1>
        </div>
        <div class="invoice-details">
            <p><strong>Invoice Date:</strong> {{ now()->format('d/m/Y') }}</p>
            <p><strong>Due Date:</strong> {{ now()->addDays(1)->format('d/m/Y') }}</p>
            <p><strong>Invoice Number:</strong> INV-{{ $suratJalan->id }}</p>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Harga Sewa ({{ $pengajuan->jumlah_hari_sewa }} hari)</td>
                    <td>Rp {{ number_format($pengajuan->nilai_sewa * $pengajuan->jumlah_hari_sewa, 0, ',', '.') }}</td>
                </tr>
                @if ($pengajuan->include_driver)
                    <tr>
                        <td>Biaya Driver ({{ $pengajuan->jumlah_hari_sewa }} hari)</td>
                        <td>Rp {{ number_format($pengajuan->biaya_driver * $pengajuan->jumlah_hari_sewa, 0, ',', '.') }}
                        </td>
                    </tr>
                @endif
                <tr>
                    <td>Biaya BBM</td>
                    <td>Rp {{ number_format($pengajuan->biaya_bbm, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Biaya TOL</td>
                    <td>Rp {{ number_format($pengajuan->biaya_tol, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Biaya Parkir</td>
                    <td>Rp {{ number_format($pengajuan->biaya_parkir, 0, ',', '.') }}</td>
                </tr>
                @if ($suratJalan->is_lebih_hari)
                    <tr>
                        <td>Denda Kelebihan Hari ({{ $suratJalan->lebih_hari }} hari)</td>
                        <td>Rp {{ number_format($suratJalan->jumlah_denda, 0, ',', '.') }}</td>
                    </tr>
                @endif
                <tr class="total">
                    <td>Total Biaya</td>
                    <td>Rp {{ number_format($pengajuan->total_biaya, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
