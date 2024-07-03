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
                    ])->whereNotIn('status', ['Surat Jalan'])
                    ->get();

        return view('admin.sewa-kendaraan.index', compact('pengajuan'));
    }

    public function show($id)
    {
        $pengajuan = Penyewaan::whereIn('status', [
                        'Approved by Fasilitas',
                        'Approved by Administrasi',
                        'Approved by Vendor'
                    ])->whereNotIn('status', ['Surat Jalan'])
                    ->findOrFail($id);

        return view('admin.sewa-kendaraan.show', compact('pengajuan'));
    }

    public function approve($id)
    {
        $pengajuan = Penyewaan::where('status', 'Approved by Fasilitas')->findOrFail($id);
        $pengajuan->status = 'Approved by Administrasi';
        $pengajuan->save();

        return redirect()->route('admin.sewa-kendaraan.index')->with('success', 'Pengajuan berhasil disetujui.');
    }
}
