@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Detail Surat Jalan</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Surat Jalan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Surat Jalan</h4>
                        <p class="card-description">Detail Surat Jalan</p>
                        <div class="pdf-container">
                            <embed src="{{ route('pemeliharaan.surat-jalan.pdf', $suratJalan->id) }}" type="application/pdf"
                                width="100%" height="750px" />
                        </div>
                        <div class="mt-4">
                            <form action="{{ route('pemeliharaan.surat-jalan.done', $suratJalan->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="kilometer_awal">Kilometer Awal</label>
                                    <input type="number" class="form-control" id="kilometer_awal" name="kilometer_awal"
                                        value="{{ old('kilometer_awal') }}" required>
                                    @if ($errors->has('kilometer_awal'))
                                        <span class="text-danger">{{ $errors->first('kilometer_awal') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="kilometer_akhir">Kilometer Akhir</label>
                                    <input type="number" class="form-control" id="kilometer_akhir" name="kilometer_akhir"
                                        value="{{ old('kilometer_akhir') }}" required>
                                    @if ($errors->has('kilometer_akhir'))
                                        <span class="text-danger">{{ $errors->first('kilometer_akhir') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="biaya_bbm_tol_parkir">Total Biaya BBM TOL dan Parkir</label>
                                    <input type="file" class="form-control-file" id="biaya_bbm_tol_parkir"
                                        value="{{ old('biaya_bbm_tol_parkir') }}" name="biaya_bbm_tol_parkir"
                                        accept="image/*" required>
                                    @if ($errors->has('biaya_bbm_tol_parkir'))
                                        <span class="text-danger">{{ $errors->first('biaya_bbm_tol_parkir') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="foto">Upload Foto</label>
                                    <input type="file" class="form-control-file" id="foto" name="foto"
                                        accept="image/*" required>
                                    @if ($errors->has('foto'))
                                        <span class="text-danger">{{ $errors->first('foto') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" value="0" id="lebihHariCheckbox"> Lebih dari hari sewa
                                    </label>
                                    <input type="number" class="form-control mt-2" id="lebihHariInput"
                                        value ="{{ old('lebih_hari_input') }}" name="lebih_hari_input"
                                        placeholder="Jumlah hari lebih" style="display: none;">
                                    @if ($errors->has('lebih_hari_input'))
                                        <span class="text-danger">{{ $errors->first('lebih_hari_input') }}</span>
                                    @endif
                                </div>
                                <button type="submit" class="btn btn-success">Selesai</button>
                                <a href="{{ route('pemeliharaan.surat-jalan.index') }}" class="btn btn-light">Kembali</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const lebihHariCheckbox = document.querySelector('#lebihHariCheckbox');
            const lebihHariInput = document.querySelector('#lebihHariInput');

            lebihHariCheckbox.addEventListener('change', () => {
                if (lebihHariCheckbox.checked) {
                    lebihHariInput.style.display = 'block';
                } else {
                    lebihHariInput.style.display = 'none';
                }
            });
        });
    </script>
@endsection
