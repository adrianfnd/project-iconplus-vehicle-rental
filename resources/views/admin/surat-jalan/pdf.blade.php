<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Jalan Rental Mobil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 10px;
            flex: 1;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
            border-bottom: 1px solid #333;
            padding-bottom: 5px;
        }

        .logo {
            max-width: 100px;
            margin-bottom: 10px;
        }

        h1 {
            color: #0066cc;
            margin: 0;
            font-size: 1.5em;
        }

        .info-section {
            margin-bottom: 10px;
        }

        .info-section h2 {
            color: #0066cc;
            border-bottom: 1px solid #0066cc;
            padding-bottom: 5px;
            font-size: 1.2em;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 5px;
            text-align: left;
            font-size: 0.9em;
        }

        th {
            background-color: #f2f2f2;
        }

        .footer {
            text-align: center;
            font-size: 0.8em;
            color: #666;
            padding: 10px 0;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .container {
                padding: 0;
            }

            .header,
            .footer {
                page-break-inside: avoid;
            }

            .info-section {
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            {{-- <img src="{{ asset('assets/images/logo.png') }}" alt="Logo Perusahaan" class="logo"> --}}
            <h1>SURAT JALAN RENTAL MOBIL</h1>
        </div>

        <div class="info-section">
            <h2>Informasi Penyewaan</h2>
            <table>
                <tr>
                    <th>Nomor Surat Jalan</th>
                    <td>{{ $suratJalan->id }}</td>
                </tr>
                <tr>
                    <th>Tanggal Terbit</th>
                    <td>{{ $suratJalan->created_at->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <th>Nama Penyewa</th>
                    <td>{{ $penyewaan->nama_penyewa }}</td>
                </tr>
                <tr>
                    <th>Kontak Penyewa</th>
                    <td>{{ $penyewaan->kontak_penyewa }}</td>
                </tr>
            </table>
        </div>

        <div class="info-section">
            <h2>Detail Kendaraan</h2>
            <table>
                <tr>
                    <th>Nama Kendaraan</th>
                    <td>{{ $penyewaan->kendaraan->nama }}</td>
                </tr>
                <tr>
                    <th>Nomor Plat</th>
                    <td>{{ $penyewaan->kendaraan->nomor_plat }}</td>
                </tr>
                <tr>
                    <th>Tanggal Mulai</th>
                    <td>{{ $penyewaan->tanggal_mulai }}</td>
                </tr>
                <tr>
                    <th>Tanggal Selesai</th>
                    <td>{{ $penyewaan->tanggal_selesai }}</td>
                </tr>
                <tr>
                    <th>Jumlah Hari</th>
                    <td>{{ $penyewaan->jumlah_hari_sewa }}</td>
                </tr>
            </table>
        </div>

        <div class="info-section">
            <h2>Biaya</h2>
            <table>
                <tr>
                    <th>Total Nilai Sewa (Rp {{ number_format($penyewaan->nilai_sewa, 0, ',', '.') }} / Hari)</th>
                    <td>Rp {{ number_format($penyewaan->total_nilai_sewa, 0, ',', '.') }}</td>
                </tr>
                @if ($penyewaan->include_driver)
                    <tr>
                        <th>Total Biaya Driver (Rp {{ number_format($penyewaan->biaya_driver, 0, ',', '.') }} / Hari)
                        </th>
                        <td>Rp {{ number_format($penyewaan->total_biaya_driver, 0, ',', '.') }}</td>
                    </tr>
                @endif
                <tr>
                    <th>Total Biaya</th>
                    <td>Rp {{ number_format($penyewaan->total_biaya, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="footer">
        <p>Terima kasih telah menggunakan jasa rental mobil kami.</p>
        <p>Untuk pertanyaan atau bantuan, silahkan datang ke kantor kami</p>
    </div>
</body>

</html>
