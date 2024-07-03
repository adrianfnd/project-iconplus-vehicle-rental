<?php

namespace App\Http\Controllers\Fasilitas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penyewaan;

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

        return view('fasilitas.sewa-kendaraan.show', compact('pengajuan'));
    }

    public function approve($id)
    {
        $pengajuan = Penyewaan::find($id);
        $pengajuan->status = 'Approved by Fasilitasoved';
        $pengajuan->save();

        return redirect()->route('fasilitas.sewa-kendaraan.index')
            ->with('success', 'Pengajuan berhasil disetujui.');
    }

    public function decline($id)
    {
        $pengajuan = Penyewaan::find($id);
        $pengajuan->status = 'Rejected by Fasilitas';
        $pengajuan->save();

        return redirect()->route('fasilitas.sewa-kendaraan.index')
            ->with('success', 'Pengajuan berhasil ditolak.');
    }
}
