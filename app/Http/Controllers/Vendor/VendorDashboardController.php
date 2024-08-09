<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penyewaan;
use App\Models\Tagihan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class VendorDashboardController extends Controller
{
    public function index()
    {
        $vendorId = Auth::user()->vendor_id;
        $currentYear = Carbon::now()->year;
        $startDate = Carbon::create($currentYear, 1, 1);
        $endDate = Carbon::create($currentYear, 12, 31);

        $peminjamanPerBulan = Penyewaan::select(
            DB::raw('MONTH(tanggal_mulai) as bulan'),
            DB::raw('COUNT(*) as jumlah')
        )
            ->where('id_vendor', $vendorId)
            ->whereBetween('tanggal_mulai', [$startDate, $endDate])
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $anggaranPerBulan = Penyewaan::select(
            DB::raw('MONTH(tanggal_mulai) as bulan'),
            DB::raw('SUM(total_biaya) as total')
        )
            ->where('id_vendor', $vendorId)
            ->whereBetween('tanggal_mulai', [$startDate, $endDate])
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $vendorTerbanyakPerBulan = Penyewaan::select(
            DB::raw('MONTH(tanggal_mulai) as bulan'),
            DB::raw('COUNT(*) as jumlah')
        )
            ->where('id_vendor', $vendorId)
            ->whereBetween('tanggal_mulai', [$startDate, $endDate])
            ->groupBy('bulan')
            ->orderBy('bulan')
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
            ->where('id_vendor', $vendorId)
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->get();

        $durasiPerjalanan = Penyewaan::select(
            DB::raw('MONTH(tanggal_mulai) as bulan'),
            DB::raw('AVG(DATEDIFF(tanggal_selesai, tanggal_mulai)) as durasi_rata_rata')
        )
            ->where('id_vendor', $vendorId)
            ->whereBetween('tanggal_mulai', [$startDate, $endDate])
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

            $statusPembayaran = DB::table(function($query) use ($vendorId) {
                $query->select(DB::raw("
                    CASE 
                        WHEN status = 'Lunas' THEN 'Lunas'
                        WHEN status = 'Pending' AND tanggal_jatuh_tempo < CURDATE() THEN 'Overdue'
                        ELSE 'Pending'
                    END as payment_status
                "))
                ->from('tagihan')
                ->where('id_vendor', $vendorId);
            }, 'subquery')
            ->select('payment_status as status', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('payment_status')
            ->get();

        return view('vendor.dashboard.index', compact(
            'peminjamanPerBulan',
            'anggaranPerBulan',
            'vendorTerbanyakPerBulan',
            'pengajuanPerTahun',
            'durasiPerjalanan',
            'statusPembayaran'
        ));
    }
}