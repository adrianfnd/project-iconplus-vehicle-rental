<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tagihan;
use App\Models\SuratJalan;
use App\Models\Penyewaan;
use App\Models\TandaTangan;
use App\Models\TandaTanganVendor;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use PDF;
use Illuminate\Support\Str;

class AdminPembayaranController extends Controller
{
    public function index()
    {
        $tagihan = Tagihan::with(['penyewaan'])
                        ->whereNotIn('status', ['Lunas'])
                        ->paginate(10);

        return view('admin.pembayaran.index', compact('tagihan'));
    }

    public function show($id)
    {
        $tagihan = Tagihan::with(['penyewaan'])
                        ->whereNotIn('status', ['Lunas'])
                        ->findOrFail($id);

        $suratJalan = SuratJalan::with('penyewaan')
                        ->where('id_penyewaan', $tagihan->id_penyewaan)->first();

        $suratJalan->nilai_sewa = $suratJalan->penyewaan->is_outside_bandung ? 275000 : 250000;

        if ($suratJalan->penyewaan->include_driver == 1) {
            $suratJalan->biaya_driver = $suratJalan->penyewaan->is_outside_bandung ? 175000 : 150000;
        } else {
            $suratJalan->biaya_driver = 0;
        }

        return view('admin.pembayaran.show', compact('tagihan', 'suratJalan'));
    }

    public function approve(Request $request, $id)
    {
        $tagihan = Tagihan::with(['penyewaan'])
                        ->where('status', 'Pengajuan Pembayaran')
                        ->findOrFail($id);
    
        $suratJalan = SuratJalan::where('id_penyewaan', $tagihan->id_penyewaan)->first();
        $pengajuan = Penyewaan::where('id', $tagihan->id_penyewaan)->first();

        $tandaTangan = TandaTangan::where('id', $pengajuan->tanda_tangan_id)->first();

        if ($tandaTangan) {
            $pengajuan->tanda_tangan = $tandaTangan;
        }

        $tandaTanganVendor = TandaTanganVendor::where('id', $pengajuan->tanda_tangan_vendor_id)
                            ->where('id_vendor', $suratJalan->id_vendor)
                            ->first();

        if ($tandaTanganVendor) {
            $pengajuan->tanda_tangan_vendor = $tandaTanganVendor;
        }
                        
        $pdf = PDF::loadView('admin.pembayaran.invoice-pdf', [
            'suratJalan' => $suratJalan,
            'pengajuan' => $pengajuan
        ]);
    
        if ($tagihan->link_pdf) {
            $oldPath = str_replace(Storage::url(''), '', $tagihan->link_pdf);
            if (Storage::exists($oldPath)) {
                Storage::delete($oldPath);
            }
            $filename = basename($oldPath);
        } else {
            $filename = 'invoice_' . Str::random(10) . '.pdf';
        }
    
        $pdfPath = 'public/invoices/' . $pengajuan->vendor->nama . '/' . $pengajuan->nama_penyewa . '/' . $filename;
    
        Storage::put($pdfPath, $pdf->output());
        
        $tagihan->status = 'Approved by Administrasi';
        $tagihan->link_pdf = Storage::url($pdfPath);
        $tagihan->save();
    
        return redirect()->route('admin.pembayaran.index')->with('success', 'Pengajuan pembayaran berhasil disetujui.');
    }

    public function decline(Request $request, $id)
    {
        $tagihan = Tagihan::with(['penyewaan'])
                        ->where('status', 'Pengajuan Pembayaran')
                        ->findOrFail($id);

        $tagihan->status = 'Rejected by Administrasi';
        $tagihan->reject_notes = $request->reject_notes;
        $tagihan->save();

        return redirect()->route('admin.pembayaran.index')->with('success', 'Pengajuan pembayaran berhasil ditolak.');
    }
}
