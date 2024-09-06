<?php

namespace App\Http\Controllers\Fasilitas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penyewaan;
use App\Models\Tagihan;
use App\Models\Vendor;
use App\Models\Kendaraan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FasilitasDashboardController extends Controller
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

        $vendorTerbanyak = Penyewaan::select('id_vendor', DB::raw('COUNT(*) as jumlah'))
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
                WHEN status IN ("Approved by Fasilitas", "Approved by Administrasi", "Approved by Vendor", "Surat Jalan") THEN 1 
                ELSE 0 END) as approved'),
            DB::raw('SUM(CASE 
                WHEN status IN ("Rejected by Vendor", "Rejected by Fasilitas") THEN 1 
                ELSE 0 END) as declined')
        )
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->get();

        $kendaraanNames = Kendaraan::select('nama')->distinct()->get();

        $tersedia = 0;
        $digunakan = 0;
        
        foreach ($kendaraanNames as $kendaraanName) {
            $kendaraanIds = Kendaraan::where('nama', $kendaraanName->nama)->pluck('id');

            $latestPenyewaan = Penyewaan::whereIn('id_kendaraan', $kendaraanIds)
                ->orderBy('tanggal_mulai', 'desc')
                ->first();
        
            if ($latestPenyewaan && $latestPenyewaan->status === 'Surat Jalan') {
                $tagihan = Tagihan::where('id_penyewaan', $latestPenyewaan->id)->first();
        
                if ($tagihan && $tagihan->status === 'Lunas') {
                    $tersedia++;
                } else {
                    $digunakan++;
                }
            } else {
                $tersedia++;
            }
        }
        
        $ketersediaanKendaraan = [
            'tersedia' => $tersedia,
            'digunakan' => $digunakan
        ];

        $pengajuanPerJenisKendaraan = Penyewaan::select(
            'kendaraan.tipe as jenis',
            DB::raw('COUNT(*) as jumlah')
        )
            ->join('kendaraan', 'penyewaan.id_kendaraan', '=', 'kendaraan.id')
            ->whereBetween('penyewaan.tanggal_mulai', [$startDate, $endDate])
            ->groupBy('kendaraan.tipe')
            ->get();

        $waktuResponsPengajuan = Penyewaan::select(
            DB::raw('MONTH(tanggal_mulai) as bulan'),
            DB::raw('AVG(TIMESTAMPDIFF(MINUTE, created_at, updated_at)) as rata_rata_waktu_respon')
        )
            ->whereBetween('tanggal_mulai', [$startDate, $endDate])
            ->whereBetween('penyewaan.tanggal_mulai', [$startDate, $endDate])
            ->groupBy('bulan')
            ->orderBy('bulan')
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

        return view('fasilitas.dashboard.index', compact(
            'peminjamanPerBulan',
            'anggaranPerBulan',
            'vendorTerbanyak',
            'pengajuanPerTahun',
            'ketersediaanKendaraan',
            'pengajuanPerJenisKendaraan',
            'waktuResponsPengajuan',
            'pengeluaranOperasional'
        ));
    }
}
