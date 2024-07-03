<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penyewaan;

class VendorSewaKendaraanController extends Controller
{
    public function index()
    {
        $pengajuan = Penyewaan::all();
        return view('vendor.sewa-kendaraan.index', compact('pengajuan'));
    }

    public function show($id)
    {
        $pengajuan = Penyewaan::find($id);

        return view('vendor.sewa-kendaraan.show', compact('pengajuan'));
    }

    public function approve($id)
    {
        $pengajuan = Penyewaan::find($id);
        $pengajuan->status = 'approved';
        $pengajuan->save();

        return redirect()->route('vendor.sewa-kendaraan.index')
            ->with('success', 'Pengajuan berhasil disetujui.');
    }

    public function decline($id)
    {
        $pengajuan = Penyewaan::find($id);
        $pengajuan->status = 'declined';
        $pengajuan->save();

        return redirect()->route('vendor.sewa-kendaraan.index')
            ->with('success', 'Pengajuan berhasil ditolak.');
    }
}
