@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> Detail Pengajuan Sewa Kendaraan </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Forms</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail Pengajuan Sewa Kendaraan</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Detail Pengajuan Sewa Kendaraan</h4>
                        <p class="card-description">Informasi lengkap tentang pengajuan sewa kendaraan.</p>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <p class="form-control">{{ $pengajuan->nama_penyewa }}</p>
                        </div>
                        <div class="form-group">
                            <label for="kontak">Kontak</label>
                            <p class="form-control">{{ $pengajuan->kontak_penyewa }}</p>
                        </div>
                        <div class="form-group">
                            <label for="jabatan">Jabatan</label>
                            <p class="form-control">{{ $pengajuan->jabatan->nama_jabatan }}</p>
                        </div>
                        <div class="form-group">
                            <label for="kendaraan">Kendaraan</label>
                            <p class="form-control">{{ $pengajuan->kendaraan->nama }}</p>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_mulai">Tanggal Mulai</label>
                            <p class="form-control">{{ $pengajuan->tanggal_mulai }}</p>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_selesai">Tanggal Selesai</label>
                            <p class="form-control">{{ $pengajuan->tanggal_selesai }}</p>
                        </div>
                        <div class="form-group">
                            <label for="sewa_untuk">Sewa Untuk</label>
                            <p class="form-control">{{ $pengajuan->sewa_untuk }}</p>
                        </div>
                        <div class="form-group">
                            <label for="apakah_luar_bandung">Apakah di luar Bandung?</label>
                            <div class="col-sm-9">
                                <p class="form-control">
                                    @if ($pengajuan->is_outside_bandung == 1)
                                        Ya
                                    @else
                                        Tidak
                                    @endif
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('pemeliharaan.sewa-kendaraan.index') }}" class="btn btn-light">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
