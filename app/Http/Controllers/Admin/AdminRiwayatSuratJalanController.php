<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RiwayatSuratJalan;

class AdminRiwayatSuratJalanController extends Controller
{
    public function index()
    {
        $riwayatSuratJalan = RiwayatSuratJalan::all();
        return view('admin.riwayat-surat-jalan.index', compact('riwayatSuratJalan'));
    }
}
