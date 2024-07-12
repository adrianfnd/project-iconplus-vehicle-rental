<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penyewaan;
use App\Models\SuratJalan;

class VendorSewaKendaraanController extends Controller
{
    public function index()
    {
        $pengajuan = Penyewaan::where('id_vendor', auth()->user()->vendor->id)
                    ->whereIn('status', [
                        'Approved by Administrasi',
                        'Approved by Vendor'
                    ])->whereNotIn('status', ['Surat Jalan', 'Pengajuan Pembayaran', 'Lunas'])
                    ->paginate(10);

        return view('vendor.sewa-kendaraan.index', compact('pengajuan'));
    }

    public function show($id)
    {
        $pengajuan = Penyewaan::where('id_vendor', auth()->user()->vendor->id)
                    ->whereIn('status', [
                        'Approved by Administrasi',
                        'Approved by Vendor'
                    ])->whereNotIn('status', ['Surat Jalan', 'Pengajuan Pembayaran', 'Lunas'])
                    ->findOrFail($id);

        $nilaiSewa = $pengajuan->is_outside_bandung ? 275000 : 250000;

        $biayaDriver = $pengajuan->is_outside_bandung ? 175000 : 150000;

        $pengajuan->nilai_sewa = $nilaiSewa;
        $pengajuan->biaya_driver = $biayaDriver;
        $pengajuan->total_nilai_sewa = $nilaiSewa * $pengajuan->jumlah_hari_sewa;
        $pengajuan->total_biaya_driver = $biayaDriver * $pengajuan->jumlah_hari_sewa;

        return view('vendor.sewa-kendaraan.show', compact('pengajuan'));
    }

    public function approve(Request $request, $id)
    {
        $pengajuan = Penyewaan::where('id_vendor', auth()->user()->vendor->id)
                    ->where('status', 'Approved by Administrasi')->findOrFail($id);
                    
        $pengajuan->status = 'Surat Jalan';
        $pengajuan->reject_notes = null;

        $pengajuan->save();

        $suratJalan = New SuratJalan();
        $suratJalan->id_vendor = auth()->user()->vendor->id;
        $suratJalan->id_penyewaan = $pengajuan->id;
        $suratJalan->link_pdf = null;
        $suratJalan->status = 'Surat Jalan';

        $suratJalan->save();

        return redirect()->route('vendor.sewa-kendaraan.index')->with('success', 'Pengajuan berhasil disetujui.');
    }

    public function decline(Request $request, $id)
    {
        $pengajuan = Penyewaan::where('id_vendor', auth()->user()->vendor->id)
                    ->where('status', 'Approved by Administrasi')->findOrFail($id);

        $pengajuan->status = 'Rejected by Vendor';
        $pengajuan->reject_notes = $request->reject_notes;

        $pengajuan->save();

        return redirect()->route('vendor.sewa-kendaraan.index')->with('success', 'Pengajuan berhasil ditolak.');
    }
}
