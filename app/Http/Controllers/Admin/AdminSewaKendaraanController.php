<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penyewaan;

class AdminSewaKendaraanController extends Controller
{
    public function index()
    {
        $pengajuan = Penyewaan::whereIn('status', [
                        'Approved by Fasilitas',
                        'Approved by Administrasi',
                        'Approved by Vendor'
                    ])->whereNotIn('status', ['Surat Jalan', 'Pengajuan Pembayaran', 'Lunas'])
                    ->paginate(10);

        return view('admin.sewa-kendaraan.index', compact('pengajuan'));
    }

    public function show($id)
    {
        $pengajuan = Penyewaan::whereIn('status', [
                        'Approved by Fasilitas',
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

        return view('admin.sewa-kendaraan.show', compact('pengajuan'));
    }

    public function approve(Request $request, $id)
    {
        $pengajuan = Penyewaan::where('status', 'Approved by Fasilitas')->findOrFail($id);
        $pengajuan->status = 'Approved by Administrasi';
        $pengajuan->reject_notes = null;
        
        $pengajuan->save();

        return redirect()->route('admin.sewa-kendaraan.index')->with('success', 'Pengajuan berhasil disetujui.');
    }
}
