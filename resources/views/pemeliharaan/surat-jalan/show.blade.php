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
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title">Surat Jalan</h4>
                            <div>
                                <a href="{{ url($suratJalan->link_pdf) }}" class="btn btn-primary btn-sm" download>
                                    <i class="mdi mdi-download"></i> Download
                                </a>
                                <button onclick="printPDF()" class="btn btn-info btn-sm">
                                    <i class="mdi mdi-printer"></i> Print
                                </button>
                            </div>
                        </div>
                        <div class="pdf-container">
                            <iframe src="{{ url($suratJalan->link_pdf) }}" width="100%" height="600px"></iframe>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('pemeliharaan.surat-jalan.index') }}" class="btn btn-light">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function printPDF() {
            const iframe = document.querySelector('iframe');
            iframe.contentWindow.print();
        }
    </script>
@endsection
