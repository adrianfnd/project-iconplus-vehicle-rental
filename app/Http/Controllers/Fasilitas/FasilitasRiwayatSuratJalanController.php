<?php

namespace App\Http\Controllers\Fasilitas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RiwayatSuratJalan;

class FasilitasRiwayatSuratJalanController extends Controller
{
    public function index()
    {
        $riwayatSuratJalan = RiwayatSuratJalan::all();
        return view('fasilitas.riwayat-surat-jalan.index', compact('riwayatSuratJalan'));
    }
}
