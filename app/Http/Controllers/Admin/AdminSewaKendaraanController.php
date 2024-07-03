<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penyewaan;

class AdminSewaKendaraanController extends Controller
{
    public function index()
    {
        $pengajuan = Penyewaan::all();
        return view('admin.sewa-kendaraan.index', compact('pengajuan'));
    }

    public function show($id)
    {
        $pengajuan = Penyewaan::find($id);

        return view('admin.sewa-kendaraan.show', compact('pengajuan'));
    }

    public function approve($id)
    {
        $pengajuan = Penyewaan::find($id);
        $pengajuan->status = 'approved';
        $pengajuan->save();

        return redirect()->route('admin.sewa-kendaraan.index')
            ->with('success', 'Pengajuan berhasil disetujui.');
    }
}
