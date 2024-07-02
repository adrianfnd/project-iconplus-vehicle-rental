<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RiwayatSuratJalan;

class VendorRiwayatSuratJalanController extends Controller
{
    public function index()
    {
        $riwayatSuratJalan = RiwayatSuratJalan::all();
        return view('vendor.riwayat-surat-jalan.index', compact('riwayatSuratJalan'));
    }
}
