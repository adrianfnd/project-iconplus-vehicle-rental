<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penyewaan;
use App\Models\Vendor;
use App\Models\Tagihan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $currentYear = Carbon::now()->year;
        $startDate = Carbon::create($currentYear, 1, 1);
        $endDate = Carbon::create($currentYear, 12, 31);

        $peminjamanPerBulan = Penyewaan::select(
            DB::raw('MONTH(tanggal_mulai) as bulan'),
            DB::raw('COUNT(*) as jumlah')
        )
            ->whereBetween('tanggal_mulai', [$startDate, $endDate])
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $anggaranPerBulan = Penyewaan::select(
            DB::raw('MONTH(tanggal_mulai) as bulan'),
            DB::raw('SUM(total_biaya) as total')
        )
            ->whereBetween('tanggal_mulai', [$startDate, $endDate])
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $vendorTerbanyak = Penyewaan::select(
            'id_vendor',
            DB::raw('COUNT(*) as jumlah')
        )
            ->whereBetween('tanggal_mulai', [$startDate, $endDate])
            ->whereNotNull('id_vendor')
            ->groupBy('id_vendor')
            ->orderByDesc('jumlah')
            ->limit(5)
            ->with('vendor')
            ->get();

        $pengajuanPerTahun = Penyewaan::select(
            DB::raw('YEAR(created_at) as tahun'),
            DB::raw('SUM(CASE 
                WHEN status IN ("Pengajuan", "Approved by Fasilitas", "Approved by Administrasi", "Approved by Vendor", "Surat Jalan") THEN 1 
                ELSE 0 END) as approved'),
            DB::raw('SUM(CASE 
                WHEN status IN ("Rejected by Vendor", "Rejected by Fasilitas") THEN 1 
                ELSE 0 END) as declined')
        )
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->get();

        $pengeluaranOperasional = Penyewaan::select(
            DB::raw('MONTH(tanggal_mulai) as bulan'),
            DB::raw('SUM(biaya_bbm) as bbm'),
            DB::raw('SUM(biaya_tol) as tol'),
            DB::raw('SUM(biaya_parkir) as parkir'),
            DB::raw('SUM(biaya_driver) as driver')
        )
            ->whereBetween('tanggal_mulai', [$startDate, $endDate])
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $statusPembayaran = Tagihan::select(
            DB::raw('
                CASE 
                    WHEN status = "Lunas" THEN "Lunas"
                    ELSE "Pending"
                END as status
            '),
            DB::raw('COUNT(*) as jumlah')
        )
            ->groupBy('status')
            ->get();
            
        return view('admin.dashboard.index', compact(
            'peminjamanPerBulan',
            'anggaranPerBulan',
            'vendorTerbanyak',
            'pengajuanPerTahun',
            'pengeluaranOperasional',
            'statusPembayaran'
        ));
    }
}