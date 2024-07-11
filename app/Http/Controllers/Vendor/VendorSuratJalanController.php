<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SuratJalan;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class VendorSuratJalanController extends Controller
{
    public function index()
    {
        $suratJalan = SuratJalan::with('penyewaan')
                        ->whereIn('status', [
                            'Selesai'
                        ])
                        ->whereNotIn('status', ['Pengajuan Pembayaran'])
                        ->paginate(10);

        return view('vendor.surat-jalan.index', compact('suratJalan'));
    }

    public function show($id)
    {
        $suratJalan = SuratJalan::with('penyewaan')
                        ->whereIn('status', [
                            'Selesai'
                        ])
                        ->whereNotIn('status', ['Pengajuan Pembayaran'])
                        ->findOrFail($id);

        return view('vendor.surat-jalan.show', compact('suratJalan'));
    }

    public function showPdf($id)
    {
        $suratJalan = SuratJalan::with('penyewaan')
                            ->findOrFail($id);
                            
        $path = str_replace('storage/', 'app/public/', $suratJalan->link_pdf);

        $pdfPath = storage_path($path);

        if (!$pdfPath) {
            abort(404, 'PDF tidak ditemukan');
        }

        return response()->file($pdfPath);
    }
}
