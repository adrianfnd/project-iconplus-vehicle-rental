<?php

namespace App\Http\Controllers\Pemeliharaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SuratJalan;
use App\Models\Kendaraan;
use App\Models\Penyewaan;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
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
                        ->paginate(10);

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

    public function showPdf($id)
    {
        $suratJalan = SuratJalan::with('penyewaan')
                            ->findOrFail($id);
                            
        $path = str_replace('storage/', 'app/public/', $suratJalan->link_pdf);

        $pdfPath = storage_path($path);

        if (!$pdfPath) {
            abort(404, 'PDF tidak ditemukan');
        }

        return response()->file($pdfPath);
    }

    public function showDone($id)
    {
        $suratJalan = SuratJalan::with('penyewaan')
                        ->whereIn('status', [
                            'Dalam Perjalanan',
                            'Selesai'
                        ])
                        ->whereNotIn('status', ['Pengajuan Pembayaran'])
                        ->findOrFail($id);

        return view('pemeliharaan.surat-jalan.detail', compact('suratJalan'));
    }

    public function done(Request $request, $id)
    {
        $request->validate([
            'kilometer_awal' => 'required|numeric',
            'kilometer_akhir' => 'required|numeric',
            'bukti_biaya_bbm_tol_parkir' => 'required|array',
            'bukti_biaya_bbm_tol_parkir.*' => 'image|mimes:jpeg,png|max:2048',
            'bukti_lainnya' => 'required|array',
            'bukti_lainnya.*' => 'image|mimes:jpeg,png|max:2048',
            'lebih_hari_input' => 'nullable|numeric',
        ], [
            'kilometer_awal.required' => 'Kilometer awal harus diisi.',
            'kilometer_awal.numeric' => 'Kilometer awal harus berupa angka.',
            'kilometer_akhir.required' => 'Kilometer akhir harus diisi.',
            'kilometer_akhir.numeric' => 'Kilometer akhir harus berupa angka.',
            'bukti_biaya_bbm_tol_parkir.required' => 'Bukti biaya BBM, TOL, dan parkir harus diunggah.',
            'bukti_biaya_bbm_tol_parkir.array' => 'Bukti biaya BBM, TOL, dan parkir harus berupa kumpulan file.',
            'bukti_biaya_bbm_tol_parkir.*.image' => 'File bukti biaya BBM, TOL, dan parkir harus berupa gambar.',
            'bukti_biaya_bbm_tol_parkir.*.mimes' => 'File bukti biaya BBM, TOL, dan parkir harus berformat JPG atau PNG.',
            'bukti_biaya_bbm_tol_parkir.*.max' => 'Ukuran file bukti biaya BBM, TOL, dan parkir tidak boleh lebih dari 2MB.',
            'bukti_lainnya.required' => 'Bukti lainnya harus diunggah.',
            'bukti_lainnya.array' => 'Bukti lainnya harus berupa kumpulan file.',
            'bukti_lainnya.*.image' => 'File bukti lainnya harus berupa gambar.',
            'bukti_lainnya.*.mimes' => 'File bukti lainnya harus berformat JPG atau PNG.',
            'bukti_lainnya.*.max' => 'Ukuran file bukti lainnya tidak boleh lebih dari 2MB.',
            'lebih_hari_input.numeric' => 'Jumlah hari lebih harus berupa angka.',
        ]);

        $suratJalan = SuratJalan::where('status', 'Dalam Perjalanan')->findOrFail($id);

        $penyewaan = Penyewaan::find($suratJalan->id_penyewaan);
        
        $penyewaan->kilometer_awal = $request->kilometer_awal;
        $penyewaan->kilometer_akhir = $request->kilometer_akhir;

        $penyewaan->save();

        $kendaraan = Kendaraan::find($suratJalan->penyewaan->id_kendaraan);

        $kendaraan->total_kilometer = $request->kilometer_akhir;
        $kendaraan->save();

        if ($request->hasFile('bukti_biaya_bbm_tol_parkir')) {
            $biayaPaths = [];
            foreach ($request->file('bukti_biaya_bbm_tol_parkir') as $file) {
                $path = $file->store('bukti_biaya_bbm_tol_parkir', 'public');
                $biayaPaths[] = $path;
            }
            $suratJalan->bukti_biaya_bbm_tol_parkir = json_encode($biayaPaths);
        }

        if ($request->hasFile('bukti_lainnya')) {
            $buktiPaths = [];
            foreach ($request->file('bukti_lainnya') as $file) {
                $path = $file->store('bukti_lainnya', 'public');
                $buktiPaths[] = $path;
            }
            $suratJalan->bukti_lainnya = json_encode($buktiPaths);
        }

        if ($request->has('lebih_dari_hari_sewa')) {
            $suratJalan->is_lebih_hari = 1;
            $suratJalan->lebih_hari = $request->lebih_hari_input;
        } else {
            $suratJalan->is_lebih_hari = 0;
            $suratJalan->lebih_hari = null;
        }

        $suratJalan->status = 'Selesai';
        $suratJalan->save();

        return redirect()->route('pemeliharaan.surat-jalan.index')->with('success', 'Surat Jalan berhasil diperbarui.');
    }
}
