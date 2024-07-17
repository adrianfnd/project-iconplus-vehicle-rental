@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Detail Riwayat</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Riwayat</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail</li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title">Detail Pengajuan Sewa Kendaraan</h4>
                            @if ($riwayat->suratJalan->link_pdf)
                                <a href="{{ url($riwayat->suratJalan->link_pdf) }}" class="btn btn-primary btn-sm" download>
                                    <i class="mdi mdi-download"></i> Download Surat Jalan
                                </a>
                            @endif
                        </div>
                        <p class="card-description">Informasi lengkap tentang pengajuan sewa kendaraan.</p>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <p class="form-control">{{ $riwayat->suratJalan->penyewaan->nama_penyewa }}</p>
                        </div>
                        <div class="form-group">
                            <label for="kontak">Kontak</label>
                            <p class="form-control">{{ $riwayat->suratJalan->penyewaan->kontak_penyewa }}</p>
                        </div>
                        <div class="form-group">
                            <label for="jabatan">Jabatan</label>
                            <p class="form-control">{{ $riwayat->suratJalan->penyewaan->jabatan->nama_jabatan }}</p>
                        </div>
                        <div class="form-group">
                            <label for="kendaraan">Kendaraan</label>
                            <p class="form-control">{{ $riwayat->suratJalan->penyewaan->kendaraan->nama }}</p>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_mulai">Tanggal Mulai</label>
                            <p class="form-control">{{ $riwayat->suratJalan->penyewaan->tanggal_mulai }}</p>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_selesai">Tanggal Selesai</label>
                            <p class="form-control">
                                {{ $riwayat->suratJalan->penyewaan->tanggal_selesai }}
                                @if ($riwayat->suratJalan->is_lebih_hari === 1)
                                    <span class="badge bg-danger">
                                        Lebih {{ $riwayat->suratJalan->lebih_hari }} Hari
                                    </span>
                                @endif
                            </p>
                        </div>
                        <div class="form-group">
                            <label for="jumlah_hari_sewa">Jumlah Hari Sewa</label>
                            <p class="form-control">{{ $riwayat->suratJalan->penyewaan->jumlah_hari_sewa }} Hari</p>
                        </div>
                        <div class="form-group">
                            <label for="sewa_untuk">Sewa Untuk</label>
                            <p class="form-control">{{ $riwayat->suratJalan->penyewaan->sewa_untuk }}</p>
                        </div>
                        <div class="form-group">
                            <label for="vendor">Vendor</label>
                            <p class="form-control">{{ $riwayat->suratJalan->penyewaan->vendor->nama }}</p>
                        </div>
                        <div class="form-group">
                            <label for="apakah_luar_bandung">Apakah di luar Bandung?</label>
                            <div class="col-sm-9">
                                <p class="form-control">
                                    @if ($riwayat->suratJalan->penyewaan->is_outside_bandung == 1)
                                        Ya
                                    @else
                                        Tidak
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nilai_sewa">Nilai Sewa</label>
                                    <p class="form-control">
                                        {{ 'Rp ' . number_format($riwayat->suratJalan->penyewaan->nilai_sewa, 0, ',', '.') . ' / Hari' }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="total_nilai_sewa">Total Nilai Sewa</label>
                                    <p class="form-control">
                                        {{ 'Rp ' . number_format($riwayat->suratJalan->penyewaan->total_nilai_sewa, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @if ($riwayat->suratJalan->penyewaan->include_driver == 1)
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="biaya_driver">Biaya Driver</label>
                                        <p class="form-control">
                                            {{ 'Rp ' . number_format($riwayat->suratJalan->penyewaan->biaya_driver, 0, ',', '.') . ' / Hari' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="total_biaya_driver">Total Biaya Driver</label>
                                        <p class="form-control">
                                            {{ 'Rp ' . number_format($riwayat->suratJalan->penyewaan->total_biaya_driver, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="driver">Driver</label>
                                <p class="form-control">{{ $riwayat->suratJalan->penyewaan->driver->nama }}</p>
                            </div>
                        @endif
                        <div class="mt-4">
                            <h5>Catatan:</h5>
                            <ul>
                                <li>Nilai Sewa Di daerah Lingkup Bandung: 250.000/hari</li>
                                <li>Nilai Sewa Di daerah Luar Bandung: 275.000/hari</li>
                                <li>Nilai Sewa Driver di Lingkup Bandung: 150.000</li>
                                <li>Nilai Sewa Driver Luar Bandung: 175.000</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title">Detail Pembayaran</h4>
                            @if ($tagihan->link_pdf)
                                <a href="{{ url($tagihan->link_pdf) }}" class="btn btn-primary btn-sm" download>
                                    <i class="mdi mdi-download"></i> Download Invoice
                                </a>
                            @endif
                        </div>
                        <p class="card-description">
                            Informasi rinci mengenai tagihan untuk penyewaan kendaraan.
                        </p>
                        @if ($tagihan->reject_notes)
                            <div class="alert alert-danger" role="alert">
                                <h4 class="alert-heading">Reject Notes:</h4>
                                <p>{{ $tagihan->reject_notes }}</p>
                            </div>
                        @endif
                        <div class="mt-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Kilometer Awal</label>
                                        <p>{{ $riwayat->suratJalan->penyewaan->kilometer_awal ?? 'Tidak ada data' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Kilometer Akhir</label>
                                        <p>{{ $riwayat->suratJalan->penyewaan->kilometer_akhir ?? 'Tidak ada data' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Bukti Biaya BBM TOL dan Parkir</label>
                                <div class="d-flex flex-wrap">
                                    @if ($riwayat->suratJalan->bukti_biaya_bbm_tol_parkir)
                                        @foreach (json_decode($riwayat->suratJalan->bukti_biaya_bbm_tol_parkir) as $bukti)
                                            <img src="{{ asset('storage/' . $bukti) }}" alt="Bukti Biaya"
                                                style="width: 150px; height: 150px; object-fit: cover; margin: 5px;">
                                        @endforeach
                                    @else
                                        <p>Tidak ada bukti yang diunggah</p>
                                    @endif
                                </div>
                            </div>
                            @if ($riwayat->suratJalan->bukti_lainnya)
                                <div class="form-group">
                                    <label>Bukti Lainnya</label>
                                    <div class="d-flex flex-wrap">
                                        @foreach (json_decode($riwayat->suratJalan->bukti_lainnya) as $bukti)
                                            <img src="{{ asset('storage/' . $bukti) }}" alt="Bukti Lainnya"
                                                style="width: 150px; height: 150px; object-fit: cover; margin: 5px;">
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            @if ($riwayat->suratJalan->penyewaan->keterangan)
                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <p>{{ $riwayat->suratJalan->penyewaan->keterangan }}</p>
                                </div>
                            @endif
                        </div>
                        <table class="table table-bordered mt-4">
                            <tbody>
                                <tr>
                                    <td>
                                        Harga Sewa
                                        <br>
                                        <small class="text-muted">
                                            Rp {{ number_format($riwayat->suratJalan->nilai_sewa, 0, ',', '.') }} x
                                            {{ $riwayat->suratJalan->penyewaan->jumlah_hari_sewa }} hari
                                        </small>
                                    </td>
                                    <td class="text-right">
                                        Rp
                                        {{ number_format($riwayat->suratJalan->penyewaan->nilai_sewa, 0, ',', '.') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Biaya Driver
                                        <br>
                                        <small class="text-muted">
                                            Rp {{ number_format($riwayat->suratJalan->biaya_driver, 0, ',', '.') }} x
                                            {{ $riwayat->suratJalan->penyewaan->jumlah_hari_sewa }} hari
                                        </small>
                                    </td>
                                    <td class="text-right">
                                        Rp
                                        {{ number_format($riwayat->suratJalan->penyewaan->biaya_driver, 0, ',', '.') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Biaya BBM</td>
                                    <td class="text-right">
                                        Rp {{ number_format($riwayat->suratJalan->penyewaan->biaya_bbm, 0, ',', '.') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Biaya TOL</td>
                                    <td class="text-right">
                                        Rp {{ number_format($riwayat->suratJalan->penyewaan->biaya_tol, 0, ',', '.') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Biaya Parkir</td>
                                    <td class="text-right">
                                        Rp {{ number_format($riwayat->suratJalan->penyewaan->biaya_parkir, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @if ($riwayat->suratJalan->is_lebih_hari)
                                    <tr>
                                        <td>
                                            Denda Kelebihan Hari
                                            <br>
                                            <small class="text-muted">
                                                Rp {{ number_format($riwayat->suratJalan->denda, 0, ',', '.') }} x
                                                {{ $riwayat->suratJalan->lebih_hari }} hari
                                            </small>
                                        </td>
                                        <td class="text-right">
                                            Rp
                                            {{ number_format($riwayat->suratJalan->jumlah_denda, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endif
                                <tr class="font-weight-bold">
                                    <td>Total Biaya</td>
                                    <td class="text-right">
                                        Rp {{ number_format($riwayat->suratJalan->penyewaan->total_biaya, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="mt-4">
                            <a href="{{ route('fasilitas.riwayat.index') }}" class="btn btn-light">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
