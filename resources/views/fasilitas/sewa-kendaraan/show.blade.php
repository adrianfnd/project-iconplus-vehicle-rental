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
                        <div class="mt-4">
                            <h5>Catatan Penting:</h5>
                            <ul>
                                <li>Jika Pemeliharaan Max 4 hari</li>
                                <li>Jika Visit, Pengecekan, Pendampingan, Pemasaran, dan Survey Max 2 hari</li>
                                <li>Jika Tracing Core Max 6 hari</li>
                                <li>Kegiatan GM (General Manager) Max 2 hari</li>
                            </ul>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('fasilitas.sewa-kendaraan.index') }}" class="btn btn-light">Kembali</a>
                            @if ($pengajuan->status == 'Pengajuan')
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
                    form.action = '{{ route('fasilitas.sewa-kendaraan.decline', $pengajuan->id) }}';

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
                html: '<div style="text-align: left; margin-bottom: 15px;">' +
                    '<label for="vendor_id" style="display: inline-block; width: 80px; margin-left: 40px;">Vendor</label>' +
                    '<select id="vendor_id" class="swal2-select" style="width: calc(100% - 85px);">' +
                    '<option value="">Select Vendor</option>' +
                    @foreach ($vendors as $vendor)
                        '<option value="{{ $vendor->id }}">{{ $vendor->nama }}</option>' +
                    @endforeach
                '</select>' +
                '</div>' +
                '<div style="text-align: left; margin-bottom: 15px;">' +
                '<label for="include_driver" style="display: inline-block; width: 80px;"></label>' +
                '<input type="checkbox" id="include_driver" style="margin-left: -40px;" class="swal2-checkbox" value="1">' +
                '<label for="include_driver" style="margin-left: 5px;">Pakai Driver</label>' +
                '</div>' +
                '<div id="driver_selection" style="text-align: left; margin-bottom: 15px; display: none;">' +
                '<label for="driver_id" style="display: inline-block; width: 80px; margin-left: 40px;">Driver</label>' +
                '<select id="driver_id" class="swal2-select" style="width: calc(100% - 85px);">' +
                '<option value="">Select Driver</option>' +
                @foreach ($drivers as $driver)
                    '<option value="{{ $driver->id }}">{{ $driver->nama }}</option>' +
                @endforeach
                '</select>' +
                '</div>',
                showCancelButton: true,
                confirmButtonText: 'Approve',
                cancelButtonText: 'Close',
                didOpen: () => {
                    const useDriverCheckbox = Swal.getPopup().querySelector('#include_driver');
                    const driverSelection = Swal.getPopup().querySelector('#driver_selection');
                    useDriverCheckbox.addEventListener('change', function() {
                        driverSelection.style.display = this.checked ? 'block' : 'none';
                    });
                },
                preConfirm: () => {
                    const vendor = Swal.getPopup().querySelector('#vendor_id').value;
                    const useDriver = Swal.getPopup().querySelector('#include_driver').checked;
                    const driver = Swal.getPopup().querySelector('#driver_id').value;

                    if (!vendor) {
                        Swal.showValidationMessage('Tolong pilih vendor');
                        return false;
                    }
                    if (useDriver && !driver) {
                        Swal.showValidationMessage('Tolong pilih driver');
                        return false;
                    }
                    return {
                        vendor_id: vendor,
                        include_driver: useDriver,
                        driver_id: driver
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route('fasilitas.sewa-kendaraan.approve', $pengajuan->id) }}';

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);

                    const vendorInput = document.createElement('input');
                    vendorInput.type = 'hidden';
                    vendorInput.name = 'vendor_id';
                    vendorInput.value = result.value.vendor_id;
                    form.appendChild(vendorInput);

                    const useDriverInput = document.createElement('input');
                    useDriverInput.type = 'hidden';
                    useDriverInput.name = 'include_driver';
                    useDriverInput.value = result.value.include_driver;
                    form.appendChild(useDriverInput);

                    if (result.value.include_driver) {
                        const driverInput = document.createElement('input');
                        driverInput.type = 'hidden';
                        driverInput.name = 'driver_id';
                        driverInput.value = result.value.driver_id;
                        form.appendChild(driverInput);
                    }

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    </script>
@endsection
