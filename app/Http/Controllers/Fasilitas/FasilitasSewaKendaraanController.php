<?php

namespace App\Http\Controllers\Fasilitas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SewaKendaraan;

class FasilitasSewaKendaraanController extends Controller
{
    public function index()
    {
        $pengajuan = SewaKendaraan::all();
        return view('fasilitas.sewa-kendaraan.index', compact('pengajuan'));
    }

    public function approve($id)
    {
        $pengajuan = SewaKendaraan::find($id);
        $pengajuan->status = 'approved';
        $pengajuan->save();

        return redirect()->route('fasilitas.sewa-kendaraan.index')
            ->with('success', 'Pengajuan berhasil disetujui.');
    }

    public function decline($id)
    {
        $pengajuan = SewaKendaraan::find($id);
        $pengajuan->status = 'declined';
        $pengajuan->save();

        return redirect()->route('fasilitas.sewa-kendaraan.index')
            ->with('success', 'Pengajuan berhasil ditolak.');
    }
}