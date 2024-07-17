<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Pemeliharaan\PemeliharaanSewaKendaraanController;
use App\Http\Controllers\Pemeliharaan\PemeliharaanSuratJalanController;
use App\Http\Controllers\Pemeliharaan\PemeliharaanRiwayatController;
use App\Http\Controllers\Pemeliharaan\PemeliharaanLaporanController;
use App\Http\Controllers\Fasilitas\FasilitasSewaKendaraanController;
use App\Http\Controllers\Fasilitas\FasilitasPembayaranController;
use App\Http\Controllers\Fasilitas\FasilitasRiwayatController;
use App\Http\Controllers\Fasilitas\FasilitasLaporanController;
use App\Http\Controllers\Admin\AdminSewaKendaraanController;
use App\Http\Controllers\Admin\AdminSuratJalanController;
use App\Http\Controllers\Admin\AdminPembayaranController;
use App\Http\Controllers\Admin\AdminRiwayatController;
use App\Http\Controllers\Admin\AdminLaporanController;
use App\Http\Controllers\Vendor\VendorSewaKendaraanController;
use App\Http\Controllers\Vendor\VendorSuratJalanController;
use App\Http\Controllers\Vendor\VendorPembayaranController;
use App\Http\Controllers\Vendor\VendorRiwayatController;
use App\Http\Controllers\Vendor\VendorLaporanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return view('auth.login');
});

// Auth
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.action');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

// Routes Staff Pemeliharaan dan Aset
Route::middleware(['auth', 'role:pemeliharaan'])->prefix('pemeliharaan')->group(function () {
    Route::get('sewa-kendaraan', [PemeliharaanSewaKendaraanController::class, 'index'])->name('pemeliharaan.sewa-kendaraan.index');
    Route::get('sewa-kendaraan-{id}', [PemeliharaanSewaKendaraanController::class, 'show'])->name('pemeliharaan.sewa-kendaraan.show');
    Route::get('sewa-kendaraan/create', [PemeliharaanSewaKendaraanController::class, 'create'])->name('pemeliharaan.sewa-kendaraan.create');
    Route::post('sewa-kendaraan', [PemeliharaanSewaKendaraanController::class, 'store'])->name('pemeliharaan.sewa-kendaraan.store');
    Route::put('sewa-kendaraan/{id}', [PemeliharaanSewaKendaraanController::class, 'update'])->name('pemeliharaan.sewa-kendaraan.update');

    Route::get('surat-jalan', [PemeliharaanSuratJalanController::class, 'index'])->name('pemeliharaan.surat-jalan.index');
    Route::get('surat-jalan-{id}', [PemeliharaanSuratJalanController::class, 'show'])->name('pemeliharaan.surat-jalan.show');
    Route::get('surat-jalan/pdf-{id}', [PemeliharaanSuratJalanController::class, 'showPdf'])->name('pemeliharaan.surat-jalan.pdf');
    Route::get('surat-jalan/detail-{id}', [PemeliharaanSuratJalanController::class, 'showDone'])->name('pemeliharaan.surat-jalan.detail');
    Route::post('surat-jalan/done-{id}', [PemeliharaanSuratJalanController::class, 'done'])->name('pemeliharaan.surat-jalan.done');
    
    Route::get('riwayat', [PemeliharaanRiwayatController::class, 'index'])->name('pemeliharaan.riwayat.index');
    Route::get('riwayat/{id}', [PemeliharaanRiwayatController::class, 'show'])->name('pemeliharaan.riwayat.show');
    
    Route::get('laporan', [PemeliharaanLaporanController::class, 'index'])->name('pemeliharaan.laporan.index');
    Route::post('laporan/generate', [PemeliharaanLaporanController::class, 'generate'])->name('pemeliharaan.laporan.generate');
    Route::get('laporan/cetak', [PemeliharaanLaporanController::class, 'cetak'])->name('pemeliharaan.laporan.cetak');
});

// Routes Staff Fasilitas
Route::middleware(['auth', 'role:fasilitas'])->prefix('fasilitas')->group(function () {
    Route::get('sewa-kendaraan', [FasilitasSewaKendaraanController::class, 'index'])->name('fasilitas.sewa-kendaraan.index');
    Route::get('sewa-kendaraan-{id}', [FasilitasSewaKendaraanController::class, 'show'])->name('fasilitas.sewa-kendaraan.show');
    Route::post('sewa-kendaraan-approve-{id}', [FasilitasSewaKendaraanController::class, 'approve'])->name('fasilitas.sewa-kendaraan.approve');
    Route::post('sewa-kendaraan-decline-{id}', [FasilitasSewaKendaraanController::class, 'decline'])->name('fasilitas.sewa-kendaraan.decline');
    
    Route::get('pembayaran', [FasilitasPembayaranController::class, 'index'])->name('fasilitas.pembayaran.index');
    Route::get('pembayaran-{id}', [FasilitasPembayaranController::class, 'show'])->name('fasilitas.pembayaran.show');
    Route::get('pembayaran/pdf-{id}', [FasilitasPembayaranController::class, 'showPdf'])->name('fasilitas.pembayaran.pdf');
    Route::post('pembayaran/approve-{id}', [FasilitasPembayaranController::class, 'approve'])->name('fasilitas.pembayaran.approve');
    Route::post('pembayaran/decline-{id}', [FasilitasPembayaranController::class, 'decline'])->name('fasilitas.pembayaran.decline');
    Route::get('pembayaran-success/{encrypted_id}', [FasilitasPembayaranController::class, 'success'])->name('fasilitas.pembayaran.success');
    Route::get('pembayaran-failed/{encrypted_id}', [FasilitasPembayaranController::class, 'failed'])->name('fasilitas.pembayaran.failed');

    Route::get('riwayat', [FasilitasRiwayatController::class, 'index'])->name('fasilitas.riwayat.index');
    Route::get('riwayat/{id}', [FasilitasRiwayatController::class, 'show'])->name('fasilitas.riwayat.show');

    Route::get('laporan', [FasilitasLaporanController::class, 'index'])->name('fasilitas.laporan.index');
    Route::post('laporan/generate', [FasilitasLaporanController::class, 'generate'])->name('fasilitas.laporan.generate');
    Route::get('laporan/cetak', [FasilitasLaporanController::class, 'cetak'])->name('fasilitas.laporan.cetak');
});

// Routes Staff Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('sewa-kendaraan', [AdminSewaKendaraanController::class, 'index'])->name('admin.sewa-kendaraan.index');
    Route::get('sewa-kendaraan-{id}', [AdminSewaKendaraanController::class, 'show'])->name('admin.sewa-kendaraan.show');
    Route::post('sewa-kendaraan-approve-{id}', [AdminSewaKendaraanController::class, 'approve'])->name('admin.sewa-kendaraan.approve');

    Route::get('surat-jalan', [AdminSuratJalanController::class, 'index'])->name('admin.surat-jalan.index');
    Route::get('surat-jalan-{id}', [AdminSuratJalanController::class, 'show'])->name('admin.surat-jalan.show');
    Route::post('surat-jalan-createpdf-{id}', [AdminSuratJalanController::class, 'createPDF'])->name('admin.surat-jalan.createpdf');
    
    Route::get('pembayaran', [AdminPembayaranController::class, 'index'])->name('admin.pembayaran.index');
    Route::get('pembayaran-{id}', [AdminPembayaranController::class, 'show'])->name('admin.pembayaran.show');
    Route::get('pembayaran/pdf-{id}', [AdminPembayaranController::class, 'showPdf'])->name('admin.pembayaran.pdf');
    Route::post('pembayaran/approve-{id}', [AdminPembayaranController::class, 'approve'])->name('admin.pembayaran.approve');
    Route::post('pembayaran/decline-{id}', [AdminPembayaranController::class, 'decline'])->name('admin.pembayaran.decline');

    Route::get('riwayat', [AdminRiwayatController::class, 'index'])->name('admin.riwayat.index');
    Route::get('riwayat/{id}', [AdminRiwayatController::class, 'show'])->name('admin.riwayat.show');
    
    Route::get('laporan', [AdminLaporanController::class, 'index'])->name('admin.laporan.index');
    Route::post('laporan/generate', [AdminLaporanController::class, 'generate'])->name('admin.laporan.generate');
    Route::get('laporan/cetak', [AdminLaporanController::class, 'cetak'])->name('admin.laporan.cetak');
});

// Routes Vendor Penyedia
Route::middleware(['auth', 'role:vendor'])->prefix('vendor')->group(function () {
    Route::get('sewa-kendaraan', [VendorSewaKendaraanController::class, 'index'])->name('vendor.sewa-kendaraan.index');
    Route::get('sewa-kendaraan-{id}', [VendorSewaKendaraanController::class, 'show'])->name('vendor.sewa-kendaraan.show');
    Route::post('sewa-kendaraan-approve-{id}', [VendorSewaKendaraanController::class, 'approve'])->name('vendor.sewa-kendaraan.approve');
    Route::post('sewa-kendaraan-decline-{id}', [VendorSewaKendaraanController::class, 'decline'])->name('vendor.sewa-kendaraan.decline');

    Route::get('surat-jalan', [VendorSuratJalanController::class, 'index'])->name('vendor.surat-jalan.index');
    Route::get('surat-jalan-{id}', [VendorSuratJalanController::class, 'show'])->name('vendor.surat-jalan.show');
    Route::get('surat-jalan/pdf-{id}', [VendorSuratJalanController::class, 'showPdf'])->name('vendor.surat-jalan.pdf');
    Route::get('surat-jalan/detail-{id}', [VendorSuratJalanController::class, 'showapprove'])->name('vendor.surat-jalan.detail');
    Route::post('surat-jalan/approve-{id}', [VendorSuratJalanController::class, 'approve'])->name('vendor.surat-jalan.approve');
    
    Route::get('pembayaran', [VendorPembayaranController::class, 'index'])->name('vendor.pembayaran.index');
    Route::get('pembayaran-{id}', [VendorPembayaranController::class, 'show'])->name('vendor.pembayaran.show');
    Route::get('pembayaran/edit-{id}', [VendorPembayaranController::class, 'edit'])->name('vendor.pembayaran.edit');
    Route::put('pembayaran/{id}', [VendorPembayaranController::class, 'update'])->name('vendor.pembayaran.update');
    
    Route::get('riwayat', [VendorRiwayatController::class, 'index'])->name('vendor.riwayat.index');
    Route::get('riwayat/{id}', [VendorRiwayatController::class, 'show'])->name('vendor.riwayat.show');

    Route::get('laporan', [VendorLaporanController::class, 'index'])->name('vendor.laporan.index');
    Route::post('laporan/generate', [VendorLaporanController::class, 'generate'])->name('vendor.laporan.generate');
    Route::get('laporan/cetak', [VendorLaporanController::class, 'cetak'])->name('vendor.laporan.cetak');
});
