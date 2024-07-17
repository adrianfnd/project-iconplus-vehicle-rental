<?php

namespace App\Http\Controllers\Pemeliharaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tagihan;
use App\Models\SuratJalan;
use App\Models\Penyewaan;
use App\Models\RiwayatSuratJalan;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Storage;
use PDF;

class PemeliharaanRiwayatController extends Controller
{
    public function index()
    {
        $riwayat = RiwayatSuratJalan::with('suratJalan')
                    ->paginate(10);

        return view('pemeliharaan.riwayat.index', compact('riwayat'));
    }

    public function show($id)
    {
        $riwayat = RiwayatSuratJalan::with('suratJalan')
                    ->findOrFail($id);

        $tagihan = Tagihan::with(['penyewaan'])
                    ->where('id_penyewaan', $riwayat->suratJalan->penyewaan->id)
                    ->firstOrFail();

        $pembayaran = Pembayaran::where('id_tagihan', $tagihan->id)
                    ->firstOrFail();

        $nilaiSewa = $riwayat->suratJalan->penyewaan->is_outside_bandung ? 275000 : 250000;

        $biayaDriver = $riwayat->suratJalan->penyewaan->is_outside_bandung ? 175000 : 150000;

        $riwayat->suratJalan->penyewaan->nilai_sewa = $nilaiSewa;
        $riwayat->suratJalan->penyewaan->biaya_driver = $biayaDriver;
        $riwayat->suratJalan->penyewaan->total_nilai_sewa = $nilaiSewa * $riwayat->suratJalan->penyewaan->jumlah_hari_sewa;
        $riwayat->suratJalan->penyewaan->total_biaya_driver = $biayaDriver * $riwayat->suratJalan->penyewaan->jumlah_hari_sewa;

        return view('pemeliharaan.riwayat.show', compact('riwayat', 'tagihan', 'pembayaran'));
    }
}