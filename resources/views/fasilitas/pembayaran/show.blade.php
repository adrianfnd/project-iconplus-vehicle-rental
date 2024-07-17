@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Detail Pembayaran</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Pembayaran</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Detail Pembayaran</h4>
                        <p class="card-description">
                            Informasi rinci mengenai tagihan untuk penyewaan kendaraan.
                        </p>
                        <div class="mb-3 d-flex justify-content-end">
                            <a href="{{ url($tagihan->link_pdf) }}" class="btn btn-primary btn-sm" download>
                                <i class="mdi mdi-download"></i> Download Invoice
                            </a>
                        </div>
                        <div class="pdf-container">
                            <embed src="{{ route('fasilitas.pembayaran.pdf', $tagihan->id) }}" type="application/pdf"
                                width="100%" height="600px" />
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('fasilitas.pembayaran.index') }}" class="btn btn-light">Kembali</a>
                            @if ($tagihan->status == 'Approved by Administrasi')
                                <button type="button" class="btn btn-danger" id="rejectButton">Reject</button>
                                <button type="button" class="btn btn-success" id="payButton">Pay</button>
                            @endif
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

        document.getElementById('rejectButton').addEventListener('click', function() {
            Swal.fire({
                title: 'Reject Pengajuan Pembayaran',
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
                    form.action = '{{ route('fasilitas.pembayaran.decline', $tagihan->id) }}';

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

        document.getElementById('payButton').addEventListener('click', function() {
            Swal.fire({
                title: 'Pembayaran',
                text: 'Apakah Anda yakin ingin membayar pengajuan pembayaran ini?',
                showCancelButton: true,
                confirmButtonText: 'Pay',
                cancelButtonText: 'Close',
                preConfirm: () => {
                    return true;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route('fasilitas.pembayaran.approve', $tagihan->id) }}';

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
