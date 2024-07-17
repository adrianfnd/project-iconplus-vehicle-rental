@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> Riwayat Penyewaan </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Riwayat</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Penyewaan</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Daftar Riwayat Penyewaan</h4>
                        <p class="card-description">Berikut adalah daftar riwayat penyewaan yang telah selesai.</p>

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Vendor</th>
                                        <th>Nama Penyewa</th>
                                        <th>Kendaraan</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Total Tagihan</th>
                                        <th>
                                            <center>Status</center>
                                        </th>
                                        <th>
                                            <center>Aksi</center>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($riwayat as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->suratJalan->penyewaan->vendor->nama }}</td>
                                            <td>{{ $item->suratJalan->penyewaan->nama_penyewa }}</td>
                                            <td>{{ $item->suratJalan->penyewaan->kendaraan->nama }}</td>
                                            <td>{{ $item->suratJalan->penyewaan->tanggal_mulai }}</td>
                                            <td>
                                                {{ $item->suratJalan->penyewaan->tanggal_selesai }}
                                                @if ($item->suratJalan->is_lebih_hari === 1)
                                                    <span class="badge bg-danger">
                                                        Lebih {{ $item->suratJalan->lebih_hari }} Hari
                                                    </span>
                                                @endif
                                            </td>

                                            <td>Rp
                                                {{ number_format($item->suratJalan->penyewaan->total_biaya, 0, ',', '.') }}
                                            </td>
                                            <td>
                                                <center>
                                                    @if ($item->suratJalan->penyewaan->status == 'Lunas')
                                                        <span class="badge badge-success">Lunas</span>
                                                    @else
                                                        <span
                                                            class="badge badge-danger">{{ $item->suratJalan->penyewaan->status }}</span>
                                                    @endif
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <a href="{{ route('fasilitas.riwayat.show', $item->id) }}"
                                                        class="btn btn-sm btn-primary">Lihat</a>
                                                </center>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end mt-3">
                                {{ $riwayat->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
