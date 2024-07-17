<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SuratJalan;
use App\Models\RiwayatSuratJalan;
use App\Models\Vendor;
use Carbon\Carbon;
use PDF;

class VendorLaporanController extends Controller
{
    public function index()
    {
        return view('vendor.laporan.index');
    }

    public function generate(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ], [
            'start_date.required' => 'Waktu awal harus diisi.',
            'start_date.date' => 'Waktu awal harus berupa tanggal.',
            'end_date.required' => 'Waktu akhir harus diisi.',
            'end_date.date' => 'Waktu akhir harus berupa tanggal.',
            'end_date.after_or_equal' => 'Waktu akhir harus setelah atau sama dengan waktu awal.',
        ]);

        $startDate = Carbon::parse($request->start_date)->startOfDay();
        $endDate = Carbon::parse($request->end_date)->endOfDay();

        $riwayatSuratJalan = RiwayatSuratJalan::with('suratJalan')
            ->where('id_vendor', auth()->user()->vendor->id)
            ->where('sudah_dicetak', false)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        if ($riwayatSuratJalan->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada surat jalan yang perlu dicetak.');
        }

        $selectedVendor = Vendor::find(auth()->user()->vendor->id)->nama;

        return view('vendor.laporan.show', compact('riwayatSuratJalan', 'startDate', 'endDate', 'selectedVendor'));
    }

    public function cetak(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ], [
            'start_date.required' => 'Waktu awal harus diisi.',
            'start_date.date' => 'Waktu awal harus berupa tanggal.',
            'end_date.required' => 'Waktu akhir harus diisi.',
            'end_date.date' => 'Waktu akhir harus berupa tanggal.',
            'end_date.after_or_equal' => 'Waktu akhir harus setelah atau sama dengan waktu awal.',
        ]);
    
        $startDate = Carbon::parse($request->start_date)->startOfDay();
        $endDate = Carbon::parse($request->end_date)->endOfDay();
    
        $riwayatSuratJalan = RiwayatSuratJalan::with('suratJalan')
            ->where('id_vendor', auth()->user()->vendor->id)
            ->where('sudah_dicetak', false)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();
        
        $selectedVendor = Vendor::find(auth()->user()->vendor->id)->nama;
    
        foreach ($riwayatSuratJalan as $item) {
            // $item->sudah_dicetak = 1;
            // $item->start_period = $startDate;
            // $item->end_period = $endDate;
            $item->save();
        }
    
        $pdf = PDF::loadView('vendor.laporan.laporan-pdf', compact('riwayatSuratJalan', 'startDate', 'endDate', 'selectedVendor'));
    
        $fileName = 'Laporan_Surat_Jalan_' . $selectedVendor . '_' . $startDate->format('d-m-Y') . '_' . $endDate->format('d-m-Y') . '.pdf';
    
        return $pdf->download($fileName);
    }
}
