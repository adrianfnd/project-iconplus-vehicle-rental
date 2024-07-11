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
                        <div class="mb-3 d-flex justify-content-end">
                            <a href="{{ url($suratJalan->link_pdf) }}" class="btn btn-primary btn-sm" download>
                                <i class="mdi mdi-download"></i> Download
                            </a>
                        </div>
                        <div class="pdf-container">
                            <embed src="{{ url('/vendor/surat-jalan/pdf-' . $suratJalan->id) }}" type="application/pdf"
                                width="100%" height="750px" />
                        </div>
                        @if ($suratJalan->status == 'Selesai')
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Kilometer Awal:</strong> {{ $suratJalan->penyewaan->kilometer_awal }} KM</p>
                                    <p><strong>Kilometer Akhir:</strong> {{ $suratJalan->penyewaan->kilometer_akhir }} KM
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Lebih Hari:</strong>
                                        @if ($suratJalan->lebih_hari > 0)
                                            Ya ({{ $suratJalan->lebih_hari }} hari)
                                        @else
                                            Tidak
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <h4 class="mt-4">Bukti Biaya BBM, TOL, dan Parkir</h4>
                            <div class="row">
                                @php
                                    $buktiBiayaBbmTolParkir = json_decode(
                                        $suratJalan->bukti_biaya_bbm_tol_parkir,
                                        true,
                                    );
                                @endphp
                                @if (is_array($buktiBiayaBbmTolParkir))
                                    @foreach ($buktiBiayaBbmTolParkir as $bukti)
                                        <div class="col-md-3 mb-3">
                                            <img src="{{ asset('storage/' . $bukti) }}" alt="Bukti Biaya"
                                                class="img-thumbnail">
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <h4 class="mt-4">Bukti Lainnya</h4>
                            <div class="row">
                                @php
                                    $buktiLainnya = json_decode($suratJalan->bukti_lainnya, true);
                                @endphp
                                @if (is_array($buktiLainnya))
                                    @foreach ($buktiLainnya as $bukti)
                                        <div class="col-md-3 mb-3">
                                            <img src="{{ asset('storage/' . $bukti) }}" alt="Bukti Lainnya"
                                                class="img-thumbnail">
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        @endif
                        <div class="mt-4">
                            <a href="{{ route('vendor.surat-jalan.index') }}" class="btn btn-light">Kembali</a>
                            @if ($suratJalan->status == 'Selesai')
                                <button type="button" class="btn btn-success" id="createButton">Ajukan Invoice
                                    Pembayaran</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
