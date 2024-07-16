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
                        <p class="card-description">
                            Informasi rinci mengenai Surat Jalan untuk mobil rental, termasuk detail perjalanan, pengemudi,
                            serta waktu dan tujuan penyewaan.
                        </p>
                        <div class="pdf-container">
                            <embed src="{{ route('pemeliharaan.surat-jalan.pdf', $suratJalan->id) }}" type="application/pdf"
                                width="100%" height="750px" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Data Penggunaan Kendaraan</h4>
                        <p class="card-description">
                            Isi data penggunaan kendaraan, termasuk kilometer awal dan akhir, serta unggah bukti biaya BBM,
                            tol, parkir, dan bukti lainnya. Tandai jika melebihi hari sewa.
                        </p>

                        <div class="mt-4">
                            <form action="{{ route('pemeliharaan.surat-jalan.done', $suratJalan->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="kilometer_awal">Kilometer Awal</label>
                                            <input type="number" class="form-control" id="kilometer_awal"
                                                name="kilometer_awal" value="{{ old('kilometer_awal') }}" required>
                                            @if ($errors->has('kilometer_awal'))
                                                <span class="text-danger">{{ $errors->first('kilometer_awal') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="kilometer_akhir">Kilometer Akhir</label>
                                            <input type="number" class="form-control" id="kilometer_akhir"
                                                name="kilometer_akhir" value="{{ old('kilometer_akhir') }}" required>
                                            @if ($errors->has('kilometer_akhir'))
                                                <span class="text-danger">{{ $errors->first('kilometer_akhir') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah_biaya_bbm">Jumlah Biaya BBM</label>
                                    <input type="number" class="form-control" id="jumlah_biaya_bbm" name="jumlah_biaya_bbm"
                                        value="{{ old('jumlah_biaya_bbm') }}" required>
                                    @if ($errors->has('jumlah_biaya_bbm'))
                                        <span class="text-danger">{{ $errors->first('jumlah_biaya_bbm') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="jumlah_biaya_tol">Jumlah Biaya TOL</label>
                                    <input type="number" class="form-control" id="jumlah_biaya_tol" name="jumlah_biaya_tol"
                                        value="{{ old('jumlah_biaya_tol') }}" required>
                                    @if ($errors->has('jumlah_biaya_tol'))
                                        <span class="text-danger">{{ $errors->first('jumlah_biaya_tol') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="jumlah_biaya_parkir">Jumlah Biaya Parkir</label>
                                    <input type="number" class="form-control" id="jumlah_biaya_parkir"
                                        name="jumlah_biaya_parkir" value="{{ old('jumlah_biaya_parkir') }}" required>
                                    @if ($errors->has('jumlah_biaya_parkir'))
                                        <span class="text-danger">{{ $errors->first('jumlah_biaya_parkir') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="bukti_biaya_bbm_tol_parkir">Upload Bukti Biaya BBM TOL dan Parkir</label>
                                    <input type="file" class="form-control-file" id="bukti_biaya_bbm_tol_parkir"
                                        value="{{ old('bukti_biaya_bbm_tol_parkir[]') }}"
                                        name="bukti_biaya_bbm_tol_parkir[]" accept="image/jpeg,image/png" required multiple>
                                    <br>
                                    <small class="form-text text-muted mt-1">
                                        Format file: gambar (JPG, PNG). Anda dapat mengunggah lebih dari satu gambar.
                                    </small>
                                    <div id="bukti_biaya_bbm_tol_parkir_preview" class="mt-2 d-flex flex-wrap"></div>
                                    @if ($errors->has('bukti_biaya_bbm_tol_parkir'))
                                        <span class="text-danger">{{ $errors->first('bukti_biaya_bbm_tol_parkir') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="bukti_lainnya">Upload Bukti Lainnya</label>
                                    <input type="file" class="form-control-file" id="bukti_lainnya"
                                        name="bukti_lainnya[]" accept="image/jpeg,image/png" multiple>
                                    <br>
                                    <small class="form-text text-muted mt-1">
                                        Format file: gambar (JPG, PNG). Anda dapat mengunggah lebih dari satu gambar.
                                    </small>
                                    <div id="bukti_lainnya_preview" class="mt-2 d-flex flex-wrap"></div>
                                    @if ($errors->has('bukti_lainnya'))
                                        <span class="text-danger">{{ $errors->first('bukti_lainnya') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea class="form-control" id="keterangan" name="keterangan">{{ old('keterangan') }}</textarea>
                                    @if ($errors->has('keterangan'))
                                        <span class="text-danger">{{ $errors->first('keterangan') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" value="0" id="lebihHariCheckbox"> Lebih dari hari
                                        sewa
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

            function handleFilePreview(inputElement, previewElement) {
                inputElement.addEventListener('change', function(event) {
                    previewElement.innerHTML = '';
                    const files = event.target.files;
                    for (let i = 0; i < files.length; i++) {
                        const file = files[i];
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.style.width = '150px';
                            img.style.height = '150px';
                            img.style.objectFit = 'cover';
                            img.style.margin = '5px';
                            previewElement.appendChild(img);
                        }
                        reader.readAsDataURL(file);
                    }
                });
            }

            const biayaInput = document.getElementById('bukti_biaya_bbm_tol_parkir');
            const biayaPreview = document.getElementById('bukti_biaya_bbm_tol_parkir_preview');
            handleFilePreview(biayaInput, biayaPreview);

            const bukti_lainnyaInput = document.getElementById('bukti_lainnya');
            const bukti_lainnyaPreview = document.getElementById('bukti_lainnya_preview');
            handleFilePreview(bukti_lainnyaInput, bukti_lainnyaPreview);
        });
    </script>
@endsection
