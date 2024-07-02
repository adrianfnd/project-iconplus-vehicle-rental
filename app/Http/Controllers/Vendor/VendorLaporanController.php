<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Laporan;
use PDF;

class VendorLaporanController extends Controller
{
    public function index()
    {
        $laporanMingguan = Laporan::where('created_at', '>=', now()->subWeek())->get();
        return view('vendor.laporan.index', compact('laporanMingguan'));
    }

    public function generatePDF()
    {
        $laporanMingguan = Laporan::where('created_at', '>=', now()->subWeek())->get();
        $pdf = PDF::loadView('vendor.laporan.pdf', compact('laporanMingguan'));
        return $pdf->download('LaporanMingguan_' . now()->format('Ymd') . '.pdf');
    }
}
