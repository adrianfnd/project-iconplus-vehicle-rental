<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SuratJalan;
use App\Models\Invoice;

class VendorSuratJalanController extends Controller
{
    public function index()
    {
        $suratJalan = SuratJalan::all();
        return view('vendor.surat-jalan.index', compact('suratJalan'));
    }

    public function createInvoice(Request $request)
    {
        $request->validate([
            'id_surat_jalan' => 'required|uuid',
            'amount' => 'required|numeric',
        ]);

        $invoice = Invoice::create([
            'id_surat_jalan' => $request->id_surat_jalan,
            'amount' => $request->amount,
            'status' => 'pending',
        ]);

        return redirect()->route('vendor.surat-jalan.index')
            ->with('success', 'Pengajuan invoice berhasil dibuat.');
    }
}
