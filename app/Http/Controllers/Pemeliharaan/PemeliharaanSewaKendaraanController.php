<?php

namespace App\Http\Controllers\Pemeliharaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Penyewaan;
use App\Models\Kendaraan;
use App\Models\Jabatan;

class PemeliharaanSewaKendaraanController extends Controller
{
    public function index()
    {
        $pengajuan = Penyewaan::all();
        
        return view('pemeliharaan.sewa-kendaraan.index', compact('pengajuan'));
    }

    public function show($id)
    {
        $pengajuan = Penyewaan::find($id);

        return view('pemeliharaan.sewa-kendaraan.show', compact('pengajuan'));
    }

    public function create()
    {
        $kendaraans = Kendaraan::all();

        $jabatans = Jabatan::all();

        return view('pemeliharaan.sewa-kendaraan.create', compact('kendaraans', 'jabatans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kontak' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'kendaraan' => 'required',
        ], [
            'nama.required' => 'Kolom nama harus diisi.',
            'nama.string' => 'Nama harus berupa teks.',
            'nama.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'kontak.required' => 'Kolom kontak harus diisi.',
            'kontak.string' => 'Kontak harus berupa teks.',
            'kontak.max' => 'Kontak tidak boleh lebih dari 255 karakter.',
            'tanggal_mulai.required' => 'Kolom tanggal mulai harus diisi.',
            'tanggal_mulai.date' => 'Kolom tanggal mulai harus berupa tanggal.',
            'tanggal_selesai.required' => 'Kolom tanggal selesai harus diisi.',
            'tanggal_selesai.date' => 'Kolom tanggal selesai harus berupa tanggal.',
            'tanggal_selesai.after_or_equal' => 'Kolom tanggal selesai harus setelah atau sama dengan kolom tanggal mulai.',
            'kendaraan.required' => 'Kolom kendaraan harus diisi.',
        ]);

        $tanggalMulai = Carbon::parse($request->input('tanggal_mulai'));
        $tanggalSelesai = Carbon::parse($request->input('tanggal_selesai'));
        $jumlahHariSewa = $tanggalMulai->diffInDays($tanggalSelesai) + 1; 

        Penyewaan::create([
            'nama_penyewa' => $request->input('nama'),
            'kontak_penyewa' => $request->input('kontak'),
            'tanggal_mulai' => $tanggalMulai,
            'tanggal_selesai' => $tanggalSelesai,
            'id_kendaraan' => $request->input('kendaraan'),
            'jumlah_hari_sewa' => $jumlahHariSewa,
            'status' => 'Pengajuan',
        ]);

        return redirect()->route('pemeliharaan.sewa-kendaraan.index')
            ->with('success', 'Pengajuan berhasil dibuat.');
    }
}
