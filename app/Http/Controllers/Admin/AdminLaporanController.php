<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SuratJalan;
use App\Models\RiwayatSuratJalan;
use App\Models\Vendor;
use Carbon\Carbon;
use PDF;

class AdminLaporanController extends Controller
{
    public function index()
    {
        $vendors = Vendor::all();
        return view('admin.laporan.index', compact('vendors'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'vendor_id' => 'required|string',
        ]);

        $startDate = Carbon::parse($request->start_date)->startOfDay();
        $endDate = Carbon::parse($request->end_date)->endOfDay();

        if ($request->vendor_id != 'all') {
            $riwayatSuratJalan = RiwayatSuratJalan::with('suratJalan')
                ->where('id_vendor', $request->vendor_id)
                ->where('sudah_dicetak', false)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();
        } else {
            $riwayatSuratJalan = RiwayatSuratJalan::with('suratJalan')
                ->where('sudah_dicetak', false)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();
        }

        if ($riwayatSuratJalan->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada surat jalan yang perlu dicetak.');
        }

        $selectedVendor = $request->vendor_id == 'all' ? 'Semua Vendor' : Vendor::find($request->vendor_id)->nama;

        return view('admin.laporan.show', compact('riwayatSuratJalan', 'startDate', 'endDate', 'selectedVendor'));
    }

    public function cetak(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'vendor_id' => 'required|string',
        ]);
    
        $startDate = Carbon::parse($request->start_date)->startOfDay();
        $endDate = Carbon::parse($request->end_date)->endOfDay();
    
        if ($request->vendor_id != 'all') {
            $riwayatSuratJalan = RiwayatSuratJalan::with('suratJalan')
                ->where('id_vendor', $request->vendor_id)
                ->where('sudah_dicetak', false)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();
        } else {
            $riwayatSuratJalan = RiwayatSuratJalan::with('suratJalan')
                ->where('sudah_dicetak', false)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();
        }
    
        $selectedVendor = $request->vendor_id == 'all' ? 'Semua_Vendor' : Vendor::find($request->vendor_id)->nama;
    
        foreach ($riwayatSuratJalan as $item) {
            $item->sudah_dicetak = 1;
            $item->start_period = $startDate;
            $item->end_period = $endDate;
            $item->save();
        }
    
        $pdf = PDF::loadView('admin.laporan.laporan-pdf', compact('riwayatSuratJalan', 'startDate', 'endDate', 'selectedVendor'));
    
        $fileName = 'Laporan_Surat_Jalan_' . $selectedVendor . '_' . $startDate->format('d-m-Y') . '_' . $endDate->format('d-m-Y') . '.pdf';
    
        return $pdf->download($fileName);
    }
}
