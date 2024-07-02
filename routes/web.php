<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Pemeliharaan\PemeliharaanSewaKendaraanController;
use App\Http\Controllers\Pemeliharaan\PemeliharaanSuratJalanController;
use App\Http\Controllers\Pemeliharaan\PemeliharaanRiwayatSuratJalanController;
use App\Http\Controllers\Pemeliharaan\PemeliharaanLaporanController;
use App\Http\Controllers\FasilitasSewaKendaraanController;
use App\Http\Controllers\FasilitasPembayaranController;
use App\Http\Controllers\FasilitasRiwayatSuratJalanController;
use App\Http\Controllers\FasilitasLaporanController;
use App\Http\Controllers\AdminSewaKendaraanController;
use App\Http\Controllers\AdminSuratJalanController;
use App\Http\Controllers\AdminPembayaranController;
use App\Http\Controllers\AdminRiwayatSuratJalanController;
use App\Http\Controllers\AdminLaporanController;
use App\Http\Controllers\VendorSewaKendaraanController;
use App\Http\Controllers\VendorSuratJalanController;
use App\Http\Controllers\VendorPembayaranController;
use App\Http\Controllers\VendorRiwayatSuratJalanController;
use App\Http\Controllers\VendorLaporanController;

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
    Route::get('sewa-kendaraan/create', [PemeliharaanSewaKendaraanController::class, 'create'])->name('pemeliharaan.sewa-kendaraan.create');
    Route::post('sewa-kendaraan', [PemeliharaanSewaKendaraanController::class, 'store'])->name('pemeliharaan.sewa-kendaraan.store');
    
    Route::get('surat-jalan', [PemeliharaanSuratJalanController::class, 'index'])->name('pemeliharaan.surat-jalan.index');
    Route::post('surat-jalan/{id}', [PemeliharaanSuratJalanController::class, 'update'])->name('pemeliharaan.surat-jalan.update');
    Route::get('surat-jalan/{id}/download', [PemeliharaanSuratJalanController::class, 'download'])->name('pemeliharaan.surat-jalan.download');
    
    Route::get('riwayat-surat-jalan', [PemeliharaanRiwayatSuratJalanController::class, 'index'])->name('pemeliharaan.riwayat-surat-jalan.index');
    
    Route::get('laporan-mingguan', [PemeliharaanLaporanController::class, 'index'])->name('pemeliharaan.laporan-mingguan');
    Route::get('laporan-mingguan/generate-pdf', [PemeliharaanLaporanController::class, 'generatePDF'])->name('pemeliharaan.laporan-mingguan.generate-pdf');
});

// Routes Staff Fasilitas
Route::middleware(['auth', 'role:fasilitas'])->prefix('fasilitas')->group(function () {
    Route::get('sewa-kendaraan', [FasilitasSewaKendaraanController::class, 'index'])->name('fasilitas.sewa-kendaraan.index');
    Route::post('sewa-kendaraan/{id}/approve', [FasilitasSewaKendaraanController::class, 'approve'])->name('fasilitas.sewa-kendaraan.approve');
    Route::post('sewa-kendaraan/{id}/decline', [FasilitasSewaKendaraanController::class, 'decline'])->name('fasilitas.sewa-kendaraan.decline');
    
    Route::get('pembayaran', [FasilitasPembayaranController::class, 'index'])->name('fasilitas.pembayaran.index');
    Route::post('pembayaran/{id}/approve', [FasilitasPembayaranController::class, 'approve'])->name('fasilitas.pembayaran.approve');
    Route::post('pembayaran/{id}/decline', [FasilitasPembayaranController::class, 'decline'])->name('fasilitas.pembayaran.decline');
    Route::post('pembayaran/{id}/bayar', [FasilitasPembayaranController::class, 'bayar'])->name('fasilitas.pembayaran.bayar');
    
    Route::get('riwayat-surat-jalan', [FasilitasRiwayatSuratJalanController::class, 'index'])->name('fasilitas.riwayat-surat-jalan.index');
    
    Route::get('laporan-mingguan', [FasilitasLaporanController::class, 'index'])->name('fasilitas.laporan-mingguan');
    Route::get('laporan-mingguan/generate-pdf', [FasilitasLaporanController::class, 'generatePDF'])->name('fasilitas.laporan-mingguan.generate-pdf');
});

// Routes Staff Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('sewa-kendaraan', [AdminSewaKendaraanController::class, 'index'])->name('admin.sewa-kendaraan.index');
    Route::post('sewa-kendaraan/{id}/approve', [AdminSewaKendaraanController::class, 'approve'])->name('admin.sewa-kendaraan.approve');
    
    Route::get('surat-jalan/create', [AdminSuratJalanController::class, 'create'])->name('admin.surat-jalan.create');
    Route::post('surat-jalan', [AdminSuratJalanController::class, 'store'])->name('admin.surat-jalan.store');
    Route::get('surat-jalan', [AdminSuratJalanController::class, 'index'])->name('admin.surat-jalan.index');
    Route::get('surat-jalan/{id}/generate-pdf', [AdminSuratJalanController::class, 'generatePDF'])->name('admin.surat-jalan.generate-pdf');
    
    Route::get('pembayaran', [AdminPembayaranController::class, 'index'])->name('admin.pembayaran.index');
    Route::post('pembayaran/{id}/approve', [AdminPembayaranController::class, 'approve'])->name('admin.pembayaran.approve');
    
    Route::get('riwayat-surat-jalan', [AdminRiwayatSuratJalanController::class, 'index'])->name('admin.riwayat-surat-jalan.index');
    
    Route::get('laporan-mingguan', [AdminLaporanController::class, 'index'])->name('admin.laporan-mingguan');
    Route::get('laporan-mingguan/generate-pdf', [AdminLaporanController::class, 'generatePDF'])->name('admin.laporan-mingguan.generate-pdf');
});

// Routes Vendor Penyedia
Route::middleware(['auth', 'role:vendor'])->prefix('vendor')->group(function () {
    Route::get('sewa-kendaraan', [VendorSewaKendaraanController::class, 'index'])->name('vendor.sewa-kendaraan.index');
    Route::post('sewa-kendaraan/{id}/approve', [VendorSewaKendaraanController::class, 'approve'])->name('vendor.sewa-kendaraan.approve');
    Route::post('sewa-kendaraan/{id}/decline', [VendorSewaKendaraanController::class, 'decline'])->name('vendor.sewa-kendaraan.decline');
    
    Route::get('surat-jalan', [VendorSuratJalanController::class, 'index'])->name('vendor.surat-jalan.index');
    Route::post('surat-jalan', [VendorSuratJalanController::class, 'store'])->name('vendor.surat-jalan.store');
    
    Route::get('pembayaran', [VendorPembayaranController::class, 'index'])->name('vendor.pembayaran.index');
    
    Route::get('riwayat-surat-jalan', [VendorRiwayatSuratJalanController::class, 'index'])->name('vendor.riwayat-surat-jalan.index');
    
    Route::get('laporan-mingguan', [VendorLaporanController::class, 'index'])->name('vendor.laporan-mingguan');
    Route::get('laporan-mingguan/generate-pdf', [VendorLaporanController::class, 'generatePDF'])->name('vendor.laporan-mingguan.generate-pdf');
});
