<?php

namespace App\Http\Controllers\Pemeliharaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SuratJalan;
use PDF;

class PemeliharaanSuratJalanController extends Controller
{
    public function index()
    {
        $suratJalan = SuratJalan::with('penyewaan')
                        ->whereIn('status', [
                            'Dalam Perjalanan',
                            'Selesai'
                        ])
                        ->whereNotIn('status', ['Pengajuan Pembayaran'])
                        ->get();

        return view('pemeliharaan.surat-jalan.index', compact('suratJalan'));
    }

    public function show($id)
    {
        $suratJalan = SuratJalan::with('penyewaan')
                        ->whereIn('status', [
                            'Dalam Perjalanan',
                            'Selesai'
                        ])
                        ->whereNotIn('status', ['Pengajuan Pembayaran'])
                        ->findOrFail($id);

        return view('pemeliharaan.surat-jalan.show', compact('suratJalan'));
    }


    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'bukti.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
    //     ]);

    //     $suratJalan = SuratJalan::find($id);
    //     $images = [];

    //     if ($request->hasFile('bukti')) {
    //         foreach ($request->file('bukti') as $file) {
    //             $path = $file->store('bukti', 'public');
    //             $images[] = $path;
    //         }
    //     }

    //     $suratJalan->bukti = json_encode($images);
    //     $suratJalan->save();

    //     return redirect()->route('pemeliharaan.surat-jalan.index')
    //         ->with('success', 'Surat Jalan berhasil diperbarui.');
    // }
}
