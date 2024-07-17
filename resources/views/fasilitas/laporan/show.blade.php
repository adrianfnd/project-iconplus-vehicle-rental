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
                                            <td>{{ $item->suratJalan->penyewaan->nama_penyewa }}</td>
                                            <td>{{ $item->suratJalan->penyewaan->vendor->nama }}</td>
                                            <td>{{ $item->suratJalan->penyewaan->kendaraan->nama }}</td>
                                            <td>{{ $item->suratJalan->penyewaan->tanggal_mulai }}</td>
                                            <td>{{ $item->suratJalan->penyewaan->tanggal_selesai }}</td>
                                            <td>Rp
                                                {{ number_format($item->suratJalan->penyewaan->total_biaya, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('fasilitas.laporan.index') }}" class="btn btn-light">Kembali</a>
                            <button id="cetakButton" class="btn btn-primary">Cetak Laporan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        var successMessage = '{{ session('success') }}';
        var errorMessage = '{{ session('error') }}';
        if (successMessage) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: successMessage,
                showConfirmButton: false,
                timer: 2000
            });
        }

        if (errorMessage) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: errorMessage,
                showConfirmButton: false,
                timer: 2000
            });
        }

        document.getElementById('cetakButton').addEventListener('click', function() {
            Swal.fire({
                title: 'Cetak Laporan',
                text: 'Setelah mencetak laporan, pastikan untuk menyimpan PDF dengan baik karena tidak dapat dicetak ulang.',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Ya, Cetak',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `{!! route('fasilitas.laporan.cetak', [
                        'start_date' => request('start_date'),
                        'end_date' => request('end_date'),
                        'vendor_id' => request('vendor_id'),
                    ]) !!}`;
                }
            });
        });
    </script>
@endsection
