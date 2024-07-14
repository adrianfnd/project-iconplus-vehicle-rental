<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SuratJalan;
use App\Models\Vendor;
use Carbon\Carbon;

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
            $riwayatSuratJalan = SuratJalan::with('penyewaan')
                        ->where('id_vendor', $request->vendor_id)
                        ->where('status', 'Lunas')
                        ->whereBetween('created_at', [$startDate, $endDate])
                        ->get();
        } else {
            $riwayatSuratJalan = SuratJalan::with('penyewaan')
                        ->where('status', 'Lunas')
                        ->whereBetween('created_at', [$startDate, $endDate])
                        ->get();
        }

        $selectedVendor = $request->vendor_id == 'all' ? 'Semua Vendor' : Vendor::find($request->vendor_id)->nama;

        return view('admin.laporan.show', compact('riwayatSuratJalan', 'startDate', 'endDate', 'selectedVendor'));
    }
}