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
                                                @if ($item->penyewaan->status == 'Pengajuan')
                                                    <span class="badge badge-success">Pengajuan</span>
                                                @elseif ($item->penyewaan->status == 'Approved by Fasilitas')
                                                    <span class="badge badge-success">Approved by Fasilitas</span>
                                                @elseif ($item->penyewaan->status == 'Rejected by Fasilitas')
                                                    <span class="badge badge-danger">Rejected by Fasilitas</span>
                                                @elseif ($item->penyewaan->status == 'Approved by Administrasi')
                                                    <span class="badge badge-success">Approved by Administrasi</span>
                                                @elseif ($item->penyewaan->status == 'Approved by Vendor')
                                                    <span class="badge badge-success">Approved by Vendor</span>
                                                @elseif ($item->penyewaan->status == 'Rejected by Vendor')
                                                    <span class="badge badge-danger">Rejected by Vendor</span>
                                                @elseif ($item->penyewaan->status == 'Surat Jalan')
                                                    <span class="badge badge-info">Surat Jalan</span>
                                                @else
                                                    <span class="badge badge-warning">Status tidak diketahui</span>
                                                @endif
                                            </center>
                                        </td>
                                        <td>
                                            <center>
                                                <a href="{{ route('admin.surat-jalan.show', $item->id) }}"
                                                    class="btn btn-sm btn-primary">Lihat</a>
                                            </center>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
