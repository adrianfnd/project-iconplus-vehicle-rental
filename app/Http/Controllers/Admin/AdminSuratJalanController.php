<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SuratJalan;
use PDF;

class AdminSuratJalanController extends Controller
{
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
