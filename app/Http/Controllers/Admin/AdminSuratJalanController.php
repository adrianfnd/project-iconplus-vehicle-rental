<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SuratJalan;
use Illuminate\Support\Facades\Storage;
use PDF;

class AdminSuratJalanController extends Controller
{
    public function index()
    {
        $suratJalan = SuratJalan::with('penyewaan')
                        ->whereNotIn('status', ['Pengajuan Pembayaran', 'Lunas'])
                        ->paginate(10);

        return view('admin.surat-jalan.index', compact('suratJalan'));
    }

    public function show($id)
    {
        $suratJalan = SuratJalan::with('penyewaan')
                        ->whereNotIn('status', ['Pengajuan Pembayaran', 'Lunas'])
                        ->findOrFail($id);

        $nilaiSewa = $suratJalan->penyewaan->is_outside_bandung ? 275000 : 250000;

        $biayaDriver = $suratJalan->penyewaan->is_outside_bandung ? 175000 : 150000;

        $suratJalan->penyewaan->nilai_sewa = $nilaiSewa;
        $suratJalan->penyewaan->biaya_driver = $biayaDriver;
        $suratJalan->penyewaan->total_nilai_sewa = $nilaiSewa * $suratJalan->penyewaan->jumlah_hari_sewa;
        $suratJalan->penyewaan->total_biaya_driver = $biayaDriver * $suratJalan->penyewaan->jumlah_hari_sewa;

        return view('admin.surat-jalan.show', compact('suratJalan'));
    }

    public function createPDF(Request $request, $id)
    {
        $suratJalan = SuratJalan::with('penyewaan')
                        ->where('status', 'Surat Jalan')
                        ->findOrFail($id);

        $penyewaan = $suratJalan->penyewaan;

        $nilaiSewa = $penyewaan->is_outside_bandung ? 275000 : 250000;

        $biayaDriver = $penyewaan->is_outside_bandung ? 175000 : 150000;

        $penyewaan->nilai_sewa = $nilaiSewa;
        $penyewaan->biaya_driver = $biayaDriver;
        $penyewaan->total_nilai_sewa = $nilaiSewa * $penyewaan->jumlah_hari_sewa;
        $penyewaan->total_biaya_driver = $biayaDriver * $penyewaan->jumlah_hari_sewa;
        $penyewaan->total_biaya = $penyewaan->total_nilai_sewa + $penyewaan->total_biaya_driver;

        $suratJalan->tanggal_terbit = date('Y-m-d');

        $pdf = PDF::loadView('admin.surat-jalan.pdf', compact('suratJalan', 'penyewaan'));

        $fileName = 'surat_jalan_' . $suratJalan->id . '.pdf';
        $pdfPath = 'public/surat-jalan/' . $penyewaan->vendor->nama . '/' . $penyewaan->nama_penyewa . '/' . $fileName;
        Storage::put($pdfPath, $pdf->output());

        $suratJalan->link_pdf = Storage::url($pdfPath);
        $suratJalan->tanggal_terbit = date('Y-m-d');
        $suratJalan->status = 'Dalam Perjalanan';
        $suratJalan->save();

        return redirect()->route('admin.surat-jalan.index')->with('success', 'Surat jalan berhasil dibuat dan dalam perjalanan.');
    }
}
