<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tagihan;
use App\Models\SuratJalan;
use Illuminate\Support\Facades\Storage;

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

        return view('admin.pembayaran.show', compact('tagihan', 'suratJalan'));
    }

    public function approve(Request $request, $id)
    {
        $tagihan = Tagihan::with(['penyewaan'])
                        ->where('status', 'Pengajuan Pembayaran')
                        ->findOrFail($id);

        $suratJalan = SuratJalan::where('id_penyewaan', $tagihan->id_penyewaan)->first();
        $pengajuan = Penyewaan::where('id', $tagihan->id_penyewaan)->first();
                        
        $pdf = PDF::loadView('vendor.pembayaran.invoice-pdf', [
            'suratJalan' => $suratJalan,
            'pengajuan' => $pengajuan
        ]);

        $filename = 'invoice_' . Str::random(10) . '.pdf';
        $pdfPath = 'public/invoices/' . auth()->user()->vendor->nama . '/' . $filename;
    
        Storage::put($pdfPath, $pdf->output());
        
        $tagihan->status = 'Approved by Administrasi';
        $tagihan->link_pdf = Storage::url($pdfPath);
        $tagihan->save();

        return redirect()->route('admin.sewa-kendaraan.index')->with('success', 'Pengajuan berhasil disetujui.');
    }

    public function decline(Request $request, $id)
    {
        $tagihan = Tagihan::with(['penyewaan'])
                        ->where('status', 'Pengajuan Pembayaran')
                        ->findOrFail($id);

        $tagihan->status = 'Rejected by Administrasi';
        $tagihan->reject_notes = $request->reject_notes;
        $tagihan->save();

        return redirect()->route('admin.sewa-kendaraan.index')->with('success', 'Pengajuan ditolak.');
    }
}
