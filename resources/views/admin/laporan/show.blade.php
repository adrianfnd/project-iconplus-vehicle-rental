@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Laporan Riwayat Surat Jalan</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Laporan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Hasil</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Laporan Periode: {{ $startDate->format('d/m/Y') }} -
                            {{ $endDate->format('d/m/Y') }}</h4>
                        <p class="card-description">
                            Daftar riwayat surat jalan dalam periode yang dipilih.
                            <br>
                            Vendor: {{ $selectedVendor }}
                        </p>

                        <div class="table-responsive">
                            <table class="table table-striped">
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
                                            <td>{{ $item->penyewaan->nama_penyewa }}</td>
                                            <td>{{ $item->penyewaan->vendor->nama }}</td>
                                            <td>{{ $item->penyewaan->kendaraan->nama }}</td>
                                            <td>{{ $item->penyewaan->tanggal_mulai }}</td>
                                            <td>{{ $item->penyewaan->tanggal_selesai }}</td>
                                            <td>Rp {{ number_format($item->penyewaan->total_biaya, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('admin.laporan.index') }}" class="btn btn-light">Kembali</a>
                            <button onclick="window.print()" class="btn btn-primary">Cetak Laporan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
