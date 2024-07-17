<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Denda;
use App\Models\SuratJalan;
use App\Models\Tagihan;
use App\Models\Penyewaan;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Str;
use PDF;

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
                        ->whereNotIn('status', ['Pengajuan Pembayaran', 'Lunas'])
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
                        ->whereNotIn('status', ['Pengajuan Pembayaran', 'Lunas'])
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

    public function showApprove($id)
    {
        $suratJalan = SuratJalan::with('penyewaan')
                    ->where('id_vendor', auth()->user()->vendor->id)
                    ->where('status', 'Selesai')
                    ->findOrFail($id);

        $denda = Denda::findOrFail(1);

        $nilaiSewa = $suratJalan->penyewaan->is_outside_bandung ? 275000 : 250000;

        $biayaDriver = $suratJalan->penyewaan->is_outside_bandung ? 175000 : 150000;

        $suratJalan->nilai_sewa = $nilaiSewa;
        $suratJalan->biaya_driver = $biayaDriver;
        $suratJalan->denda = $denda->jumlah_denda;

        return view('vendor.surat-jalan.detail', compact('suratJalan'));
    }

    public function approve(Request $request, $id)
    {
        $suratJalan = SuratJalan::with('penyewaan')
                    ->where('id_vendor', auth()->user()->vendor->id)
                    ->where('status', 'Selesai')
                    ->findOrFail($id);
    
        $suratJalan->status = 'Pengajuan Pembayaran';
        $suratJalan->save();
    
        $pengajuan = Penyewaan::where('id_vendor', auth()->user()->vendor->id)
                    ->where('id', $suratJalan->penyewaan->id)
                    ->firstOrFail();
    
        $pengajuan->status = 'Pengajuan Pembayaran';
        $pengajuan->reject_notes = null;
        $pengajuan->save();
    
        $tagihan = new Tagihan();
        $tagihan->id_vendor = auth()->user()->vendor->id;
        $tagihan->id_penyewaan = $suratJalan->penyewaan->id;
        $tagihan->tanggal_terbit = now();
        $tagihan->tanggal_jatuh_tempo = now()->addDays(1);
        $tagihan->total_tagihan = $suratJalan->penyewaan->total_biaya;
        $tagihan->status = 'Pengajuan Pembayaran';
        $tagihan->link_pdf = null;
        $tagihan->save();
    
        return redirect()->route('vendor.surat-jalan.index')->with('success', 'Pengajuan pembayaran berhasil.');
    }
}
