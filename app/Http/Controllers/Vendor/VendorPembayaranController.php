<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SuratJalan;
use App\Models\Tagihan;
use App\Models\Penyewaan;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class VendorPembayaranController extends Controller
{
    public function index()
    {
        $tagihan = Tagihan::with(['penyewaan'])
                        ->where('id_vendor', auth()->user()->vendor->id)
                        ->whereNotIn('status', ['Lunas'])
                        ->paginate(10);

        return view('vendor.pembayaran.index', compact('tagihan'));
    }

    public function show($id)
    {
        $tagihan = Tagihan::with(['penyewaan'])
                        ->where('id_vendor', auth()->user()->vendor->id)
                        ->whereNotIn('status', ['Lunas'])
                        ->findOrFail($id);

        return view('vendor.pembayaran.show', compact('tagihan'));
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
}
