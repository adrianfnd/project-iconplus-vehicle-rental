@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Detail Pengajuan Sewa Kendaraan</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Pengajuan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail Sewa Kendaraan</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Informasi Pengajuan Sewa Kendaraan</h4>

                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <p class="form-control-static">{{ $pengajuan->nama_penyewa }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kontak</label>
                            <p class="form-control-static">{{ $pengajuan->kontak_penyewa }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kendaraan</label>
                            <p class="form-control-static">{{ $pengajuan->kendaraan->nama }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Mulai</label>
                            <p class="form-control-static">{{ $pengajuan->tanggal_mulai }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Selesai</label>
                            <p class="form-control-static">{{ $pengajuan->tanggal_selesai }}</p>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('admin.sewa-kendaraan.index') }}" class="btn btn-light">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
