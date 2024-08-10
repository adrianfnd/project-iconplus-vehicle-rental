@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Tambah Tanda Tangan</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Admin</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.tanda-tangan.index') }}">Tanda Tangan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Form Tambah Tanda Tangan</h4>
                        <form class="forms-sample" method="POST" action="{{ route('admin.tanda-tangan.store') }}"
                            enctype="multipart/form-data" id="signatureForm">
                            @csrf
                            <div class="form-group">
                                <label for="ttd_name">Nama Tanda Tangan</label>
                                <input type="text" class="form-control" id="ttd_name" name="ttd_name"
                                    placeholder="Nama Tanda Tangan" required>
                            </div>
                            <div class="form-group">
                                <label>Pilih Metode Input Tanda Tangan</label>
                                <select class="form-control" id="signatureMethod">
                                    <option value="draw">Gambar Langsung</option>
                                    <option value="upload">Upload Gambar</option>
                                </select>
                            </div>
                            <div id="signaturePadContainer" class="form-group">
                                <label>Gambar Tanda Tangan</label>
                                <div>
                                    <canvas id="signaturePad" width="400" height="200"
                                        style="border: 1px solid #000;"></canvas>
                                </div>
                                <button type="button" id="clearSignature" class="btn btn-secondary mt-2">Hapus Tanda
                                    Tangan</button>
                            </div>
                            <div id="signatureUploadContainer" class="form-group" style="display:none;">
                                <label>Upload Gambar Tanda Tangan</label>
                                <input type="file" name="image" id="imageUpload" class="file-upload-default"
                                    accept="image/*">
                                <div class="input-group col-xs-12">
                                    <input type="text" class="form-control file-upload-info" disabled
                                        placeholder="Upload Image">
                                    <span class="input-group-append">
                                        <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                                    </span>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                            <a href="{{ route('admin.tanda-tangan.index') }}" class="btn btn-light">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var canvas = document.getElementById('signaturePad');
            var signaturePad = new SignaturePad(canvas);
            var signatureMethod = document.getElementById('signatureMethod');
            var signaturePadContainer = document.getElementById('signaturePadContainer');
            var signatureUploadContainer = document.getElementById('signatureUploadContainer');
            var clearButton = document.getElementById('clearSignature');
            var signatureForm = document.getElementById('signatureForm');
            var imageUpload = document.getElementById('imageUpload');
            var uploadButton = document.querySelector('.file-upload-browse');

            signatureMethod.addEventListener('change', function() {
                if (this.value === 'draw') {
                    signaturePadContainer.style.display = 'block';
                    signatureUploadContainer.style.display = 'none';
                } else {
                    signaturePadContainer.style.display = 'none';
                    signatureUploadContainer.style.display = 'block';
                }
            });

            clearButton.addEventListener('click', function() {
                signaturePad.clear();
            });

            uploadButton.addEventListener('click', function() {
                imageUpload.click();
            });

            signatureForm.addEventListener('submit', function(e) {
                if (signatureMethod.value === 'draw') {
                    if (signaturePad.isEmpty()) {
                        e.preventDefault();
                        alert('Mohon gambar tanda tangan terlebih dahulu.');
                    } else {
                        var dataURL = signaturePad.toDataURL();
                        var blobBin = atob(dataURL.split(',')[1]);
                        var array = [];
                        for (var i = 0; i < blobBin.length; i++) {
                            array.push(blobBin.charCodeAt(i));
                        }
                        var blob = new Blob([new Uint8Array(array)], {
                            type: 'image/png'
                        });

                        var file = new File([blob], "signature.png", {
                            type: "image/png",
                            lastModified: new Date().getTime()
                        });

                        var dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);

                        imageUpload.files = dataTransfer.files;
                    }
                }
            });
        });
    </script>
@endsection
