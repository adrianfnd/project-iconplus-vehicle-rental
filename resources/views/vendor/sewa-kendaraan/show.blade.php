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
                            <h5>Catatan:</h5>
                            <ul>
                                <li>Nilai Sewa Di daerah Lingkup Bandung: 250.000/hari</li>
                                <li>Nilai Sewa Di daerah Luar Bandung: 275.000/hari</li>
                                <li>Nilai Sewa Driver di Lingkup Bandung: 150.000</li>
                                <li>Nilai Sewa Driver Luar Bandung: 175.000</li>
                            </ul>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('vendor.sewa-kendaraan.index') }}" class="btn btn-light">Kembali</a>
                            @if ($pengajuan->status == 'Approved by Administrasi')
                                <button type="button" class="btn btn-danger" id="rejectButton">Reject</button>
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
        document.getElementById('rejectButton').addEventListener('click', function() {
            Swal.fire({
                title: 'Reject Pengajuan',
                input: 'textarea',
                inputLabel: 'Notes',
                inputPlaceholder: 'Masukan catatan disini...',
                inputAttributes: {
                    'aria-label': 'Masukan catatan disini'
                },
                showCancelButton: true,
                confirmButtonText: 'Reject',
                cancelButtonText: 'Close',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Tolong masukkan catatan!'
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const notes = result.value;
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route('vendor.sewa-kendaraan.decline', $pengajuan->id) }}';

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);

                    const notesInput = document.createElement('input');
                    notesInput.type = 'hidden';
                    notesInput.name = 'reject_notes';
                    notesInput.value = notes;
                    form.appendChild(notesInput);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });

        document.getElementById('approveButton').addEventListener('click', function() {
            Swal.fire({
                title: 'Approve Pengajuan',
                text: 'Apakah Anda yakin ingin menyetujui pengajuan ini?',
                showCancelButton: true,
                confirmButtonText: 'Approve',
                cancelButtonText: 'Close',
                preConfirm: () => {
                    return true;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route('vendor.sewa-kendaraan.approve', $pengajuan->id) }}';

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    </script>
@endsection
