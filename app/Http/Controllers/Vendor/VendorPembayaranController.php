<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SuratJalan;
use App\Models\Tagihan;
use App\Models\Penyewaan;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class VendorPembayaranController extends Controller
{
    public function index()
    {
        $tagihan = Tagihan::with(['penyewaan'])
                        ->where('id_vendor', auth()->user()->vendor->id)
                        ->whereNotIn('status', ['Lunas'])
                        ->paginate(10);

        return view('vendor.pembayaran.index', compact('tagihan'));
    }

    public function show($id)
    {
        $tagihan = Tagihan::with(['penyewaan'])
                        ->where('id_vendor', auth()->user()->vendor->id)
                        ->whereIn('status', [
                            'Pengajuan Pembayaran',
                            'Approved by Administrasi'
                        ])
                        ->whereNotIn('status', ['Lunas'])
                        ->findOrFail($id);

        $suratJalan = SuratJalan::with('penyewaan')
                        ->where('id_vendor', auth()->user()->vendor->id)
                        ->where('id_penyewaan', $tagihan->id_penyewaan)->first();

        return view('vendor.pembayaran.show', compact('tagihan', 'suratJalan'));
    }

    public function edit($id)
    {
        $tagihan = Tagihan::with(['penyewaan'])
                        ->where('id_vendor', auth()->user()->vendor->id)
                        ->whereIn('status', [
                            'Rejected by Administrasi',
                            'Rejected by Fasilitas'
                        ])
                        ->findOrFail($id);

        $suratJalan = SuratJalan::with('penyewaan')
                        ->where('id_vendor', auth()->user()->vendor->id)
                        ->where('id_penyewaan', $tagihan->id_penyewaan)->first();

        return view('vendor.pembayaran.edit', compact('tagihan', 'suratJalan'));
    }

    public function update(Request $request, $id)
    {
        $tagihan = Tagihan::with(['penyewaan'])
                        ->where('id_vendor', auth()->user()->vendor->id)
                        ->whereIn('status', [
                            'Rejected by Administrasi',
                            'Rejected by Fasilitas'
                        ])
                        ->findOrFail($id);

        $suratJalan = SuratJalan::with('penyewaan')
                        ->where('id_vendor', auth()->user()->vendor->id)
                        ->where('id_penyewaan', $tagihan->id_penyewaan)->first();

        $penyewaan = Penyewaan::findOrFail($tagihan->id_penyewaan);

        $request->validate([
            'kilometer_awal' => 'required|numeric',
            'kilometer_akhir' => 'required|numeric',
            'nilai_sewa' => 'required|numeric',
            'biaya_driver' => 'required|numeric',
            'biaya_bbm' => 'required|numeric',
            'biaya_tol' => 'required|numeric',
            'biaya_parkir' => 'required|numeric',
            'jumlah_denda' => 'numeric',
            'bukti_biaya.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'bukti_lainnya.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $penyewaan->update([
            'kilometer_awal' => $request->kilometer_awal,
            'kilometer_akhir' => $request->kilometer_akhir,
            'nilai_sewa' => $request->nilai_sewa,
            'biaya_driver' => $request->biaya_driver,
            'biaya_bbm' => $request->biaya_bbm,
            'biaya_tol' => $request->biaya_tol,
            'biaya_parkir' => $request->biaya_parkir,
            'keterangan' => $request->keterangan,
        ]);
        
        $suratJalan->update([
            'jumlah_denda' => $request->jumlah_denda ?? 0,
        ]);

        if ($request->hasFile('bukti_biaya')) {
            if ($suratJalan->bukti_biaya_bbm_tol_parkir) {
                foreach (json_decode($suratJalan->bukti_biaya_bbm_tol_parkir) as $oldFile) {
                    Storage::disk('public')->delete($oldFile);
                }
            }
            
            $bukti_biaya = [];
            foreach ($request->file('bukti_biaya') as $file) {
                $path = $file->store('bukti_biaya_bbm_tol_parkir/' . $penyewaan->vendor->nama . '/' . $penyewaan->nama_penyewa, 'public');
                $bukti_biaya[] = $path;
            }
            $suratJalan->bukti_biaya_bbm_tol_parkir = json_encode($bukti_biaya);
        }

        if ($request->hasFile('bukti_lainnya')) {
            if ($suratJalan->bukti_lainnya) {
                foreach (json_decode($suratJalan->bukti_lainnya) as $oldFile) {
                    Storage::disk('public')->delete($oldFile);
                }
            }
            
            $bukti_lainnya = [];
            foreach ($request->file('bukti_lainnya') as $file) {
                $path = $file->store('bukti_lainnya/' . $penyewaan->vendor->nama . '/' . $penyewaan->nama_penyewa, 'public');
                $bukti_lainnya[] = $path;
            }
            $suratJalan->bukti_lainnya = json_encode($bukti_lainnya);
        }

        $suratJalan->status = 'Pengajuan Pembayaran';
        $suratJalan->save();

        $total_biaya = $penyewaan->nilai_sewa + $penyewaan->biaya_driver + $penyewaan->biaya_bbm + $penyewaan->biaya_tol + $penyewaan->biaya_parkir + $suratJalan->jumlah_denda;
        $penyewaan->total_biaya = $total_biaya;
        $penyewaan->status = 'Pengajuan Pembayaran';
        $penyewaan->reject_notes = null;
        $penyewaan->save();

        $tagihan->total_tagihan = $total_biaya;
        $tagihan->status = 'Pengajuan Pembayaran';
        $tagihan->reject_notes = null;
        $tagihan->save();

        return redirect()->route('vendor.pembayaran.index')->with('success', 'Pengajuan pembayaran berhasil dikirim ulang.');
    }
}
