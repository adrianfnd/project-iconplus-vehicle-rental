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
                        <div class="mb-3 d-flex justify-content-end">
                            <a href="{{ url($suratJalan->link_pdf) }}" class="btn btn-primary btn-sm" download>
                                <i class="mdi mdi-download"></i> Download
                            </a>
                        </div>
                        <div class="pdf-container">
                            <embed src="{{ url('/pemeliharaan/surat-jalan/pdf-' . $suratJalan->id) }}"
                                type="application/pdf" width="100%" height="750px" />
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('pemeliharaan.surat-jalan.index') }}" class="btn btn-light">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
