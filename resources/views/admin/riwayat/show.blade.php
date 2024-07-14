@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Detail Riwayat Penyewaan</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Riwayat</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail Penyewaan</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Informasi Penyewaan</h4>
                        <p class="card-description">Detail lengkap tentang riwayat penyewaan.</p>

                        <div class="form-group">
                            <label for="nama">Nama Penyewa</label>
                            <p class="form-control">{{ $riwayat->suratJalan->penyewaan->nama_penyewa }}</p>
                        </div>
                        <div class="form-group">
                            <label for="kontak">Kontak Penyewa</label>
                            <p class="form-control">{{ $riwayat->suratJalan->penyewaan->kontak_penyewa }}</p>
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
                            <label for="total_tagihan">Total Tagihan</label>
                            <p class="form-control">Rp
                                {{ number_format($riwayat->suratJalan->penyewaan->total_biaya, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="form-group">
                            <label for="status_pembayaran">Status Pembayaran</label>
                            <p class="form-control">{{ $riwayat->suratJalan->status }}</p>
                        </div>
                        {{-- <div class="form-group">
                            <label for="tanggal_pembayaran">Tanggal Pembayaran</label>
                            <p class="form-control">{{ $riwayat->suratJalan->tanggal_pembayaran ?? 'Belum dibayar' }}</p>
                        </div> --}}

                        @if ($riwayat->suratJalan->penyewaan->suratJalan)
                            {{-- <div class="mt-4">
                                <h5>Surat Jalan</h5>
                                <div class="mb-3">
                                    <a href="{{ route('admin.riwayat.showPdf', $riwayat->suratJalan->id) }}"
                                        class="btn btn-primary btn-sm" target="_blank">
                                        <i class="mdi mdi-file-pdf"></i> Lihat PDF Surat Jalan
                                    </a>
                                </div>
                            </div> --}}
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
