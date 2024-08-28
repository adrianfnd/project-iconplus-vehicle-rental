@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> Detail Pengajuan Sewa Kendaraan </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Forms</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail Pengajuan Sewa Kendaraan</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Detail Pengajuan Sewa Kendaraan</h4>
                        <p class="card-description">Informasi lengkap tentang pengajuan sewa kendaraan.</p>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <p class="form-control">{{ $pengajuan->nama_penyewa }}</p>
                        </div>
                        <div class="form-group">
                            <label for="kontak">Kontak</label>
                            <p class="form-control">{{ $pengajuan->kontak_penyewa }}</p>
                        </div>
                        <div class="form-group">
                            <label for="jabatan">Jabatan</label>
                            <p class="form-control">{{ $pengajuan->jabatan->nama_jabatan }}</p>
                        </div>
                        <div class="form-group">
                            <label for="kendaraan">Kendaraan</label>
                            <p class="form-control">{{ $pengajuan->kendaraan->nama }}</p>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_mulai">Tanggal Mulai</label>
                            <p class="form-control">{{ $pengajuan->tanggal_mulai }}</p>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_selesai">Tanggal Selesai</label>
                            <p class="form-control">{{ $pengajuan->tanggal_selesai }}</p>
                        </div>
                        <div class="form-group">
                            <label for="jumlah_hari_sewa">Jumlah Hari Sewa</label>
                            <p class="form-control">{{ $pengajuan->jumlah_hari_sewa }} Hari</p>
                        </div>
                        <div class="form-group">
                            <label for="sewa_untuk">Sewa Untuk</label>
                            <p class="form-control">{{ $pengajuan->sewa_untuk }}</p>
                        </div>
                        <div class="form-group">
                            <label for="vendor">Vendor</label>
                            <p class="form-control">{{ $pengajuan->vendor->nama }}</p>
                        </div>
                        <div class="form-group">
                            <label for="apakah_luar_bandung">Apakah di luar Bandung?</label>
                            <div class="col-sm-9">
                                <p class="form-control">
                                    @if ($pengajuan->is_outside_bandung == 1)
                                        Ya
                                    @else
                                        Tidak
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nilai_sewa">Nilai Sewa</label>
                                    <p class="form-control">
                                        {{ 'Rp ' . number_format($pengajuan->nilai_sewa, 0, ',', '.') . ' / Hari' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="total_nilai_sewa">Total Nilai Sewa</label>
                                    <p class="form-control">
                                        {{ 'Rp ' . number_format($pengajuan->total_nilai_sewa, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="apakah_luar_bandung">Apakah pakai driver?</label>
                            <div class="col-sm-9">
                                <p class="form-control">
                                    @if ($pengajuan->include_driver == 1)
                                        Ya
                                    @else
                                        Tidak
                                    @endif
                                </p>
                            </div>
                        </div>
                        @if ($pengajuan->include_driver == 1)
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="biaya_driver">Biaya Driver</label>
                                        <p class="form-control">
                                            {{ 'Rp ' . number_format($pengajuan->biaya_driver, 0, ',', '.') . ' / Hari' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="total_biaya_driver">Total Biaya Driver</label>
                                        <p class="form-control">
                                            {{ 'Rp ' . number_format($pengajuan->total_biaya_driver, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="driver">Driver</label>
                                <p class="form-control">{{ $pengajuan->driver->nama }}</p>
                            </div>
                        @endif
                        <div class="mt-4">
                            <h5>Catatan Penting:</h5>
                            <ul>
                                <li>Nilai Sewa Di daerah Lingkup Bandung: 250.000/hari</li>
                                <li>Nilai Sewa Di daerah Luar Bandung: 275.000/hari</li>
                                <li>Nilai Sewa Driver di Lingkup Bandung: 150.000</li>
                                <li>Nilai Sewa Driver Luar Bandung: 175.000</li>
                            </ul>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('admin.sewa-kendaraan.index') }}" class="btn btn-light">Kembali</a>
                            @if ($pengajuan->status == 'Approved by Fasilitas')
                                <button type="button" class="btn btn-success" id="approveButton">Approve</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.getElementById('approveButton').addEventListener('click', function() {
            Swal.fire({
                title: 'Pilih Tanda Tangan',
                html: `
                    <select id="tandaTanganSelect" class="swal2-select">
                        <option value="">Pilih Tanda Tangan</option>
                        @foreach ($tandaTangan as $ttd)
                            <option name="tanda_tangan" value="{{ $ttd->id }}" data-image="{{ asset($ttd->image_url) }}">{{ $ttd->ttd_name }}</option>
                        @endforeach
                    </select>
                    <div id="tandaTanganPreview" style="margin-top: 10px;"></div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Approve',
                cancelButtonText: 'Batal',
                didOpen: () => {
                    const tandaTanganSelect = Swal.getPopup().querySelector('#tandaTanganSelect');
                    const tandaTanganPreview = Swal.getPopup().querySelector('#tandaTanganPreview');

                    tandaTanganSelect.addEventListener('change', function() {
                        const selectedOption = this.options[this.selectedIndex];
                        const imageUrl = selectedOption.getAttribute('data-image');

                        if (imageUrl) {
                            tandaTanganPreview.innerHTML =
                                `<img src="${imageUrl}" alt="Preview Tanda Tangan" style="max-width: 200px; max-height: 100px;">`;
                        } else {
                            tandaTanganPreview.innerHTML = '';
                        }
                    });
                },
                preConfirm: () => {
                    const tandaTanganSelect = Swal.getPopup().querySelector('#tandaTanganSelect');
                    const selectedTtd = tandaTanganSelect.value;
                    if (!selectedTtd) {
                        Swal.showValidationMessage('Silakan pilih tanda tangan');
                    }
                    return {
                        tandaTanganId: selectedTtd
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route('admin.sewa-kendaraan.approve', $pengajuan->id) }}';

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);

                    const tandaTanganInput = document.createElement('input');
                    tandaTanganInput.type = 'hidden';
                    tandaTanganInput.name = 'tanda_tangan_id';
                    tandaTanganInput.value = result.value.tandaTanganId;
                    form.appendChild(tandaTanganInput);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    </script>
@endsection
