<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tagihan;
use App\Models\SuratJalan;
use Illuminate\Support\Facades\Storage;

class AdminPembayaranController extends Controller
{
    public function index()
    {
        $tagihan = Tagihan::with(['penyewaan'])
                        ->whereNotIn('status', ['Riwayat'])
                        ->paginate(10);

        return view('admin.pembayaran.index', compact('tagihan'));
    }

    public function show($id)
    {
        $tagihan = Tagihan::with(['penyewaan'])
                        ->whereNotIn('status', ['Riwayat'])
                        ->findOrFail($id);

        return view('admin.pembayaran.show', compact('tagihan'));
    }

    public function showPdf($id)
    {
        $tagihan = Tagihan::with(['penyewaan'])->findOrFail($id);
                            
        $path = str_replace('storage/', 'app/public/', $tagihan->link_pdf);

        $pdfPath = storage_path($path);

        if (!$pdfPath) {
            abort(404, 'PDF tidak ditemukan');
        }

        return response()->file($pdfPath);
    }

    public function approve(Request $request, $id)
    {
        $tagihan = Tagihan::with(['penyewaan'])
                        ->where('status', 'Pengajuan Pembayaran')
                        ->findOrFail($id);
        
        $tagihan->status = 'Approved by Administrasi';
        
        $tagihan->save();

        return redirect()->route('admin.sewa-kendaraan.index')->with('success', 'Pengajuan berhasil disetujui.');
    }
}
