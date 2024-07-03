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
        $pengajuan = Penyewaan::all();
        
        return view('fasilitas.sewa-kendaraan.index', compact('pengajuan'));
    }

    public function show($id)
    {
        $pengajuan = Penyewaan::find($id);

        $vendors = Vendor::all();

        $drivers = Driver::all();

        return view('fasilitas.sewa-kendaraan.show', compact('pengajuan', 'vendors', 'drivers'));
    }

    public function approve($id)
    {
        $pengajuan = Penyewaan::where('status', 'Pengajuan')->findOrFail($id);
        $pengajuan->status = 'Approved by Fasilitas';
        $pengajuan->reject_notes = null;
        $pengajuan->save();

        return redirect()->route('fasilitas.sewa-kendaraan.index')->with('success', 'Pengajuan berhasil disetujui.');
    }

    public function decline($id)
    {
        $pengajuan = Penyewaan::where('status', 'Pengajuan')->findOrFail($id);
        $pengajuan->status = 'Rejected by Fasilitas';
        $pengajuan->reject_notes = request('reject_notes');
        $pengajuan->save();

        return redirect()->route('fasilitas.sewa-kendaraan.index')->with('success', 'Pengajuan berhasil ditolak.');
    }
}
