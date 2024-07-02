<?php

namespace App\Http\Controllers\Pemeliharaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Laporan;
use PDF;

class PemeliharaanLaporanController extends Controller
{
    public function index()
    {
        $laporanMingguan = Laporan::where('created_at', '>=', now()->subWeek())->get();
        return view('pemeliharaan.laporan.index', compact('laporanMingguan'));
    }

    public function generatePDF()
    {
        $laporanMingguan = Laporan::where('created_at', '>=', now()->subWeek())->get();
        $pdf = PDF::loadView('pemeliharaan.laporan.pdf', compact('laporanMingguan'));
        return $pdf->download('LaporanMingguan_' . now()->format('Ymd') . '.pdf');
    }
}
