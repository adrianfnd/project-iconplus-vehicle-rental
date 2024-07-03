@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> Pengajuan Sewa Kendaraan </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Forms</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pengajuan Sewa Kendaraan</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Form Pengajuan Sewa Kendaraan</h4>
                        <p class="card-description">Isilah formulir di bawah ini untuk mengajukan sewa kendaraan sesuai
                            kebutuhan Anda.</p>
                        <form action="{{ route('pemeliharaan.sewa-kendaraan.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama"
                                    value="{{ old('nama') }}" required>
                                @if ($errors->has('nama'))
                                    <span class="text-danger">{{ $errors->first('nama') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="kontak">Kontak</label>
                                <input type="text" class="form-control" id="kontak" name="kontak"
                                    value="{{ old('kontak') }}" required>
                                @if ($errors->has('kontak'))
                                    <span class="text-danger">{{ $errors->first('kontak') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="kendaraan">Kendaraan</label>
                                <select class="form-control form-control-lg" id="kendaraan" name="kendaraan"
                                    value="{{ old('kendaraan') }}" required>
                                    <option value="">Pilih Kendaraan</option>
                                    @foreach ($kendaraans as $kendaraan)
                                        <option value="{{ $kendaraan->id }}">{{ $kendaraan->nama }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('kendaraan'))
                                    <span class="text-danger">{{ $errors->first('kendaraan') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="tanggal_mulai">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai"
                                    value="{{ old('tanggal_mulai') }}" required>
                                @if ($errors->has('tanggal_mulai'))
                                    <span class="text-danger">{{ $errors->first('tanggal_mulai') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="tanggal_selesai">Tanggal Selesai</label>
                                <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai"
                                    value="{{ old('tanggal_selesai') }}" required>
                                @if ($errors->has('tanggal_selesai'))
                                    <span class="text-danger">{{ $errors->first('tanggal_selesai') }}</span>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-gradient-primary me-2">Buat</button>
                            <a href="{{ route('pemeliharaan.sewa-kendaraan.index') }}" class="btn btn-light">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
