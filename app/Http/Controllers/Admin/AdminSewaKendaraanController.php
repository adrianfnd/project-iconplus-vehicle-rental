<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SewaKendaraan;

class AdminSewaKendaraanController extends Controller
{
    public function index()
    {
        $pengajuan = SewaKendaraan::all();
        return view('admin.sewa-kendaraan.index', compact('pengajuan'));
    }

    public function approve($id)
    {
        $pengajuan = SewaKendaraan::find($id);
        $pengajuan->status = 'approved';
        $pengajuan->save();

        return redirect()->route('admin.sewa-kendaraan.index')
            ->with('success', 'Pengajuan berhasil disetujui.');
    }
}
