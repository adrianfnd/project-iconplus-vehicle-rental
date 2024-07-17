<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Surat Jalan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
        }

        .header p {
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Laporan Surat Jalan</h2>
        <p>Periode: {{ $startDate->format('d/m/Y') }} - {{ $endDate->format('d/m/Y') }}</p>
        <p>Vendor: {{ $selectedVendor }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Surat Jalan</th>
                <th>Nama Penyewa</th>
                <th>Vendor</th>
                <th>Kendaraan</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Total Biaya</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($riwayatSuratJalan as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->suratJalan->penyewaan->nama_penyewa }}</td>
                    <td>{{ $item->suratJalan->penyewaan->vendor->nama }}</td>
                    <td>{{ $item->suratJalan->penyewaan->kendaraan->nama }}</td>
                    <td>{{ $item->suratJalan->penyewaan->tanggal_mulai }}</td>
                    <td>{{ $item->suratJalan->penyewaan->tanggal_selesai }}</td>
                    <td>Rp {{ number_format($item->suratJalan->penyewaan->total_biaya, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
