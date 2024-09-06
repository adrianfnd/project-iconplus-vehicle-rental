@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> Pengajuan Sewa Kendaraan </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Tables</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pengajuan Sewa Kendaraan</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Daftar Pengajuan Sewa Kendaraan</h4>
                        <p class="card-description">Berikut adalah daftar pengajuan sewa kendaraan yang telah diajukan.</p>

                        <div class="d-flex">
                            <div class="me-2">
                                <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search..."
                                    class="form-control form-control-sm">
                            </div>
                            <div class="select-wrapper">
                                <select id="columnSelect" onchange="searchTable()" class="form-control form-control-sm">
                                </select>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped" id="sewaTable">
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
                                    @foreach ($pengajuan as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->nama_penyewa }}</td>
                                            <td>{{ $item->kontak_penyewa }}</td>
                                            <td>{{ $item->tanggal_mulai }}</td>
                                            <td>{{ $item->tanggal_selesai }}</td>
                                            <td>{{ $item->jumlah_hari_sewa }} Hari</td>
                                            <td>{{ $item->kendaraan->nama }}</td>
                                            <td>
                                                <center>
                                                    @if ($item->status == 'Pengajuan')
                                                        <span class="badge badge-success">Pengajuan</span>
                                                    @elseif ($item->status == 'Approved by Fasilitas')
                                                        <span class="badge badge-success">Approved by Fasilitas</span>
                                                    @elseif ($item->status == 'Rejected by Fasilitas')
                                                        <span class="badge badge-danger">Rejected by Fasilitas</span>
                                                    @elseif ($item->status == 'Approved by Administrasi')
                                                        <span class="badge badge-success">Approved by Administrasi</span>
                                                    @elseif ($item->status == 'Approved by Vendor')
                                                        <span class="badge badge-success">Approved by Vendor</span>
                                                    @elseif ($item->status == 'Rejected by Vendor')
                                                        <span class="badge badge-danger">Rejected by Vendor</span>
                                                    @elseif ($item->status == 'Surat Jalan')
                                                        <span class="badge badge-info">Surat Jalan</span>
                                                    @else
                                                        <span class="badge badge-warning">Status tidak diketahui</span>
                                                    @endif
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <a href="{{ route('vendor.sewa-kendaraan.show', $item->id) }}"
                                                        class="btn btn-sm btn-primary">Lihat</a>
                                                </center>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end mt-3">
                                {{ $pengajuan->links('pagination::bootstrap-4') }}
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

        function generateColumnOptions() {
            var table = document.getElementById("sewaTable");
            var thead = table.getElementsByTagName("thead")[0];
            var th = thead.getElementsByTagName("th");

            var select = document.getElementById("columnSelect");

            select.innerHTML = "";

            var allOption = document.createElement("option");
            allOption.value = "all";
            allOption.text = "Filter";
            select.appendChild(allOption);

            for (var i = 0; i < th.length; i++) {
                var option = document.createElement("option");
                option.value = i;
                option.text = th[i].innerText;
                select.appendChild(option);
            }
        }

        function searchTable() {
            var input = document.getElementById("searchInput").value.toUpperCase();
            var table = document.getElementById("sewaTable");
            var tr = table.getElementsByTagName("tr");
            var selectedColumn = document.getElementById("columnSelect").value;

            for (var i = 1; i < tr.length; i++) {
                var visible = false;
                var td = tr[i].getElementsByTagName("td");

                if (selectedColumn === "all") {
                    for (var j = 0; j < td.length; j++) {
                        if (td[j] && td[j].innerText.toUpperCase().indexOf(input) > -1) {
                            visible = true;
                            break;
                        }
                    }
                } else {
                    var index = parseInt(selectedColumn);
                    if (td[index] && td[index].innerText.toUpperCase().indexOf(input) > -1) {
                        visible = true;
                    }
                }

                tr[i].style.display = visible ? "" : "none";
            }
        }

        document.addEventListener("DOMContentLoaded", generateColumnOptions);
    </script>
@endsection
