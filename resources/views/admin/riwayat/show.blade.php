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
                        <h4 class="card-title">Riwayat</h4>
                        <p class="card-description">Detail lengkap tentang riwayat penyewaan.</p>

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
                            <p class="form-control">{{ $riwayat->suratJalan->penyewaan->tanggal_selesai }}</p>
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
                            <label for="apakah_luar_bandung">Apakah di luar Bandung?</label>
                            <div class="col-sm-12">
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
                                    @foreach (json_decode($suratJalan->bukti_lainnya) as $bukti)
                                        <img src="{{ asset('storage/' . $bukti) }}" alt="Bukti Lainnya"
                                            style="width: 150px; height: 150px; object-fit: cover; margin: 5px;">
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if ($riwayat->suratJalan->penyewaan->keterangan)
                            <div class="form-group">
                                <label>Keterangan</label>
                                <p>{{ $suratJalan->penyewaan->keterangan }}</p>
                            </div>
                        @endif

                        @if ($riwayat->suratJalan->is_lebih_hari == 1)
                            <div class="form-group">
                                <label for="lebih_hari">Lebih Hari</label>
                                <p class="form-control">{{ $riwayat->suratJalan->lebih_hari }}</p>
                            </div>
                            <div class="form-group">
                                <label for="jumlah_denda">Jumlah Denda</label>
                                <p class="form-control">Rp
                                    {{ number_format($riwayat->suratJalan->jumlah_denda, 0, ',', '.') }}</p>
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="total_tagihan">Total Tagihan</label>
                            <p class="form-control">Rp
                                {{ number_format($riwayat->suratJalan->penyewaan->total_biaya, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="form-group">
                            <label for="status_pembayaran">Status Pembayaran</label>
                            <p class="form-control">{{ $riwayat->suratJalan->status }}</p>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_pembayaran">Tanggal Pembayaran</label>
                            <p class="form-control">{{ $pembayaran->tanggal_pembayaran ?? 'Belum dibayar' }}</p>
                        </div>

                        @if ($riwayat->suratJalan->link_pdf)
                            <div class="mt-4">
                                <h5>Surat Jalan</h5>
                                <div class="mb-3">
                                    <a href="{{ url($riwayat->suratJalan->link_pdf) }}" class="btn btn-primary btn-sm"
                                        download>
                                        <i class="mdi mdi-download"></i> Download Surat Jalan
                                    </a>
                                </div>
                            </div>
                        @endif

                        @if ($tagihan->link_pdf)
                            <div class="mt-4">
                                <h5>Invoice</h5>
                                <div class="mb-3">
                                    <a href="{{ url($tagihan->link_pdf) }}" class="btn btn-primary btn-sm" download>
                                        <i class="mdi mdi-download"></i> Download Invoice
                                    </a>
                                </div>
                            </div>
                        @endif

                        <div class="mt-4">
                            <a href="{{ route('admin.riwayat.index') }}" class="btn btn-light">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
