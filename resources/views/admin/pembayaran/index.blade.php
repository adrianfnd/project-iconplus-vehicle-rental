@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> Pengajuan Surat Jalan </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Tables</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pengajuan Surat Jalan</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Daftar Pengajuan Surat Jalan</h4>
                        <p class="card-description">Berikut adalah daftar pengajuan surat jalan yang telah diajukan.</p>

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Kontak</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Jumlah Hari</th>
                                        <th>Nama Kendaraan</th>
                                        <th>
                                            <center>Status</center>
                                        </th>
                                        <th>
                                            <center>Aksi</center>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($suratJalan as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->penyewaan->nama_penyewa }}</td>
                                            <td>{{ $item->penyewaan->kontak_penyewa }}</td>
                                            <td>{{ $item->penyewaan->tanggal_mulai }}</td>
                                            <td>{{ $item->penyewaan->tanggal_selesai }}</td>
                                            <td>{{ $item->penyewaan->jumlah_hari_sewa }} Hari</td>
                                            <td>{{ $item->penyewaan->kendaraan->nama }}</td>
                                            <td>
                                                <center>
                                                    @if ($item->status == 'Surat Jalan')
                                                        <span class="badge badge-info">Surat Jalan</span>
                                                    @elseif ($item->status == 'Dalam Perjalanan')
                                                        <span class="badge badge-warning">Dalam Perjalanan</span>
                                                    @elseif ($item->status == 'Selesai')
                                                        <span class="badge badge-success">Selesai</span>
                                                    @elseif ($item->status == 'Rejected by ')
                                                        <span class="badge badge-danger">Rejected by </span>
                                                    @else
                                                        <span class="badge badge-warning">Status tidak diketahui</span>
                                                    @endif
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    @if ($item->status == 'Dalam Perjalanan')
                                                        <a href="{{ route('pemeliharaan.surat-jalan.detail', $item->id) }}"
                                                            class="btn btn-sm btn-success">Selesai</a>
                                                    @else
                                                        <a href="{{ route('pemeliharaan.surat-jalan.show', $item->id) }}"
                                                            class="btn btn-sm btn-primary">Lihat</a>
                                                    @endif
                                                </center>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end mt-3">
                                {{ $suratJalan->links('pagination::bootstrap-4') }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        var successMessage = '{{ session('success') }}';
        var errorMessage = '{{ session('error') }}';
        if (successMessage) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: successMessage,
                showConfirmButton: false,
                timer: 2000
            });
        }

        if (errorMessage) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: errorMessage,
                showConfirmButton: false,
                timer: 2000
            });
        }
    </script>
@endsection
