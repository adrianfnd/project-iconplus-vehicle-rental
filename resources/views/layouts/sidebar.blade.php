<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        {{-- <li class="nav-item">
            <a class="nav-link" href="{{ route('pemeliharaan.laporan.index') }}">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li> --}}
        @if (auth()->user()->role->name == 'pemeliharaan')
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-toggle="collapse" href="#sewa" aria-expanded="false"
                    aria-controls="sewa">
                    <span class="menu-title">Sewa</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-car menu-icon"></i>
                </a>
                <div class="collapse" id="sewa">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pemeliharaan.sewa-kendaraan.index') }}">
                                Sewa Kendaraan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pemeliharaan.surat-jalan.index') }}">
                                Surat Jalan
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-toggle="collapse" href="#riwayat" aria-expanded="false"
                    aria-controls="riwayat">
                    <span class="menu-title">Riwayat</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-history menu-icon"></i>
                </a>
                <div class="collapse" id="riwayat">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pemeliharaan.riwayat.index') }}">
                                Riwayat
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-toggle="collapse" href="#laporan" aria-expanded="false"
                    aria-controls="laporan">
                    <span class="menu-title">Laporan</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-chart-bar menu-icon"></i>
                </a>
                <div class="collapse" id="laporan">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pemeliharaan.laporan.index') }}">
                                Laporan
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        @elseif(auth()->user()->role->name == 'fasilitas')
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-toggle="collapse" href="#sewa" aria-expanded="false"
                    aria-controls="sewa">
                    <span class="menu-title">Sewa</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-car menu-icon"></i>
                </a>
                <div class="collapse" id="sewa">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('fasilitas.sewa-kendaraan.index') }}">
                                Sewa Kendaraan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('fasilitas.pembayaran.index') }}">
                                Pembayaran
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-toggle="collapse" href="#riwayat" aria-expanded="false"
                    aria-controls="riwayat">
                    <span class="menu-title">Riwayat</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-history menu-icon"></i>
                </a>
                <div class="collapse" id="riwayat">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('fasilitas.riwayat.index') }}">
                                Riwayat
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-toggle="collapse" href="#laporan" aria-expanded="false"
                    aria-controls="laporan">
                    <span class="menu-title">Laporan</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-chart-bar menu-icon"></i>
                </a>
                <div class="collapse" id="laporan">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('fasilitas.laporan.index') }}">
                                Laporan
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        @elseif(auth()->user()->role->name == 'admin')
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-toggle="collapse" href="#sewa" aria-expanded="false"
                    aria-controls="sewa">
                    <span class="menu-title">Sewa</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-car menu-icon"></i>
                </a>
                <div class="collapse" id="sewa">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.sewa-kendaraan.index') }}">
                                Sewa Kendaraan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.surat-jalan.index') }}">
                                Surat Jalan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.pembayaran.index') }}">
                                Pembayaran
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-toggle="collapse" href="#riwayat" aria-expanded="false"
                    aria-controls="riwayat">
                    <span class="menu-title">Riwayat</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-history menu-icon"></i>
                </a>
                <div class="collapse" id="riwayat">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.riwayat.index') }}">
                                Riwayat
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-toggle="collapse" href="#laporan" aria-expanded="false"
                    aria-controls="laporan">
                    <span class="menu-title">Laporan</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-chart-bar menu-icon"></i>
                </a>
                <div class="collapse" id="laporan">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.laporan.index') }}">
                                Laporan
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        @elseif(auth()->user()->role->name == 'vendor')
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-toggle="collapse" href="#sewa" aria-expanded="false"
                    aria-controls="sewa">
                    <span class="menu-title">Sewa</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-car menu-icon"></i>
                </a>
                <div class="collapse" id="sewa">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('vendor.sewa-kendaraan.index') }}">
                                Sewa Kendaraan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('vendor.surat-jalan.index') }}">
                                Surat Jalan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('vendor.pembayaran.index') }}">
                                Pembayaran
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-toggle="collapse" href="#riwayat" aria-expanded="false"
                    aria-controls="riwayat">
                    <span class="menu-title">Riwayat</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-history menu-icon"></i>
                </a>
                <div class="collapse" id="riwayat">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('vendor.riwayat.index') }}">
                                Riwayat
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-toggle="collapse" href="#laporan" aria-expanded="false"
                    aria-controls="laporan">
                    <span class="menu-title">Laporan</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-chart-bar menu-icon"></i>
                </a>
                <div class="collapse" id="laporan">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('vendor.laporan.index') }}">
                                Laporan
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif
    </ul>
</nav>
