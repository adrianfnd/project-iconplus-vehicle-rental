@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Dashboard Fasilitas</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Fasilitas</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-sm-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Jumlah Peminjaman per Bulan</h4>
                        <canvas id="peminjamanChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Anggaran Peminjaman per Bulan</h4>
                        <canvas id="anggaranChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Vendor Terbanyak</h4>
                        <canvas id="vendorChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-sm-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Akumulasi Pengajuan per Tahun</h4>
                        <canvas id="pengajuanChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Ketersediaan Kendaraan</h4>
                        <canvas id="ketersediaanChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-sm-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Pengajuan Menurut Jenis Kendaraan</h4>
                        <canvas id="jenisKendaraanChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Waktu Respons Pengajuan</h4>
                        <canvas id="waktuResponsChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Pengeluaran Operasional</h4>
                        <canvas id="pengeluaranChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function getMonthNames() {
            return ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        }

        function fillMissingMonths(data, totalMonths = 12) {
            const filledData = Array(totalMonths).fill(0);

            data.forEach(item => {
                filledData[item.bulan - 1] = item.jumlah || item.total;
            });

            return filledData;
        }

        const peminjamanData = fillMissingMonths({!! json_encode($peminjamanPerBulan) !!}, 9);
        const anggaranData = fillMissingMonths({!! json_encode($anggaranPerBulan) !!}, 9);

        new Chart(document.getElementById('peminjamanChart'), {
            type: 'bar',
            data: {
                labels: getMonthNames().slice(0, 12),
                datasets: [{
                    label: 'Jumlah Peminjaman',
                    data: peminjamanData,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        new Chart(document.getElementById('anggaranChart'), {
            type: 'bar',
            data: {
                labels: getMonthNames().slice(0, 12),
                datasets: [{
                    label: 'Anggaran Peminjaman',
                    data: anggaranData,
                    backgroundColor: 'rgba(255, 99, 132, 0.6)'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        new Chart(document.getElementById('vendorChart'), {
            type: 'pie',
            data: {
                labels: {!! json_encode($vendorTerbanyak->pluck('vendor.nama')) !!},
                datasets: [{
                    data: {!! json_encode($vendorTerbanyak->pluck('jumlah')) !!},
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(153, 102, 255, 0.6)'
                    ]
                }]
            },
            options: {
                responsive: true
            }
        });

        new Chart(document.getElementById('pengajuanChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($pengajuanPerTahun->pluck('tahun')) !!},
                datasets: [{
                    label: 'Approved',
                    data: {!! json_encode($pengajuanPerTahun->pluck('approved')) !!},
                    backgroundColor: 'rgba(75, 192, 192, 0.6)'
                }, {
                    label: 'Declined',
                    data: {!! json_encode($pengajuanPerTahun->pluck('declined')) !!},
                    backgroundColor: 'rgba(255, 99, 132, 0.6)'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        stacked: true,
                    },
                    y: {
                        stacked: true
                    }
                }
            }
        });

        new Chart(document.getElementById('ketersediaanChart'), {
            type: 'pie',
            data: {
                labels: ['Tersedia', 'Digunakan'],
                datasets: [{
                    data: [
                        {!! $ketersediaanKendaraan['tersedia'] !!},
                        {!! $ketersediaanKendaraan['digunakan'] !!},
                    ],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(255, 206, 86, 0.6)'
                    ]
                }]
            },
            options: {
                responsive: true
            }
        });

        new Chart(document.getElementById('jenisKendaraanChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($pengajuanPerJenisKendaraan->pluck('jenis')) !!},
                datasets: [{
                    label: 'Jumlah Pengajuan',
                    data: {!! json_encode($pengajuanPerJenisKendaraan->pluck('jumlah')) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.6)'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        function fillMissingMonthsWaktuRespons(data, totalMonths = 12) {
            const filledData = Array(totalMonths).fill(0);

            data.forEach(item => {
                if (item.bulan >= 1 && item.bulan <= totalMonths) {
                    filledData[item.bulan - 1] = item.rata_rata_waktu_respon || 0;
                }
            });

            return filledData;
        }


        const waktuResponsData = fillMissingMonthsWaktuRespons({!! json_encode($waktuResponsPengajuan->toArray()) !!}, 12);

        new Chart(document.getElementById('waktuResponsChart'), {
            type: 'line',
            data: {
                labels: getMonthNames(),
                datasets: [{
                    label: 'Waktu Respons Rata-rata (Jam)',
                    data: waktuResponsData,
                    borderColor: 'rgba(153, 102, 255, 1)',
                    fill: false
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const pengeluaranBBMData = fillMissingMonths({!! json_encode(
            $pengeluaranOperasional->map(function ($item) {
                return ['bulan' => $item->bulan, 'jumlah' => $item->bbm];
            }),
        ) !!}, 12);
        const pengeluaranTolData = fillMissingMonths({!! json_encode(
            $pengeluaranOperasional->map(function ($item) {
                return ['bulan' => $item->bulan, 'jumlah' => $item->tol];
            }),
        ) !!}, 12);
        const pengeluaranParkirData = fillMissingMonths({!! json_encode(
            $pengeluaranOperasional->map(function ($item) {
                return ['bulan' => $item->bulan, 'jumlah' => $item->parkir];
            }),
        ) !!}, 12);
        const pengeluaranDriverData = fillMissingMonths({!! json_encode(
            $pengeluaranOperasional->map(function ($item) {
                return ['bulan' => $item->bulan, 'jumlah' => $item->driver];
            }),
        ) !!}, 12);

        const monthLabels = getMonthNames().slice(0, 12);

        new Chart(document.getElementById('pengeluaranChart'), {
            type: 'bar',
            data: {
                labels: monthLabels,
                datasets: [{
                    label: 'BBM',
                    data: pengeluaranBBMData,
                    backgroundColor: 'rgba(255, 99, 132, 0.6)'
                }, {
                    label: 'Tol',
                    data: pengeluaranTolData,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)'
                }, {
                    label: 'Parkir',
                    data: pengeluaranParkirData,
                    backgroundColor: 'rgba(255, 206, 86, 0.6)'
                }, {
                    label: 'Driver',
                    data: pengeluaranDriverData,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        stacked: true,
                    },
                    y: {
                        stacked: true,
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
