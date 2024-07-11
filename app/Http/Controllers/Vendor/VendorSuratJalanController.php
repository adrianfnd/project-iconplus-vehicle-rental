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
                        ->where('id_vendor', auth()->user()->vendor->id)
                        ->whereIn('status', [
                            'Dalam Perjalanan',
                            'Selesai'
                        ])
                        ->whereNotIn('status', ['Pengajuan Pembayaran'])
                        ->paginate(10);

        return view('vendor.surat-jalan.index', compact('suratJalan'));
    }

    public function show($id)
    {
        $suratJalan = SuratJalan::with('penyewaan')
                        ->where('id_vendor', auth()->user()->vendor->id)
                        ->whereIn('status', [
                            'Dalam Perjalanan',
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

    public function approve(Request $request, $id)
    {
        $suratJalan = SuratJalan::with('penyewaan')
                    ->where('id_vendor', auth()->user()->vendor->id)
                    ->where('status', 'Selesai')
                    ->findOrFail($id);

        $suratJalan->status = 'Tagihan';
        $suratJalan->save();

        $tagihan = new Tagihan();
        $tagihan->id_penyewaan = $penyewaan->id;
        $tagihan->tanggal_terbit = now();
        $tagihan->tanggal_jatuh_tempo = now()->addDays(1);
        $tagihan->total_tagihan = $suratJalan->penyewaan->total_biaya;
        $tagihan->status = 'Menunggu Pembayaran';

        $tagihan->save();

        return redirect()->route('vendor.surat-jalan.index')->with('success', 'Pengajuan pembayaran berhasil.');
    }
}
