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
                        <form id="createForm" action="{{ route('pemeliharaan.sewa-kendaraan.store') }}" method="POST">
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
                                <label for="jabatan">Jabatan</label>
                                <select class="form-control form-control-lg" id="jabatan" name="jabatan" required>
                                    <option value="">Pilih Jabatan</option>
                                    @foreach ($jabatans as $jabatan)
                                        <option value="{{ $jabatan->id }}">{{ $jabatan->nama_jabatan }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('jabatan'))
                                    <span class="text-danger">{{ $errors->first('jabatan') }}</span>
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
                            <div class="form-group">
                                <label for="sewa_untuk">Sewa Untuk</label>
                                <select class="form-control form-control-lg" id="sewa_untuk" name="sewa_untuk" required>
                                    <option value="">Pilih Tujuan Sewa</option>
                                    <option value="Pemeliharaan">Pemeliharaan</option>
                                    <option value="Visit">Visit</option>
                                    <option value="Pengecekan">Pengecekan</option>
                                    <option value="Pendampingan">Pendampingan</option>
                                    <option value="Pemasaran">Pemasaran</option>
                                    <option value="Survey">Survey</option>
                                    <option value="Tracing Core">Tracing Core</option>
                                    <option value="Kegiatan GM">Kegiatan GM (General Manager)</option>
                                </select>
                                @if ($errors->has('sewa_untuk'))
                                    <span class="text-danger">{{ $errors->first('sewa_untuk') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="apakah_luar_bandung">Apakah di luar Bandung?</label>
                                <div class="col-sm-4">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="apakah_luar_bandung"
                                                id="luar_bandung_ya" value="1"> Ya <i class="input-helper"></i></label>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="apakah_luar_bandung"
                                                id="luar_bandung_tidak" value="0" checked> Tidak <i
                                                class="input-helper"></i></label>
                                    </div>
                                </div>
                                @if ($errors->has('luar_bandung_ya'))
                                    <span class="text-danger">{{ $errors->first('luar_bandung_ya') }}</span>
                                @endif
                            </div>
                            <a href="{{ route('pemeliharaan.sewa-kendaraan.index') }}" class="btn btn-light">Kembali</a>
                            <button type="button" class="btn btn-gradient-primary me-2"
                                onclick="confirmSubmit()">Buat</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmSubmit() {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan mengajukan sewa kendaraan ini.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, ajukan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('createForm').submit();
                }
            })
        }
    </script>
@endsection
