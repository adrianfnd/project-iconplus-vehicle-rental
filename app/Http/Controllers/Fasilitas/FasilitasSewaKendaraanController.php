<?php

namespace App\Http\Controllers\Fasilitas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penyewaan;
use App\Models\Vendor;
use App\Models\Driver;

class FasilitasSewaKendaraanController extends Controller
{
    public function index()
    {
        $pengajuan = Penyewaan::whereIn('status', [
                        'Pengajuan',
                        'Approved by Fasilitas',
                        'Approved by Administrasi',
                        'Approved by Vendor'
                    ])->whereNotIn('status', ['Surat Jalan', 'Pengajuan Pembayaran', 'Lunas'])
                    ->paginate(10);
        
        return view('fasilitas.sewa-kendaraan.index', compact('pengajuan'));
    }

    public function show($id)
    {
        $pengajuan = Penyewaan::whereIn('status', [
                        'Pengajuan',
                        'Approved by Fasilitas',
                        'Approved by Administrasi',
                        'Approved by Vendor'
                    ])->whereNotIn('status', ['Surat Jalan', 'Pengajuan Pembayaran', 'Lunas'])
                    ->findOrFail($id);

        $vendors = Vendor::all();
        $drivers = Driver::all();

        return view('fasilitas.sewa-kendaraan.show', compact('pengajuan', 'vendors', 'drivers'));
    }

    public function approve(Request $request, $id)
    {
        $pengajuan = Penyewaan::where('status', 'Pengajuan')->findOrFail($id);

        $pengajuan->status = 'Approved by Fasilitas';
        $pengajuan->include_driver = $request->include_driver === 'true' ? 1 : 0;
        $pengajuan->id_driver = $request->driver_id;
        $pengajuan->id_vendor = $request->vendor_id;
        $pengajuan->reject_notes = null;
        
        $pengajuan->save();

        return redirect()->route('fasilitas.sewa-kendaraan.index')->with('success', 'Pengajuan berhasil disetujui.');
    }

    public function decline(Request $request, $id)
    {
        $pengajuan = Penyewaan::where('status', 'Pengajuan')->findOrFail($id);
        
        $pengajuan->status = 'Rejected by Fasilitas';
        $pengajuan->reject_notes = $request->reject_notes;
        
        $pengajuan->save();

        return redirect()->route('fasilitas.sewa-kendaraan.index')->with('success', 'Pengajuan berhasil ditolak.');
    }
}
