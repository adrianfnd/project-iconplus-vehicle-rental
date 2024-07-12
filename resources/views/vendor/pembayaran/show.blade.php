@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Detail Tagihan</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Pembayaran</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Detail Tagihan</h4>
                        <p class="card-description">
                            Informasi rinci mengenai tagihan untuk penyewaan kendaraan.
                        </p>
                        <div class="mb-3 d-flex justify-content-end">
                            <a href="{{ url($tagihan->link_pdf) }}" class="btn btn-primary btn-sm" download>
                                <i class="mdi mdi-download"></i> Download Invoice
                            </a>
                        </div>
                        <div class="pdf-container">
                            <embed src="{{ route('vendor.pembayaran.pdf', $tagihan->id) }}" type="application/pdf"
                                width="100%" height="600px" />
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('vendor.pembayaran.index') }}" class="btn btn-light">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
