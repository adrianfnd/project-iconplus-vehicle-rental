<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

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
    
});

// Routes Staff Fasilitas
Route::middleware(['auth', 'role:fasilitas'])->prefix('fasilitas')->group(function () {   
    
});

// Routes Staff Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {   
    
});

// Routes Vendor Penyedia
Route::middleware(['auth', 'role:vendor'])->prefix('vendor')->group(function () {   
    
});