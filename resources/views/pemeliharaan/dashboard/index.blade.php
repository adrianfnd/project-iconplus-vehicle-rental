@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Dashboard Pemeliharaan dan Aset</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pemeliharaan dan Aset</li>
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
            <div class="col-sm-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Utilisasi Kendaraan</h4>
                        <canvas id="utilisasiChart"></canvas>
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

        new Chart(document.getElementById('utilisasiChart'), {
            type: 'line',
            data: {
                labels: {!! json_encode($utilisasiKendaraan->pluck('nama')) !!},
                datasets: [{
                    label: 'Utilisasi (%)',
                    data: {!! json_encode(
                        $utilisasiKendaraan->pluck('utilisasi')->map(function ($value) {
                            return $value * 100;
                        }),
                    ) !!},
                    borderColor: 'rgba(153, 102, 255, 1)',
                    fill: false
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
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
