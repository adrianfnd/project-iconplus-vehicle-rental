@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Generate Laporan</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Laporan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Generate</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Filter Laporan</h4>
                        <p class="card-description">Pilih rentang tanggal dan vendor untuk generate laporan.</p>

                        <form action="{{ route('admin.laporan.generate') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="start_date">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                            </div>
                            <div class="form-group">
                                <label for="end_date">Tanggal Akhir</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" required>
                            </div>
                            <div class="form-group">
                                <label for="vendor_id">Vendor</label>
                                <select class="form-control form-control-lg" id="vendor_id" name="vendor_id" required>
                                    <option value="all">Semua Vendor</option>
                                    @foreach ($vendors as $vendor)
                                        <option value="{{ $vendor->id }}">{{ $vendor->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Generate Laporan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
