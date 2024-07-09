<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SuratJalan;
use PDF;

class AdminSuratJalanController extends Controller
{
    public function index()
    {
        $suratJalan = SuratJalan::with('penyewaan')->get();
        return view('admin.surat-jalan.index', compact('suratJalan'));
    }

    public function show($id)
    {
        $suratJalan = SuratJalan::with('penyewaan')
                    // ->whereIn('status', [
                    //     'Approved by Fasilitas',
                    //     'Approved by Administrasi',
                    //     'Approved by Vendor'
                    // ])->whereNotIn('status', ['Surat Jalan'])
                    ->findOrFail($id);

        $nilaiSewa = $suratJalan->penyewaan->is_outside_bandung ? 275000 : 250000;

        $biayaDriver = $suratJalan->penyewaan->is_outside_bandung ? 175000 : 150000;

        $suratJalan->penyewaan->nilai_sewa = $nilaiSewa;
        $suratJalan->penyewaan->biaya_driver = $biayaDriver;
        $suratJalan->penyewaan->total_nilai_sewa = $nilaiSewa * $suratJalan->penyewaan->jumlah_hari_sewa;
        $suratJalan->penyewaan->total_biaya_driver = $biayaDriver * $suratJalan->penyewaan->jumlah_hari_sewa;

        return view('admin.surat-jalan.show', compact('suratJalan'));
    }

    public function create()
    {
        return view('admin.surat-jalan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_penyewaan' => 'required|uuid',
            'tanggal_terbit' => 'required|date',
        ]);

        $suratJalan = SuratJalan::create($request->all());
        
        $pdf = PDF::loadView('admin.surat-jalan.pdf', compact('suratJalan'));

        $pdfPath = storage_path('app/public/surat-jalan/' . $suratJalan->id . '.pdf');
        $pdf->save($pdfPath);

        return response()->download($pdfPath);
    }
}
