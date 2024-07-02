<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Laporan;
use PDF;

class AdminLaporanController extends Controller
{
    public function index()
    {
        $laporanMingguan = Laporan::where('created_at', '>=', now()->subWeek())->get();
        return view('admin.laporan.index', compact('laporanMingguan'));
    }

    public function generatePDF()
    {
        $laporanMingguan = Laporan::where('created_at', '>=', now()->subWeek())->get();
        $pdf = PDF::loadView('admin.laporan.pdf', compact('laporanMingguan'));
        return $pdf->download('LaporanMingguan_' . now()->format('Ymd') . '.pdf');
    }
}
