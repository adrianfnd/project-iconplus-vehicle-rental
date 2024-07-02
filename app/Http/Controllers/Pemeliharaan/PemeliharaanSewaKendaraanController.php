<?php

namespace App\Http\Controllers\Pemeliharaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Penyewaan;
use App\Models\Kendaraan;

class PemeliharaanSewaKendaraanController extends Controller
{
    public function create()
    {
        $kendaraans = Kendaraan::all();

        return view('pemeliharaan.sewa-kendaraan.create', compact('kendaraans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kontak' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'id_kendaraan' => 'required|uuid',
        ]);

        $tanggalMulai = Carbon::parse($request->input('tanggal_mulai'));
        $tanggalSelesai = Carbon::parse($request->input('tanggal_selesai'));
        $jumlahHariSewa = $tanggalMulai->diffInDays($tanggalSelesai) + 1; 

        Penyewaan::create([
            'nama_penyewa' => $request->input('nama'),
            'kontak_penyewa' => $request->input('kontak'),
            'tanggal_mulai' => $tanggalMulai,
            'tanggal_selesai' => $tanggalSelesai,
            'id_kendaraan' => $request->input('id_kendaraan'),
            'jumlah_hari_sewa' => $jumlahHariSewa,
            'status' => 'Pengajuan',
        ]);

        return redirect()->route('pemeliharaan.sewa-kendaraan.index')
            ->with('success', 'Pengajuan berhasil dibuat.');
    }

    public function index()
    {
        $pengajuan = Penyewaan::all();
        return view('pemeliharaan.sewa-kendaraan.index', compact('pengajuan'));
    }
}
