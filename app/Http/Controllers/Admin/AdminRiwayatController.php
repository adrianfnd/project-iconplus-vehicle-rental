<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tagihan;
use App\Models\SuratJalan;
use App\Models\Penyewaan;
use App\Models\RiwayatSuratJalan;
use Illuminate\Support\Facades\Storage;
use PDF;

class AdminRiwayatController extends Controller
{
    public function index()
    {
        $riwayat = RiwayatSuratJalan::with('suratJalan')
                    ->paginate(10);

        return view('admin.riwayat.index', compact('riwayat'));
    }

    public function show($id)
    {
        $riwayat = RiwayatSuratJalan::with('suratJalan')
                    ->findOrFail($id);

        return view('admin.riwayat.show', compact('riwayat'));
    }

    public function showPdf($id)
    {
        $tagihan = Tagihan::findOrFail($id);
        $suratJalan = $tagihan->penyewaan->suratJalan;

        if (!$suratJalan || !$suratJalan->link_pdf) {
            abort(404, 'PDF tidak ditemukan');
        }

        $path = str_replace('storage/', 'app/public/', $suratJalan->link_pdf);
        $pdfPath = storage_path($path);

        if (!file_exists($pdfPath)) {
            abort(404, 'File PDF tidak ditemukan');
        }

        return response()->file($pdfPath);
    }
}