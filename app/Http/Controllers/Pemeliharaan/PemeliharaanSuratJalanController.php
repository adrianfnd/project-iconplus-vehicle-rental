<?php

namespace App\Http\Controllers\Pemeliharaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SuratJalan;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use PDF;

class PemeliharaanSuratJalanController extends Controller
{
    public function index()
    {
        $suratJalan = SuratJalan::with('penyewaan')
                        ->whereIn('status', [
                            'Dalam Perjalanan',
                            'Selesai'
                        ])
                        ->whereNotIn('status', ['Pengajuan Pembayaran'])
                        ->get();

        return view('pemeliharaan.surat-jalan.index', compact('suratJalan'));
    }

    public function show($id)
    {
        $suratJalan = SuratJalan::with('penyewaan')
                        ->whereIn('status', [
                            'Dalam Perjalanan',
                            'Selesai'
                        ])
                        ->whereNotIn('status', ['Pengajuan Pembayaran'])
                        ->findOrFail($id);

        return view('pemeliharaan.surat-jalan.show', compact('suratJalan'));
    }

    public function showPdf($id)
    {
        $suratJalan = SuratJalan::with('penyewaan')
                            ->where('status', 'Dalam Perjalanan')
                            ->findOrFail($id);
                            
        $path = str_replace('storage/', 'app/public/', $suratJalan->link_pdf);

        $pdfPath = storage_path($path);

        if (!$pdfPath) {
            abort(404, 'PDF tidak ditemukan');
        }

        return response()->file($pdfPath);
    }

    public function showDone($id)
    {
        $suratJalan = SuratJalan::with('penyewaan')
                        ->whereIn('status', [
                            'Dalam Perjalanan',
                            'Selesai'
                        ])
                        ->whereNotIn('status', ['Pengajuan Pembayaran'])
                        ->findOrFail($id);

        return view('pemeliharaan.surat-jalan.detail', compact('suratJalan'));
    }

    public function done(Request $request, $id)
    {
        $suratJalan = SuratJalan::where('status', 'Dalam Perjalanan')->findOrFail($id);

        if($request->lebih_hari_checkbox === 'true') {
            $suratJalan->is_lebih_hari = 1;
            $suratJalan->lebih_hari = $request->lebih_hari;
        }
        
        $suratJalan->status = 'Selesai';
        $suratJalan->save();

        return redirect()->route('pemeliharaan.surat-jalan.index')->with('success', 'Surat Jalan berhasil diperbarui.');
    }
}
