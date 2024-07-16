<?php

namespace App\Http\Controllers\Pemeliharaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SuratJalan;
use App\Models\Kendaraan;
use App\Models\Penyewaan;
use App\Models\Denda;
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
                        ->whereNotIn('status', ['Pengajuan Pembayaran', 'Lunas'])
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
                        ->whereNotIn('status', ['Pengajuan Pembayaran', 'Lunas'])
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
        $suratJalan = SuratJalan::where('status', 'Dalam Perjalanan')->findOrFail($id);

        return view('pemeliharaan.surat-jalan.detail', compact('suratJalan'));
    }

    public function done(Request $request, $id)
    {
        $request->validate([
            'kilometer_awal' => 'required|numeric|min:1',
            'kilometer_akhir' => 'required|numeric|min:1',
            'bukti_biaya_bbm_tol_parkir' => 'required|array',
            'bukti_biaya_bbm_tol_parkir.*' => 'image|mimes:jpeg,png|max:2048',
            'jumlah_biaya_bbm' => 'required|numeric|min:500',
            'jumlah_biaya_tol' => 'required|numeric|min:500',
            'jumlah_biaya_parkir' => 'required|numeric|min:500',
            'bukti_lainnya' => 'nullable|array',
            'bukti_lainnya.*' => 'image|mimes:jpeg,png|max:2048',
            'lebih_hari_input' => 'nullable|numeric',
            'keterangan' => 'nullable|string',
        ], [
            'kilometer_awal.required' => 'Kilometer awal harus diisi.',
            'kilometer_awal.numeric' => 'Kilometer awal harus berupa angka.',
            'kilometer_awal.min' => 'Kilometer awal harus lebih dari 0.',
            'kilometer_akhir.required' => 'Kilometer akhir harus diisi.',
            'kilometer_akhir.numeric' => 'Kilometer akhir harus berupa angka.',
            'kilometer_akhir.min' => 'Kilometer akhir harus lebih dari 0.',
            'bukti_biaya_bbm_tol_parkir.required' => 'Bukti biaya BBM, TOL, dan parkir harus diunggah.',
            'bukti_biaya_bbm_tol_parkir.array' => 'Bukti biaya BBM, TOL, dan parkir harus berupa kumpulan file.',
            'bukti_biaya_bbm_tol_parkir.*.image' => 'File bukti biaya BBM, TOL, dan parkir harus berupa gambar.',
            'bukti_biaya_bbm_tol_parkir.*.mimes' => 'File bukti biaya BBM, TOL, dan parkir harus berformat JPG atau PNG.',
            'bukti_biaya_bbm_tol_parkir.*.max' => 'Ukuran file bukti biaya BBM, TOL, dan parkir tidak boleh lebih dari 2MB.',
            'jumlah_biaya_bbm.required' => 'Jumlah biaya BBM harus diisi.',
            'jumlah_biaya_bbm.numeric' => 'Jumlah biaya BBM harus berupa angka.',
            'jumlah_biaya_bbm.min' => 'Jumlah biaya BBM harus lebih dari 500.',
            'jumlah_biaya_tol.required' => 'Jumlah TOL harus diisi.',
            'jumlah_biaya_tol.numeric' => 'Jumlah TOL harus berupa angka.',
            'jumlah_biaya_tol.min' => 'Jumlah TOL harus lebih dari 500.',
            'jumlah_biaya_parkir.required' => 'Jumlah parkir harus diisi.',
            'jumlah_biaya_parkir.numeric' => 'Jumlah parkir harus berupa angka.',
            'jumlah_biaya_parkir.min' => 'Jumlah parkir harus lebih dari 500.',
            'bukti_lainnya.array' => 'Bukti lainnya harus berupa kumpulan file.',
            'bukti_lainnya.*.image' => 'File bukti lainnya harus berupa gambar.',
            'bukti_lainnya.*.mimes' => 'File bukti lainnya harus berformat JPG atau PNG.',
            'bukti_lainnya.*.max' => 'Ukuran file bukti lainnya tidak boleh lebih dari 2MB.',
            'lebih_hari_input.numeric' => 'Jumlah hari lebih harus berupa angka.',
            'keterangan.string' => 'Keterangan harus berupa teks.',
        ]);
    
    
        $suratJalan = SuratJalan::where('status', 'Dalam Perjalanan')->findOrFail($id);
    
        $penyewaan = Penyewaan::find($suratJalan->id_penyewaan);
    
        $penyewaan->kilometer_awal = $request->kilometer_awal;
        $penyewaan->kilometer_akhir = $request->kilometer_akhir;
        $penyewaan->biaya_bbm = $request->jumlah_biaya_bbm;
        $penyewaan->biaya_tol = $request->jumlah_biaya_tol;
        $penyewaan->biaya_parkir = $request->jumlah_biaya_parkir;
        $penyewaan->keterangan = $request->keterangan;
    
        if ($request->hasFile('bukti_biaya_bbm_tol_parkir')) {
            $biayaPaths = [];
            foreach ($request->file('bukti_biaya_bbm_tol_parkir') as $file) {
                $path = $file->store('bukti_biaya_bbm_tol_parkir/' . $penyewaan->vendor->nama . '/' . $penyewaan->nama_penyewa, 'public');
                $biayaPaths[] = $path;
            }
            $suratJalan->bukti_biaya_bbm_tol_parkir = json_encode($biayaPaths);
        }
    
        if ($request->hasFile('bukti_lainnya')) {
            $buktiPaths = [];
            foreach ($request->file('bukti_lainnya') as $file) {
                $path = $file->store('bukti_lainnya/' . $penyewaan->vendor->nama . '/' . $penyewaan->nama_penyewa, 'public');
                $buktiPaths[] = $path;
            }
            $suratJalan->bukti_lainnya = json_encode($buktiPaths);
        }
    
        if ($request->lebih_hari_input != null) {
            $denda = Denda::findOrFail(1);
        
            $nilaiSewa = $penyewaan->is_outside_bandung ? 275000 : 250000;
            $biayaDriver = $penyewaan->is_outside_bandung ? 175000 : 150000;

            $totalNilaiSewa = $nilaiSewa * $penyewaan->jumlah_hari_sewa;
            $totalBiayaDriver = $biayaDriver * $penyewaan->jumlah_hari_sewa;

            $totalSewa = $totalNilaiSewa + $totalBiayaDriver + $penyewaan->biaya_bbm + $penyewaan->biaya_tol + $penyewaan->biaya_parkir;

            $totalDenda = $denda->jumlah_denda * $request->lebih_hari_input;

            $totalBiaya = $totalSewa + $totalDenda;

            $penyewaan->nilai_sewa = $totalNilaiSewa;
            $penyewaan->biaya_driver = $totalBiayaDriver;
            $penyewaan->total_biaya = $totalBiaya;
        
            $suratJalan->is_lebih_hari = 1;
            $suratJalan->lebih_hari = $request->lebih_hari_input;
            $suratJalan->jumlah_denda = $totalDenda;
        } else {
            $nilaiSewa = $penyewaan->is_outside_bandung ? 275000 : 250000;
            $biayaDriver = $penyewaan->is_outside_bandung ? 175000 : 150000;

            $totalNilaiSewa = $nilaiSewa * $penyewaan->jumlah_hari_sewa;
            $totalBiayaDriver = $biayaDriver * $penyewaan->jumlah_hari_sewa;

            $totalSewa = $totalNilaiSewa + $totalBiayaDriver + $penyewaan->biaya_bbm + $penyewaan->biaya_tol + $penyewaan->biaya_parkir;

            $penyewaan->nilai_sewa = $totalNilaiSewa;
            $penyewaan->biaya_driver = $totalBiayaDriver;
            $penyewaan->total_biaya = $totalSewa;

            $suratJalan->is_lebih_hari = 0;
            $suratJalan->lebih_hari = null;
            $suratJalan->jumlah_denda = 0;
        }
        
    
        $kendaraan = Kendaraan::find($penyewaan->id_kendaraan);
    
        $kendaraan->total_kilometer = $request->kilometer_akhir;
        $kendaraan->save();
    
        $penyewaan->nomor_io = rand(100000, 999999);
        $penyewaan->save();

        $suratJalan->status = 'Selesai';
        $suratJalan->save();
    
        return redirect()->route('pemeliharaan.surat-jalan.index')->with('success', 'Surat Jalan berhasil diperbarui.');
    }
}
