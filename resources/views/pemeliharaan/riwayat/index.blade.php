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
                                                    <a href="{{ route('pemeliharaan.riwayat.show', $item->id) }}"
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

    <script>
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
