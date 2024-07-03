<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penyewaan;

class VendorSewaKendaraanController extends Controller
{
    public function index()
    {
        $pengajuan = Penyewaan::where('id_vendor', auth()->user()->vendor->id)
                    ->whereIn('status', [
                        'Approved by Administrasi',
                        'Approved by Vendor'
                    ])->whereNotIn('status', ['Surat Jalan'])
                    ->get();

        return view('vendor.sewa-kendaraan.index', compact('pengajuan'));
    }

    public function show($id)
    {
        $pengajuan = Penyewaan::where('id_vendor', auth()->user()->vendor->id)
                    ->whereIn('status', [
                        'Approved by Administrasi',
                        'Approved by Vendor'
                    ])->whereNotIn('status', ['Surat Jalan'])
                    ->findOrFail($id);

        return view('vendor.sewa-kendaraan.show', compact('pengajuan'));
    }

    public function approve($id)
    {
        $pengajuan = Penyewaan::where('id_vendor', auth()->user()->vendor->id)
                    ->where('status', 'Approved by Administrasi')->findOrFail($id);
        $pengajuan->status = 'Surat Jalan';
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
