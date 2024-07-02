<?php

namespace App\Http\Controllers\Fasilitas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembayaran;

class FasilitasPembayaransController extends Controller
{
    public function index()
    {
        $invoices = Pembayaran::all();
        return view('fasilitas.pembayarans.index', compact('invoices'));
    }

    public function approve($id)
    {
        $invoice = Pembayaran::find($id);
        $invoice->status = 'approved';
        $invoice->save();

        return redirect()->route('fasilitas.pembayarans.index')
            ->with('success', 'Pembayaran invoice berhasil disetujui.');
    }

    public function decline($id)
    {
        $invoice = Pembayaran::find($id);
        $invoice->status = 'declined';
        $invoice->save();

        return redirect()->route('fasilitas.pembayarans.index')
            ->with('success', 'Pembayaran invoice berhasil ditolak.');
    }

    public function pay($id)
    {
        $invoice = Pembayaran::find($id);
        $invoice->status = 'paid';
        $invoice->tanggal_pembayaran = now();
        $invoice->save();

        return redirect()->route('fasilitas.pembayarans.index')
            ->with('success', 'Pembayaran invoice berhasil dibayar.');
    }
}
