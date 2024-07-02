<?php

namespace App\Http\Controllers\Pemeliharaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RiwayatSuratJalan;

class PemeliharaanRiwayatSuratJalanController extends Controller
{
    public function index()
    {
        $riwayatSuratJalan = RiwayatSuratJalan::all();
        return view('pemeliharaan.riwayat-surat-jalan.index', compact('riwayatSuratJalan'));
    }
}
