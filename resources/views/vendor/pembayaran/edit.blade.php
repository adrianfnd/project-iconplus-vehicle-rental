@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Edit Tagihan</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Pembayaran</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Edit Tagihan</h4>
                        <p class="card-description">
                            Edit informasi rinci mengenai tagihan untuk penyewaan kendaraan.
                        </p>
                        @if ($tagihan->reject_notes)
                            <div class="alert alert-danger" role="alert">
                                <h4 class="alert-heading">Reject Notes:</h4>
                                <p>{{ $tagihan->reject_notes }}</p>
                            </div>
                        @endif
                        <form action="{{ route('vendor.pembayaran.update', $tagihan->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mt-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Kilometer Awal</label>
                                            <input type="number" class="form-control" name="kilometer_awal"
                                                value="{{ $suratJalan->penyewaan->kilometer_awal }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Kilometer Akhir</label>
                                            <input type="number" class="form-control" name="kilometer_akhir"
                                                value="{{ $suratJalan->penyewaan->kilometer_akhir }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Bukti Biaya BBM TOL dan Parkir</label>
                                    <input type="file" name="bukti_biaya[]" class="form-control-file" multiple
                                        id="bukti_biaya_input">
                                    <div class="d-flex flex-wrap mt-2" id="bukti_biaya_container">
                                        @if ($suratJalan->bukti_biaya_bbm_tol_parkir)
                                            @foreach (json_decode($suratJalan->bukti_biaya_bbm_tol_parkir) as $bukti)
                                                <img src="{{ asset('storage/' . $bukti) }}" alt="Bukti Biaya"
                                                    style="width: 150px; height: 150px; object-fit: cover; margin: 5px;">
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Bukti Lainnya</label>
                                    <input type="file" name="bukti_lainnya[]" class="form-control-file" multiple
                                        id="bukti_lainnya_input">
                                    <div class="d-flex flex-wrap mt-2" id="bukti_lainnya_container">
                                        @if ($suratJalan->bukti_lainnya)
                                            @foreach (json_decode($suratJalan->bukti_lainnya) as $bukti)
                                                <img src="{{ asset('storage/' . $bukti) }}" alt="Bukti Lainnya"
                                                    style="width: 150px; height: 150px; object-fit: cover; margin: 5px;">
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <textarea class="form-control" name="keterangan" rows="4">{{ $suratJalan->penyewaan->keterangan }}</textarea>
                                </div>
                            </div>
                            <table class="table table-bordered mt-4">
                                <tbody>
                                    <tr>
                                        <td>Harga Sewa</td>
                                        <td>
                                            <input type="text" class="form-control" name="nilai_sewa"
                                                value="{{ number_format($suratJalan->penyewaan->nilai_sewa, 0, ',', '.') }}"
                                                placeholder="Rp">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Biaya Driver</td>
                                        <td>
                                            <input type="text" class="form-control" name="biaya_driver"
                                                value="{{ number_format($suratJalan->penyewaan->biaya_driver, 0, ',', '.') }}"
                                                placeholder="Rp">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Biaya BBM</td>
                                        <td>
                                            <input type="text" class="form-control" name="biaya_bbm"
                                                value="{{ number_format($suratJalan->penyewaan->biaya_bbm, 0, ',', '.') }}"
                                                placeholder="Rp">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Biaya TOL</td>
                                        <td>
                                            <input type="text" class="form-control" name="biaya_tol"
                                                value="{{ number_format($suratJalan->penyewaan->biaya_tol, 0, ',', '.') }}"
                                                placeholder="Rp">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Biaya Parkir</td>
                                        <td>
                                            <input type="text" class="form-control" name="biaya_parkir"
                                                value="{{ number_format($suratJalan->penyewaan->biaya_parkir, 0, ',', '.') }}"
                                                placeholder="Rp">
                                        </td>
                                    </tr>
                                    @if ($suratJalan->is_lebih_hari)
                                        <tr>
                                            <td>Denda Kelebihan Hari</td>
                                            <td>
                                                <input type="text" class="form-control" name="jumlah_denda"
                                                    value="{{ number_format($suratJalan->jumlah_denda, 0, ',', '.') }}"
                                                    placeholder="Rp">
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <div class="mt-4">
                                <a href="{{ route('vendor.pembayaran.index') }}" class="btn btn-light">Kembali</a>
                                <button type="submit" class="btn btn-success" id="createButton">Send Pengajuan
                                    Pembayaran</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function handleFileSelect(event, containerId) {
                const files = event.target.files;
                const container = document.getElementById(containerId);

                container.innerHTML = '';

                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    if (!file.type.startsWith('image/')) {
                        continue
                    }

                    const img = document.createElement('img');
                    img.classList.add('obj');
                    img.file = file;
                    img.style.width = '150px';
                    img.style.height = '150px';
                    img.style.objectFit = 'cover';
                    img.style.margin = '5px';
                    container.appendChild(img);

                    const reader = new FileReader();
                    reader.onload = (function(aImg) {
                        return function(e) {
                            aImg.src = e.target.result;
                        };
                    })(img);
                    reader.readAsDataURL(file);
                }
            }

            const bukti_biaya_input = document.getElementById('bukti_biaya_input');
            const bukti_lainnya_input = document.getElementById('bukti_lainnya_input');

            bukti_biaya_input.addEventListener('change', function(event) {
                handleFileSelect(event, 'bukti_biaya_container');
            });

            bukti_lainnya_input.addEventListener('change', function(event) {
                handleFileSelect(event, 'bukti_lainnya_container');
            });
        });
    </script>
@endsection
