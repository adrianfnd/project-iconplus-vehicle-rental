@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> Buat Pengajuan Sewa Kendaraan </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Forms</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Buat Pengajuan Sewa Kendaraan</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Buat Pengajuan Sewa Kendaraan</h4>
                        <p class="card-description"> Buat Pengajuan Sewa Kendaraan </p>
                        <form action="{{ route('pemeliharaan.sewa-kendaraan.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                                @if ($errors->has('nama'))
                                    <span class="text-danger">{{ $errors->first('nama') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat" required></textarea>
                                @if ($errors->has('alamat'))
                                    <span class="text-danger">{{ $errors->first('alamat') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="kontak">Kontak</label>
                                <input type="text" class="form-control" id="kontak" name="kontak" required>
                                @if ($errors->has('kontak'))
                                    <span class="text-danger">{{ $errors->first('kontak') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="tanggal_mulai">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
                                @if ($errors->has('tanggal_mulai'))
                                    <span class="text-danger">{{ $errors->first('tanggal_mulai') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="tanggal_selesai">Tanggal Selesai</label>
                                <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai"
                                    required>
                                @if ($errors->has('tanggal_selesai'))
                                    <span class="text-danger">{{ $errors->first('tanggal_selesai') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="id_kendaraan">ID Kendaraan</label>
                                <select class="form-control" id="id_kendaraan" name="id_kendaraan" required>
                                    <option value="">Pilih Kendaraan</option>
                                    @foreach ($kendaraans as $kendaraan)
                                        <option value="{{ $kendaraan->id }}">{{ $kendaraan->nama }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('id_kendaraan'))
                                    <span class="text-danger">{{ $errors->first('id_kendaraan') }}</span>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                            <button class="btn btn-light">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
